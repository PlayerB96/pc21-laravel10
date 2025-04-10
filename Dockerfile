
FROM elrincondeisma/php-for-laravel:8.3.7

WORKDIR /app
COPY . .

# 🔹 Instalar dependencias de PHP
RUN composer install
RUN composer require laravel/octane

# 🔹 Instalar dependencias de Node.js y compilar assets
RUN npm install
RUN npm run build  # Cambia a `npm run dev` si es ambiente de desarrollo

COPY .env .env
RUN mkdir -p /app/storage/logs

RUN php artisan octane:install --server="swoole"

CMD php artisan octane:start --server="swoole" --host="0.0.0.0"
EXPOSE 8000

