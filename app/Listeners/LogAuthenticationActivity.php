<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthenticationActivity
{
    /**
     * Catat aktivitas login pengguna.
     */
    public function handleLogin(Login $event): void
    {
        if ($event->user) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'login',
                'description' => "Pengguna {$event->user->name} ({$event->user->email}) berhasil login ke sistem",
                'subject_type' => 'user',
                'subject_id' => $event->user->id,
            ]);
        }
    }

    /**
     * Catat aktivitas logout pengguna.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'action' => 'logout',
                'description' => "Pengguna {$event->user->name} ({$event->user->email}) telah logout dari sistem",
                'subject_type' => 'user',
                'subject_id' => $event->user->id,
            ]);
        }
    }
}
