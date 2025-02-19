
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



# FROM elrincondeisma/php-for-laravel:8.3.7

# WORKDIR /app
# COPY . .

# # 🔹 Instalar dependencias de PHP
# RUN composer install --no-interaction --optimize-autoloader
# RUN composer require laravel/octane

# # 🔹 Instalar dependencias de Node.js y compilar assets
# RUN npm install
# RUN npm run build  # Cambia a `npm run dev` si es ambiente de desarrollo

# # 🔹 Asegurar permisos de Laravel
# RUN mkdir -p /app/storage/logs /app/bootstrap/cache
# RUN chmod -R 777 /app/storage /app/bootstrap/cache

# # 🔹 Generar clave de aplicación si no existe
# RUN if [ ! -f ".env" ]; then cp .env.example .env; fi
# RUN php artisan key:generate

# # 🔹 Limpiar y cachear configuración
# RUN php artisan config:clear && php artisan cache:clear
# RUN php artisan config:cache

# # 🔹 Instalar y preparar Octane con Swoole
# RUN php artisan octane:install --server="swoole"

# CMD php artisan octane:start --server="swoole" --host="0.0.0.0"
# EXPOSE 8000
