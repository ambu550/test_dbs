FROM php:7.3-fpm

COPY ./api /api
WORKDIR /api
RUN apt-get update
RUN apt-get install -y nano zip unzip


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.4
RUN composer --version
RUN composer install --no-interaction --no-suggest --no-progress 2>&1


RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql


#ENTRYPOINT ["sh", "/api/entrypoint.sh"]
CMD ["php-fpm"]
