FROM php:8.1-fpm

WORKDIR /var/www/html

COPY package.json .
RUN npm install

COPY composer.json .
RUN composer install --no-dev

COPY . .

EXPOSE 80

CMD ["php", "artisan", "serve"]