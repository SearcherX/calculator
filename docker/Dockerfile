# COMMON TOOLS
FROM alpine:3.18.4 as common-tools

COPY ./docker/common/wait-for /usr/local/bin/wait-for
RUN apk --no-cache add bash && chmod +x /usr/local/bin/wait-for

# PHP-FPM
FROM php:8.2-fpm-alpine3.17 as fpm

ARG USER='www-data'
ARG GROUP='www-data'

COPY ./docker/php/cli/conf.d/* $PHP_INI_DIR/conf.d
COPY ./docker/php/fpm/conf.d/extras.conf $PHP_INI_DIR/../php-fpm.d/extras.conf
COPY ./docker/php/fpm/conf.d/extras.ini $PHP_INI_DIR/conf.d/php-fpm.ini
COPY ./docker/php/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer-2 \
    bcmath mcrypt pdo_mysql gd intl opcache \
    && apk --no-cache add bash

RUN apk add --no-cache linux-headers \
	&& apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS\
	&& pecl install xdebug \
	&& docker-php-ext-enable xdebug \
	&& pecl clear-cache \
	&& apk del .build-dependencies

WORKDIR /var/www/html

USER ${USER}

CMD php-fpm
EXPOSE 9000

# NODE JS
FROM node:20.6.0-alpine3.18 as node

ARG USER='node'
ARG GROUP='node'

RUN apk add python3 make g++ yarn

WORKDIR /app

USER ${USER}:${GROUP}

# NGINX
FROM nginx:1.24.0-alpine as nginx

COPY ./docker/nginx/templates /etc/nginx/templates

EXPOSE 80