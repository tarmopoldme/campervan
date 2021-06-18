ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

WORKDIR /var/www/html

# Override with custom php.ini settings
COPY .docker/php/php-custom.ini $PHP_INI_DIR/conf.d/
# set up crontab related stuff
COPY .docker/php/crontab /var/spool/cron/crontabs/www-data
# copy entrypoint script to container
COPY .docker/php/entrypoint.sh /var/www/

# Install required php extensions
RUN set -xe \
    && apk update \
    && apk upgrade \
    && apk add --update icu git \
    && apk add --no-cache --virtual .php-deps make \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        zlib-dev \
        icu-dev \
        g++ \
    && apk add --no-cache \
        sudo \
        libzip-dev \
        zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        mysqli \
        zip \
        pcntl \
    && { find /usr/local/lib -type f -print0 | xargs -0r strip --strip-all -p 2>/dev/null || true; } \
    && apk del .build-deps \
    && rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/* \
    # Install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    # make crontab command accessible to all users besides root
    && chmod +s /bin/busybox \
    # Fix permissions for www-data
    && sed -ri 's/^www-data:x:82:82:/www-data:x:1000:50:/' /etc/passwd \
    && chown -R www-data:www-data /var/www/html /home/www-data \
    # Fix entrypoint permissions
    && chmod a+x /var/www/entrypoint.sh \
    && echo "www-data ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/www-data \
    && chmod 0440 /etc/sudoers.d/www-data

ENV COMPOSER_MEMORY_LIMIT=2G

USER www-data

# run our own script to faciliate custom logic
ENTRYPOINT /var/www/entrypoint.sh