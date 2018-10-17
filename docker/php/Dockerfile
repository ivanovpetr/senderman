FROM php:7.2-fpm-alpine
# lumen requirements
RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql
RUN apk add zip unzip curl git
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
WORKDIR /usr/share/nginx/html/senderman