FROM ubuntu:24.04

# Actualizar paquetes Ubuntu y definir zona horaria a America/Montevideo
RUN apt update && \
    echo 'tzdata tzdata/Areas select America' | debconf-set-selections; echo 'tzdata tzdata/Zones/America select Montevideo' | debconf-set-selections; \
    DEBIAN_FRONTEND=noninteractive apt install vim -y && \
    apt install -y git

# Apache
RUN apt install -y apache2 && a2enmod rewrite ssl

# PHP
RUN apt install -y php php-mysql composer

RUN mkdir -p /etc/letsencrypt/live
# Se añade "[]" para gatillar glob pattern, el cual copia el origen solo si existe
COPY ./[c]erts/salvadordiaz.net /etc/letsencrypt/live/salvadordiaz.net
COPY ./vanilla_php/tables.php /root/tables.php

USER www-data
WORKDIR /var/www/vanilla_php
COPY ./vanilla_php/src .
RUN composer install
USER root


# Mal! esto ejecuta apache2 en segundo plano, pero Docker solo sigue ejecutandose cuando el proces principal sigue vivo.
# Cuando docker termina de ejecutar todo y manda apache al segundo plano, termina (exited with code 0)
# CMD service apache2 start

# Tenemos entonces que ejecutarlo en primer plano (primero inicializando la bd)
CMD php /root/tables.php && apachectl -D FOREGROUND
