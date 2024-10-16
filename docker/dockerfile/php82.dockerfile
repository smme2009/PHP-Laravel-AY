FROM php:8.2-fpm

#安裝ZIP套件
RUN apt-get update

RUN apt-get install -y libzip-dev

RUN docker-php-ext-install zip

#COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer