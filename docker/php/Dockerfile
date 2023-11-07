FROM php:8.2-fpm

ARG user=php
ARG uid=1000

RUN apt-get update
RUN apt-get install -y git unzip

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer
RUN chown -R $user:$user /home/$user

WORKDIR /var/src

USER $user
