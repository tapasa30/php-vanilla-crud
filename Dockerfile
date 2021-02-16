FROM php:7.3-apache-stretch

RUN useradd -u 1000 -m www-user

COPY www /var/www/html

RUN docker-php-ext-install mysqli

ADD apache/templates/apache2.conf /etc/apache2/
ADD apache/templates/php.ini /usr/local/etc/php/

RUN curl -s https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN /usr/local/bin/composer install -d /var/www/html
