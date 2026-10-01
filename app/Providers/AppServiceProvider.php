<?php

namespace App\Providers;

use App\Listeners\LogAuthenticationActivity;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
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

        // Gunakan pagination Tailwind bawaan yang otomatis dioverride oleh resources/views/vendor/pagination/tailwind.blade.php
        Paginator::useTailwind();

        // Morph Map untuk alias model polimorfik
        Relation::morphMap([
            'pengajuan' => Pengajuan::class,
            'user' => User::class,
        ]);

        // Event listener otomatis untuk pencatatan Login & Logout ke activity_logs
        Event::listen(Login::class, [LogAuthenticationActivity::class, 'handleLogin']);
        Event::listen(Logout::class, [LogAuthenticationActivity::class, 'handleLogout']);

        // Sinkronisasi otomatis gambar dari storage ke public/uploads agar tidak crack saat folder project dipindah
        try {
            $storageSubmissions = storage_path('app/public/submissions');
            $publicUploads = public_path('uploads/submissions');
            if (is_dir($storageSubmissions)) {
                if (!is_dir($publicUploads)) {
                    @mkdir($publicUploads, 0755, true);
                }
                $files = @scandir($storageSubmissions);
                if ($files) {
                    foreach ($files as $file) {
                        if ($file !== '.' && $file !== '..' && is_file($storageSubmissions . DIRECTORY_SEPARATOR . $file)) {
                            $targetFile = $publicUploads . DIRECTORY_SEPARATOR . $file;
                            if (!file_exists($targetFile)) {
                                @copy($storageSubmissions . DIRECTORY_SEPARATOR . $file, $targetFile);
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Abaikan error sync
        }
    }
}
