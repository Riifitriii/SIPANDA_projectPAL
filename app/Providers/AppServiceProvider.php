<?php

namespace App\Providers;

use App\Listeners\LogAuthenticationActivity;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tetapkan zona waktu lokal Indonesia Barat (WIB)
        date_default_timezone_set(config('app.timezone', 'Asia/Jakarta'));
        \Carbon\Carbon::setLocale('id');

        // Morph Map untuk alias model polimorfik
        Relation::morphMap([
            'pengajuan' => Pengajuan::class,
            'user' => User::class,
        ]);

        // Event listener otomatis untuk pencatatan Login & Logout ke activity_logs
        Event::listen(Login::class, [LogAuthenticationActivity::class, 'handleLogin']);
        Event::listen(Logout::class, [LogAuthenticationActivity::class, 'handleLogout']);
    }
}
