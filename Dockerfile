FROM elrincondeisma/php-for-laravel:8.3.7

# Establece el directorio de trabajo
WORKDIR /app

# Copia todos los archivos del proyecto
COPY . .

# Instala dependencias de PHP
RUN composer install
RUN composer require laravel/octane

# Instala dependencias de Node.js y compila assets
RUN npm install
RUN npm run build  # Usa `npm run dev` si estás en desarrollo

# Copia archivo .env
COPY .env .env

# Asegura que exista la base de datos SQLite (si no existe, la crea vacía)
RUN touch /app/database/database.sqlite

# Asegura que los directorios necesarios existen
RUN mkdir -p /app/storage/logs \
    && mkdir -p /app/bootstrap/cache

# Da permisos necesarios a Laravel
RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache /app/database/database.sqlite

# Instala SQLite (si no está disponible en la imagen base)
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev

# Instala Octane con Swoole
RUN php artisan octane:install --server="swoole"

# Expone el puerto donde correrá Laravel Octane
EXPOSE 8000

# Comando de arranque
CMD php artisan octane:start --server="swoole" --host="0.0.0.0"
