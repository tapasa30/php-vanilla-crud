FROM php:7.3-apache-stretch

RUN useradd -u 1000 -m www-user

RUN docker-php-ext-install mysqli

ADD templates/apache2.conf /etc/apache2/
ADD templates/php.ini /usr/local/etc/php/
