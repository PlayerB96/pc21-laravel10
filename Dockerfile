FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    gnupg \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip pcntl \
    && pecl install swoole \
    && docker-php-ext-enable swoole

# 🔹 Instala Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN composer require laravel/octane

RUN npm install
RUN npm run build

COPY .env .env

RUN touch /app/database/database.sqlite \
    && mkdir -p /app/storage/logs /app/bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache /app/database/database.sqlite

RUN php artisan octane:install --server=swoole

EXPOSE 8000

CMD php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
