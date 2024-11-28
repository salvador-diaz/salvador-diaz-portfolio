FROM php:8.2-fpm

RUN apt update \
    && apt install -y git zip unzip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Composer copiando la imagen oficial de Dockerhub
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/appserver_laravel
USER www-data
COPY src /var/www/appserver_laravel

# Instalar Nodejs y npm copiando la imagen oficial de Dockerhub
COPY --from=node:23 /usr/local/bin /usr/local/bin
COPY --from=node:23 /usr/local/lib/node_modules /usr/local/lib/node_modules

USER root
RUN chown -R www-data:www-data /var/www

USER www-data

# Por defecto escucha en el puerto 9000
CMD "php-fpm"
