FROM php:8.3-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www \
    && [ -d /var/www/storage ] && chmod -R 775 /var/www/storage \
    && [ -d /var/www/bootstrap/cache ] && chmod -R 775 /var/www/bootstrap/cache

CMD ["php-fpm"]


