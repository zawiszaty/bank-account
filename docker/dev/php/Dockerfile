FROM php:7.3.10-fpm-alpine3.10

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug

RUN apk update && \
		apk add \
		git \
        libzip-dev \
        unzip \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install bcmath sockets pcntl