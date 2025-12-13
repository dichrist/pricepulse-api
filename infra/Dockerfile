FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    bash curl git unzip icu-dev libzip-dev oniguruma-dev postgresql-dev \
    && docker-php-ext-install intl zip mbstring pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html