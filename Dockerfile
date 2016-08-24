# PHP REST APP Dockerfile
#
# Version 0.0.1
FROM php:7-fpm-alpine
MAINTAINER Wojtek Zalewski <wojtek@kropka.net>

LABEL   Description="This image is used to run PHP REST App" \
        Vendor="Wtk" \
        Version="0.0.1"

# Lets updates packages lists
RUN apk update --update-cache

# Lets install our system dependencies
RUN apk add \
    curl \
    git \
    openssh \
    autoconf \
    build-base \
    libxslt \
    libxslt-dev

# Lets copy our php config
COPY .docker/php/php.ini /usr/local/etc/php/

# Lets install few php modules
RUN pecl install \
    xdebug

# Cleaning up
RUN rm -rf \
    /var/cache/apk/* \
    /tmp/src

# Required for RabbitMQ
RUN docker-php-ext-install bcmath xsl soap

# @todo: Revisit this
# Now would be good time to add user which will run web-related stuff
# instead of root, especially composer install ie.
#
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add code
# Note: Keep in mind that this gets overwritten when using
# docker-compose def with volumes in it
ADD app /usr/src/app

# Setting up default working directory
WORKDIR /usr/src/app

# Install dependencies
RUN composer install --prefer-dist --optimize-autoloader --profile --working-dir=/usr/src/app

# Enabling Xdebug
# It's done bit later because of composer.
# It has a major impact on runtime performance.
# See https://getcomposer.org/xdebug
RUN docker-php-ext-enable xdebug.so
