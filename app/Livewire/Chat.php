<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Chat extends Component
{
    use WithFileUploads;

    public $searchQuery = '';
    public $filter = 'all';
    
    public $users = [];
    public $selectedUserId = null;
    public $selectedUser = null;
    
    public $messages = [];
    
    public $messageBody = '';
    public $attachment;
    public $attachmentCategory = '';
    
    public $isEditing = false;
    public $editingMessageId = null;

    public function mount()
    {
        $this->loadUsers();
    }

    public function updatedSearchQuery()
    {
        $this->loadUsers();
    }

    public function updatedFilter()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $me = Auth::user();
        $meId = $me->id;
        
        $query = User::where('id', '!=', $meId);

        if ($me->role === 'client') {
            $query->where('role', 'karyawan');
        } elseif ($me->role === 'karyawan') {
            $query->whereIn('role', ['client', 'pekerjaTambahan']);
        } elseif ($me->role === 'pekerjaTambahan') {
            $query->where('role', 'karyawan');
        }

        if ($this->searchQuery) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        $users = $query->get()->map(function ($u) use ($meId) {
            // Get last message between me and this user
            $lastMessage = Message::where(function($q) use ($meId, $u) {
                $q->where('sender_id', $meId)->where('recipient_id', $u->id);
            })->orWhere(function($q) use ($meId, $u) {
                $q->where('sender_id', $u->id)->where('recipient_id', $meId);
            })->orderBy('created_at', 'desc')->first();

            $unreadCount = Message::where('sender_id', $u->id)
                ->where('recipient_id', $meId)
                ->where('is_read', false)
                ->count();

            $u->last_message = $lastMessage ? $lastMessage->body : '';
            $u->last_message_at = $lastMessage ? $lastMessage->created_at : null;
            $u->unread_count = $unreadCount;
            // mock important filter for now
            $u->important = false; 

            return $u;
        });

        // apply filter
        if ($this->filter === 'unread') {
            $users = $users->filter(fn($u) => $u->unread_count > 0);
        } elseif ($this->filter === 'important') {
            $users = $users->filter(fn($u) => $u->important);
        }

        // sort by last message
        $this->users = $users->sortByDesc('last_message_at')->values()->toArray();
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        
        // Mark as read
        Message::where('sender_id', $userId)
            ->where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
            
        $this->loadConversation();
        $this->loadUsers(); // update unread badges
        
        // Dispatch browser event to scroll to bottom
        $this->dispatch('chat-updated');
    }

    public function loadConversation()
    {
        if (!$this->selectedUserId) return;
        
        $meId = Auth::id();
        $userId = $this->selectedUserId;
        
        $this->messages = Message::where(function ($q) use ($meId, $userId) {
            $q->where('sender_id', $meId)->where('recipient_id', $userId);
        })->orWhere(function ($q) use ($meId, $userId) {
            $q->where('sender_id', $userId)->where('recipient_id', $meId);
        })->orderBy('created_at', 'asc')->get()->toArray();
    }

    public function sendMessage()
    {
        if (!$this->selectedUserId) return;
        if (empty($this->messageBody) && !$this->attachment) return;

        $data = [
            'sender_id' => Auth::id(),
            'recipient_id' => $this->selectedUserId,
            'body' => $this->messageBody,
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('attachments', 'public');
            $data['attachment_path'] = $path;
            if ($this->attachmentCategory) {
                $data['attachment_category'] = $this->attachmentCategory;
            }
        }

        if ($this->isEditing && $this->editingMessageId) {
            $msg = Message::find($this->editingMessageId);
            if ($msg && $msg->sender_id === Auth::id()) {
                $msg->update($data);
                $this->isEditing = false;
                $this->editingMessageId = null;
            }
        } else {
            $msg = Message::create($data);
            broadcast(new \App\Events\MessageSent($msg))->toOthers();
        }

        $this->messageBody = '';
        $this->attachment = null;
        $this->attachmentCategory = '';
        
        $this->loadConversation();
        $this->loadUsers();
        
        $this->dispatch('chat-updated');
    }

    public function editMessage($id)
    {
        $msg = Message::find($id);
        if ($msg && $msg->sender_id === Auth::id()) {
            $this->messageBody = $msg->body;
            $this->isEditing = true;
            $this->editingMessageId = $id;
        }
    }

    public function deleteMessage($id)
    {
        $msg = Message::find($id);
        if ($msg && $msg->sender_id === Auth::id()) {
            if ($msg->attachment_path) {
                Storage::disk('public')->delete($msg->attachment_path);
            }
            $msg->delete();
            $this->loadConversation();
        }
    }

    public function onMessageSent($eventData)
    {
        // When a websocket message is received
        $this->loadUsers();
        
        $msg = $eventData['message'] ?? null;
        if ($msg) {
            // If the message belongs to the current conversation
            if ($this->selectedUserId && ($msg['sender_id'] == $this->selectedUserId || $msg['recipient_id'] == $this->selectedUserId)) {
                $this->loadConversation();
                
                // Mark as read immediately if window is active
                if ($msg['sender_id'] == $this->selectedUserId) {
                    Message::where('id', $msg['id'])->update(['is_read' => true, 'read_at' => now()]);
                }
                
                $this->dispatch('chat-updated');
            }
        }
    }

    public function render()
    {
        return view('livewire.chat')->layout('layouts.app');
    }
}
