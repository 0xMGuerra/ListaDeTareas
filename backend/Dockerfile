FROM php:8.1.0-fpm-buster

WORKDIR "/server"

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get -y --no-install-recommends install php8.0-mysql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip exif pcntl

COPY . /server

RUN composer install

CMD ["bin/console", "server:run", "172.15.0.2:8000"]