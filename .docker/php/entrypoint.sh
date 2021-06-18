#!/bin/sh
# make console executable
chmod +x /var/www/html/bin/console

# cron daemon MUST be run with sudo privileges
sudo /usr/sbin/crond -l 8

# install vendors
composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

composer require symfony/runtime

# install bundle assets
php bin/console assets:install --no-interaction

# run initial migrations
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# add default admin user if no users exist
#php bin/console app:admin:create

docker-php-entrypoint php-fpm