FROM php:8.0-fpm-alpine3.12

RUN apk add --update --no-cache \
    curl \
    freetype-dev \
    git \
    nano \
    wget \
    xvfb \
    ttf-ubuntu-font-family \
    zip \
    bash

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
