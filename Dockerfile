# Usa imagen oficial de PHP con FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Instala extensiones y dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    gnupg2 \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    pkg-config \
    libicu-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libftp-dev \
    unixodbc-dev \
    && pecl install mongodb-1.21.0 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl sockets ftp \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug


# Instala drivers de Microsoft SQL Server, eliminando paquetes en conflicto
RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc \
      | gpg --dearmor > /etc/apt/trusted.gpg.d/microsoft.gpg && \
    curl -sSL https://packages.microsoft.com/config/debian/11/prod.list \
      > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && \
    # Elimina paquetes con conflicto
    apt-get remove -y libodbc2 odbcinst unixodbc-common unixodbc && \
    ACCEPT_EULA=Y apt-get install -y msodbcsql17 unixodbc-dev && \
    pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv



# Configura el directorio de trabajo
WORKDIR /var/www

# Copia todo el proyecto antes de instalar dependencias
COPY . .

# Copia composer desde una imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Limpia lock y cache, instala dependencias desde cero (incluyendo tu fork)
RUN rm -f composer.lock \
    && composer clear-cache \
    && composer install --no-interaction --prefer-dist --optimize-autoloader

# Crear base de datos SQLite vacía (si no existe)
RUN mkdir -p /var/www/database \
    && touch /var/www/database/database.sqlite \
    && chown -R www-data:www-data /var/www/database

# Instala nodejs y npm para Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@9

# Instala dependencias npm y compila assets
RUN npm install && npm run build

# Da permisos correctos a storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Crear carpeta temporal para mPDF y darle permisos
RUN mkdir -p /var/www/storage/mpdf-temp \
    && chown -R www-data:www-data /var/www/storage/mpdf-temp \
    && chmod -R 775 /var/www/storage/mpdf-temp


# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000

# Comando para arrancar PHP-FPM
CMD php artisan migrate --force && php artisan optimize && php-fpm
