#!/bin/sh
set -e

# Mengatur port Nginx secara dinamis sesuai variable $PORT dari Render
if [ -n "$PORT" ]; then
    echo "Mengatur port Nginx ke $PORT..."
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/nginx.conf
    sed -i "s/listen \[::\]:80;/listen [::]:$PORT;/g" /etc/nginx/nginx.conf
fi

# Jalankan migrasi database (force untuk production)
echo "Menjalankan migrasi database..."
php artisan migrate --force

# Optimasi caching Laravel
echo "Mengoptimalkan konfigurasi Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan PHP-FPM di background
echo "Memulai PHP-FPM..."
php-fpm -D

# Jalankan Nginx di foreground
echo "Memulai Nginx..."
exec nginx -g "daemon off;"
