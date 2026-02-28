# Usa PHP 8.2 FPM basado en Debian 12 (bookworm)
FROM php:8.2-fpm-bookworm

# -----------------------------
# Instala dependencias del sistema
# -----------------------------
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
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# -----------------------------
# Instala extensiones PHP
# -----------------------------
RUN pecl install mongodb-1.21.0 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        sockets \
        ftp \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# -----------------------------
# Instala drivers Microsoft SQL Server
# -----------------------------
RUN set -eux; \
    curl -sSL https://packages.microsoft.com/keys/microsoft.asc \
        | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg; \
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft-prod.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
        > /etc/apt/sources.list.d/mssql-release.list; \
    apt-get update; \
    ACCEPT_EULA=Y apt-get install -y --no-install-recommends \
        msodbcsql18 \
        unixodbc-dev; \
    pecl install sqlsrv pdo_sqlsrv; \
    docker-php-ext-enable sqlsrv pdo_sqlsrv; \
    rm -rf /var/lib/apt/lists/*

# -----------------------------
# Configura directorio de trabajo
# -----------------------------
WORKDIR /var/www

# Copia el proyecto
COPY . .

# Copia composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -----------------------------
# Instala dependencias PHP
# -----------------------------
RUN rm -f composer.lock \
    && composer clear-cache \
    && composer install --no-interaction --prefer-dist --optimize-autoloader

# -----------------------------
# Base SQLite (si aplica)
# -----------------------------
RUN mkdir -p /var/www/database \
    && touch /var/www/database/database.sqlite \
    && chown -R www-data:www-data /var/www/database

# -----------------------------
# Instala dependencias Node y compila assets
# -----------------------------
RUN npm install \
    && npm run build

# -----------------------------
# Permisos Laravel
# -----------------------------
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Carpeta temporal para mPDF
RUN mkdir -p /var/www/storage/mpdf-temp \
    && chown -R www-data:www-data /var/www/storage/mpdf-temp \
    && chmod -R 775 /var/www/storage/mpdf-temp

# -----------------------------
# Expone puerto PHP-FPM
# -----------------------------
EXPOSE 9000

# -----------------------------
# Comando inicio
# -----------------------------
CMD php artisan migrate --force && php artisan optimize && php-fpm