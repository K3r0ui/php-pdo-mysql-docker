FROM php:7.3-apache
COPY php/index.php /var/www/html/
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install pdo_mysql
EXPOSE 80