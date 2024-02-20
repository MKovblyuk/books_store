FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql
# RUN apt-get update && apt-get upgrade -y


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer