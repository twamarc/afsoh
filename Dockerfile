# Suggested Dockerfile for PHP 8.2 + Apache
FROM php:8.2-apache

# Enable recommended extensions (adjust as needed)
RUN apt-get update && apt-get install -y \        libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \    && docker-php-ext-configure gd --with-jpeg \    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql intl zip gd \    && a2enmod rewrite headers \    && rm -rf /var/lib/apt/lists/*

# Configure Apache DocumentRoot if needed
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Copy code
COPY . /var/www/html

# Permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Production php.ini example (tune as needed)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && echo "" \    && sed -i 's/upload_max_filesize = .*/upload_max_filesize = 32M/' "$PHP_INI_DIR/php.ini" \    && sed -i 's/post_max_size = .*/post_max_size = 32M/' "$PHP_INI_DIR/php.ini" \    && sed -i 's/memory_limit = .*/memory_limit = 256M/' "$PHP_INI_DIR/php.ini"

# Copy project php.ini overrides
COPY php.ini $PHP_INI_DIR/php.ini
