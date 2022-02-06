# Install pakcage dependency
FROM composer:latest AS composer

COPY ./composer.json /var/app/composer.json
COPY ./composer.lock /var/app/composer.lock

RUN /usr/bin/composer install --optimize-autoloader \
    --working-dir=/var/app \
    --ignore-platform-reqs \
    --no-scripts

RUN /usr/bin/composer dump-autoload \
    --working-dir=/var/app

# Main docker image
FROM php:8.0-rc-buster

COPY --from=composer /var/app/vendor /var/app/vendor

ARG INSTALL_XDEBUG=true
ENV INSTALL_XDEBUG $INSTALL_XDEBUG

# Install xdebug and copy config file
RUN set -eux \
    && if [ ${INSTALL_XDEBUG} = true ]; then \
        pecl install xdebug \
        && docker-php-ext-enable xdebug; \
    fi

COPY .build/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

# Ensure xdebug is activated
RUN set -eux \
    && sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini \
    && sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install bcmath

# For testing
RUN set -eux \
    && apt update \
    && apt install libxml2-dev -yq

RUN docker-php-ext-install dom xml xmlwriter

WORKDIR /var/app

ENTRYPOINT ["tail", "-f", "/dev/null"]
