FROM php:8.2-fpm-alpine3.18

ENV RUN_DEPS="zlib libzip libpng libjpeg-turbo mariadb-connector-c"
ENV BUILD_DEPS="zlib-dev libzip-dev libpng-dev libjpeg-turbo-dev mariadb-connector-c-dev"
ENV PHP_EXTENSIONS="opcache zip gd bcmath pdo_mysql"

RUN apk add --no-cache --virtual .build-deps $BUILD_DEPS \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" $PHP_EXTENSIONS \
    && apk del .build-deps

RUN apk add --no-cache --virtual .run-deps $RUN_DEPS

COPY . /app

VOLUME ["/app"]