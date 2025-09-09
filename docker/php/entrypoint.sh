#!/bin/sh
set -e

[ -d /var/www/storage ] && chmod -R 775 /var/www/storage
[ -d /var/www/bootstrap/cache ] && chmod -R 775 /var/www/bootstrap/cache
chown -R www-data:www-data /var/www

exec php-fpm
