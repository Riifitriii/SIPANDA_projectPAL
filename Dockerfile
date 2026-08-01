# Stage 1: Build assets menggunakan Node.js
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Environment PHP 8.2-FPM & Nginx Production
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Install dependencies sistem
RUN apk add --no-cache \
    nginx \
    bash \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev

# Install PHP extensions yang diperlukan Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip opcache gd intl bcmath

# Copy Composer dari image official
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin source code proyek
COPY . .

# Salin asset yang sudah dicompile dari Stage 1
COPY --from=node-builder /app/public/build ./public/build

# Atur permission untuk direktori Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan composer install untuk production (tanpa dev dependencies)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Salin konfigurasi Nginx kustom
COPY nginx.conf /etc/nginx/nginx.conf

# Salin entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN apk add --no-cache dos2unix && dos2unix /usr/local/bin/docker-entrypoint.sh && chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port (Render akan menggunakan $PORT secara dinamis)
EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
