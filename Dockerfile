FROM php:8.4-apache-bookworm AS dependencies

RUN apt-get update \
    && apt-get install -y \
    git unzip libzip-dev libicu-dev \
    libpng-dev libonig-dev \
    && docker-php-ext-install \
    pdo_mysql mbstring intl zip bcmath gd \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN mkdir -p \
    storage/app/public \
    storage/app/private \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    && composer check-platform-reqs --no-dev

FROM node:22-bookworm-slim AS frontend

WORKDIR /app
COPY package.json package-lock.json .npmrc ./
RUN npm ci

COPY . .
COPY --from=dependencies /var/www/html/vendor ./vendor
RUN npm run build

FROM dependencies AS runtime

WORKDIR /var/www/html
COPY --from=frontend /app/public/build ./public/build

RUN sed -i \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    && sed -i \
    's/Listen 80/Listen 10000/' \
    /etc/apache2/ports.conf \
    && sed -i \
    's/:80>/:10000>/' \
    /etc/apache2/sites-available/000-default.conf \
    && printf '%s\n' \
    '<Directory /var/www/html/public>' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' \
    > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel \
    && printf '%s\n' \
    'upload_max_filesize=5M' \
    'post_max_size=10M' \
    > /usr/local/etc/php/conf.d/uploads.ini

RUN sed -i 's/\r$//' docker-start.sh \
    && chmod +x docker-start.sh

EXPOSE 10000

CMD ["./docker-start.sh"]
