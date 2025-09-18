FROM php:8.3-fpm
RUN apt-get update && apt-get install -y libicu-dev libzip-dev git unzip && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql intl zip
WORKDIR /var/www/html
