FROM php:8.2-fpm-alpine

# Install dependensi sistem yang diperlukan untuk PHP
RUN apk add --no-cache \
    nginx \
    mysql-client \
    curl \
    git \
    build-base \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    gd \
    gd-dev

# Install PHP extensions yang umum digunakan untuk Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Ganti user untuk menjalankan aplikasi
RUN adduser -D -u 1000 www
USER www

# Expose port (opsional, karena FPM berkomunikasi melalui socket/network)
EXPOSE 9000

# Command yang dijalankan saat container dimulai (PHP-FPM)
CMD ["php-fpm"]