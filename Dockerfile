FROM wyveo/nginx-php-fpm

WORKDIR /usr/share/nginx

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

RUN rm -rf ./html

COPY . .

RUN composer install

RUN php artisan key:generate

RUN chmod -R 777 storage/*