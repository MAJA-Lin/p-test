# Install pakcage dependency
FROM composer:latest AS composer

ARG TESTING=true
ENV TESTING $TESTING

COPY ./composer.json /var/app/composer.json
COPY ./composer.lock /var/app/composer.lock

RUN set -eux \
    && if [ ${TESTING} = true ]; then \
        /usr/bin/composer install --optimize-autoloader \
        --working-dir=/var/app \
        --ignore-platform-reqs \
        --no-scripts ;\
    else \
        /usr/bin/composer install --optimize-autoloader \
        --working-dir=/var/app \
        --ignore-platform-reqs \
        --no-scripts \
        --no-dev ;\
    fi

RUN /usr/bin/composer dump-autoload \
    --working-dir=/var/app

# Main docker image
FROM php:8.0-rc-buster

ARG TESTING=true
ENV TESTING $TESTING

COPY ./ /var/app
COPY --from=composer /var/app/vendor /var/app/vendor
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install essential testing lib
COPY .build/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
RUN set -eux \
    && if [ ${TESTING} = true ]; then \
        pecl install xdebug \
        && apt update \
        && apt install libxml2-dev -yq \
        && docker-php-ext-install dom xml xmlwriter \
        && docker-php-ext-enable xdebug \
        && sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini \
        && sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini \
        && sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini ;\
    fi

RUN docker-php-ext-install bcmath

WORKDIR /var/app

ENTRYPOINT [ "php", "/var/app/index.php" ]
