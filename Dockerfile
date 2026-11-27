# Imagen de producción de Fixaro (Laravel + Livewire) para Render.
# La app vive en "Fixaro v 0.1/app"; este Dockerfile está en la raíz del repo.

# 1) Compilar los assets de Vite (Tailwind + Alpine)
FROM node:22-alpine AS assets
WORKDIR /app
COPY ["Fixaro v 0.1/app/package.json", "Fixaro v 0.1/app/package-lock.json", "./"]
RUN npm ci --ignore-scripts
COPY ["Fixaro v 0.1/app/", "./"]
RUN npm run build

# 2) Servidor PHP 8.4 + Apache
FROM php:8.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libicu-dev libzip-dev unzip git \
    && docker-php-ext-install pdo_pgsql pgsql intl zip bcmath opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
    COMPOSER_ALLOW_SUPERUSER=1 \
    PORT=10000

RUN a2enmod rewrite headers \
    && sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!Listen 80!Listen ${PORT}!' /etc/apache2/ports.conf \
    && sed -ri 's!<VirtualHost \*:80>!<VirtualHost *:${PORT}>!' /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n</Directory>\n' > /etc/apache2/conf-available/fixaro.conf \
    && a2enconf fixaro \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'upload_max_filesize=10M\npost_max_size=12M\nmemory_limit=256M\n' > "$PHP_INI_DIR/conf.d/fixaro.ini"

WORKDIR /var/www/html

# Dependencias de PHP primero (aprovecha la caché de Docker)
COPY ["Fixaro v 0.1/app/composer.json", "Fixaro v 0.1/app/composer.lock", "./"]
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY ["Fixaro v 0.1/app/", "./"]
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY deploy/start.sh /usr/local/bin/start-fixaro
RUN chmod +x /usr/local/bin/start-fixaro

EXPOSE 10000
CMD ["start-fixaro"]
