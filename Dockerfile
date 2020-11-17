ARG PHP_VERSION

FROM composer:latest
FROM php:${PHP_VERSION}-cli

WORKDIR /github/workspace

RUN apt-get update && \
    apt-get install -y autoconf pkg-config libssl-dev git libzip-dev zlib1g-dev unzip wget && \
    pecl install mongodb && docker-php-ext-enable mongodb && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install -j$(nproc) pdo_mysql zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN wget https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh
RUN chmod +x wait-for-it.sh

# This allows docker to cache the packages when running tests locally or CI
ADD composer.json composer.json

RUN composer install --no-autoloader

# Add source & autoloader
ADD . .
RUN composer install

CMD ["./wait-for-it.sh", "mysql:3306", "--", "composer", "test-coverage"]
