FROM php:8.4-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && apt install -y libpng-dev libjpeg-dev libfreetype6-dev \ 
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Composer インストール
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# ホストと同じUID/GIDでappuserを作成
ARG USER_ID
ARG GROUP_ID
RUN groupadd -g ${GROUP_ID} appuser \
    && useradd -m -u ${USER_ID} -g appuser appuser

WORKDIR /var/www
