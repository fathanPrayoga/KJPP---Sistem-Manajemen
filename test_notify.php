<?php
$user = \App\Models\User::where('role', 'client')->first();
if ($user) {
    $user->notify(new \App\Notifications\SystemNotification('Sistem notifikasi database Anda kini telah aktif! Semua pemberitahuan akan tersimpan per-akun dengan aman.', 'success'));
    echo "Notification sent to {$user->name}\n";
} else {
    echo "No client found\n";
}
