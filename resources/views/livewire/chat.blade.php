<div class="py-6" 
    x-data="{ 
        init() {
            // Auto scroll to bottom when chat updates
            Livewire.on('chat-updated', () => {
                let cont = document.getElementById('messages');
                if (cont) {
                    setTimeout(() => cont.scrollTop = cont.scrollHeight, 50);
                }
            });
            
            // Listen for Echo events globally
            if (window.Echo && window.Laravel && window.Laravel.user) {
                window.Echo.private('chat.' + window.Laravel.user.id)
                    .listen('MessageSent', (e) => {
                        $wire.onMessageSent(e);
                    });
            }
        }
    }">
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex bg-white shadow rounded-lg overflow-visible" style="height:80vh;">
            
            <!-- Left: Users / Search -->
            <div class="w-1/3 border-r p-4 bg-white shadow-lg" id="chat-left">
                <div class="flex items-center mb-4">
                    <input id="search-input" wire:model.live.debounce.300ms="searchQuery" type="text" placeholder="Pencarian" class="w-full rounded-md border-gray-200 px-3 py-2" />
                </div>
                <div class="mb-3 flex gap-2">
                    <button id="filter-all" wire:click="$set('filter', 'all')" class="px-3 py-1 rounded-full text-sm {{ $filter === 'all' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">All</button>
                    <button id="filter-unread" wire:click="$set('filter', 'unread')" class="px-3 py-1 rounded-full text-sm {{ $filter === 'unread' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">Unread</button>
                    <button id="filter-important" wire:click="$set('filter', 'important')" class="px-3 py-1 rounded-full text-sm {{ $filter === 'important' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">Important</button>
                </div>

                <ul id="chat-users" class="space-y-3 overflow-auto h-[calc(80vh-220px)]">
                    @forelse($users as $user)
                        <li wire:click="selectUser({{ $user['id'] }})" class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 cursor-pointer {{ $selectedUserId === $user['id'] ? 'bg-gray-50' : '' }}">
                            <img src="{{ $user['profile_photo_url'] ?? '/images/profile-user.png' }}" class="h-10 w-10 rounded-full" />
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="font-medium truncate">{{ $user['name'] }}</div>
                                    <div class="text-sm text-gray-500 ml-2 truncate max-w-[35%] text-right">{{ $user['email'] }}</div>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <div class="text-sm text-gray-500 truncate">{{ \Illuminate\Support\Str::limit($user['last_message'] ?? '', 30) }}</div>
                                    <div class="text-xs text-gray-400 ms-2 ml-2 text-right">
                                        {{ $user['last_message_at'] ? \Carbon\Carbon::parse($user['last_message_at'])->format('H:i') : '' }}
                                    </div>
                                </div>
                            </div>
                            @if($user['unread_count'] > 0)
                                <div class="text-sm text-gray-400">
                                    <span class="bg-red-500 text-white rounded-full text-xs px-2 py-0.5">{{ $user['unread_count'] }}</span>
                                </div>
                            @endif
                        </li>
                    @empty
                        <div class="text-center text-gray-400 mt-10">Tidak ada kontak.</div>
                    @endforelse
                </ul>
            </div>

            <!-- Right: Conversation -->
            <div class="flex-1 p-4 flex flex-col bg-white shadow-lg relative">
                @if($selectedUser)
                    <div id="chat-header" class="mb-4">
                        <div id="chat-top-bar" class="bg-gradient-to-l from-[#7CC576] to-white rounded-lg p-4 flex items-center gap-4 shadow-sm transition-colors duration-200">
                            <img id="chat-header-avatar" src="{{ $selectedUser->profile_photo_url ?? '/images/profile-user.png' }}" alt="avatar" class="h-14 w-14 rounded-full border-2 border-white object-cover" />
                            <div>
                                <h3 id="chat-header-name" class="text-xl font-semibold tracking-wide">{{ $selectedUser->name }}</h3>
                                <div id="chat-header-sub" class="text-sm text-gray-700">{{ $selectedUser->email }}</div>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 mt-3"></div>
                    </div>

                    <div id="messages" class="flex-1 overflow-auto px-2 pb-4">
                        @foreach($messages as $m)
                            @php
                                $isMine = $m['sender_id'] === auth()->id();
                            @endphp
                            <div class="mb-4 flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="bubble {{ $isMine ? 'bubble--me' : 'bubble--other' }} text-black p-3 max-w-[60%] relative group">
                                    @if($m['body'])
                                        <div class="mb-1">{{ $m['body'] }}</div>
                                    @endif
                                    
                                    @if(!empty($m['attachment_path']))
                                        @php
                                            $ext = strtolower(pathinfo($m['attachment_path'], PATHINFO_EXTENSION));
                                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','svg']);
                                        @endphp
                                        <div class="mt-2">
                                            <a href="/storage/{{ $m['attachment_path'] }}" target="_blank" class="inline-block">
                                                @if($isImage)
                                                    <img src="/storage/{{ $m['attachment_path'] }}" class="max-w-[240px] rounded shadow"/>
                                                @else
                                                    <div class="flex items-center gap-2 text-sm text-blue-600 border rounded p-2 bg-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7v10a4 4 0 004 4h6m-10-14h8l2 2v10a4 4 0 01-4 4H7"/>
                                                        </svg>
                                                        <span>Lampiran File</span>
                                                    </div>
                                                @endif
                                            </a>
                                        </div>
                                    @endif

                                    <div class="text-xs text-gray-500 mt-1 flex items-center justify-end">
                                        {{ \Carbon\Carbon::parse($m['created_at'])->format('H:i') }}
                                        
                                        @if($isMine)
                                            <span class="ms-2 {{ $m['is_read'] ? 'text-blue-500' : 'text-gray-400' }}">
                                                {{ $m['is_read'] ? '✔✔' : '✔' }}
                                            </span>
                                            
                                            <!-- Message Actions Menu -->
                                            <div x-data="{ open: false }" class="relative ms-2">
                                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none">⋮</button>
                                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 w-24 bg-white border rounded shadow z-10 text-sm">
                                                    @if(\Carbon\Carbon::parse($m['created_at'])->diffInMinutes(now()) <= 20)
                                                        <button wire:click="editMessage({{ $m['id'] }})" @click="open = false" class="w-full text-left px-2 py-1 hover:bg-gray-100">Edit</button>
                                                    @endif
                                                    <button wire:click="deleteMessage({{ $m['id'] }})" @click="open = false" class="w-full text-left px-2 py-1 hover:bg-gray-100 text-red-600">Delete</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if(!empty($m['edited_at']))
                                        <span class="text-xs text-gray-400">(edited)</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- File Upload Preview -->
                    @if($attachment)
                        <div class="border-t p-2 bg-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span class="text-sm text-gray-700">Lampiran siap dikirim ({{ $attachmentCategory }})</span>
                            </div>
                            <button wire:click="$set('attachment', null)" class="text-red-500 text-sm hover:underline">Batal</button>
                        </div>
                    @endif

                    <div id="message-form-wrap" class="pt-3 border-t mt-3">
                        <form id="message-form" wire:submit="sendMessage" class="flex gap-2 items-center">
                            
                            @if($isEditing)
                                <div class="bg-yellow-100 px-3 py-1 rounded text-xs text-yellow-800 absolute -top-8 left-10">
                                    Sedang mengedit pesan... <button type="button" wire:click="$set('isEditing', false)" class="font-bold ml-2">Batal</button>
                                </div>
                            @endif

                            <input id="message-input" wire:model="messageBody" type="text" placeholder="Ketik pesan di sini..." class="flex-1 rounded-full border-gray-200 px-4 py-3" autocomplete="off" />

                            <div x-data="{ attachMenu: false }" class="relative">
                                <button type="button" @click="attachMenu = !attachMenu" class="ms-2 p-2 text-gray-600 hover:text-green-600 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.44 11.05L12.36 20.13a5 5 0 01-7.07-7.07l9.19-9.19a3 3 0 014.24 4.24l-9.19 9.19a1 1 0 01-1.41-1.41l9.19-9.19" />
                                    </svg>
                                </button>
                                
                                <div x-show="attachMenu" @click.away="attachMenu = false" class="absolute bottom-12 right-0 w-44 bg-white border rounded shadow p-2 z-50">
                                    <div class="text-sm text-gray-600 mb-2">Pilih lampiran</div>
                                    <div class="space-y-1">
                                        <label class="block px-2 py-1 hover:bg-gray-100 cursor-pointer text-sm">
                                            Foto & Video
                                            <input type="file" wire:model="attachment" class="hidden" accept="image/*,video/*" @change="$wire.set('attachmentCategory', 'foto_video'); attachMenu = false">
                                        </label>
                                        <label class="block px-2 py-1 hover:bg-gray-100 cursor-pointer text-sm">
                                            Dokumen
                                            <input type="file" wire:model="attachment" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" @change="$wire.set('attachmentCategory', 'dokumen'); attachMenu = false">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Livewire upload indicator -->
                            <div wire:loading wire:target="attachment" class="text-xs text-blue-500">Mengunggah...</div>

                            <button id="send-button" type="submit" class="ms-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full disabled:opacity-50" wire:loading.attr="disabled">➤</button>
                        </form>
                    </div>

                @else
                    <!-- Empty State -->
                    <div id="chat-empty" class="flex-1 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-lg font-medium">Siapa yang ingin di chat?</div>
                            <div class="text-sm text-gray-500">Pilih pengguna dari daftar di sebelah kiri untuk memulai percakapan.</div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
