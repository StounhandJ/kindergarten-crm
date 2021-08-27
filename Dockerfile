FROM composer as composer
COPY composer.* /app/
RUN composer install --ignore-platform-reqs --no-scripts

FROM php:fpm

COPY composer.lock composer.json /var/www/

WORKDIR /var/www

RUN apt-get update
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www
COPY --from=composer /app/vendor /var/www/vendor
COPY scripts/init.sh ./init.sh
RUN sed -i -e 's/\r$//' init.sh
RUN chmod +x ./init.sh
RUN chmod 777 -R storage/
RUN chmod 777 -R bootstrap/cache/
RUN php artisan key:generate
USER www

EXPOSE 9000
CMD bash -c ./init.sh
