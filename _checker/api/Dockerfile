FROM php:7.4-fpm

COPY . /api
WORKDIR /api

RUN apt-get update
RUN apt-get install -y nano zip unzip wget

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.4
RUN composer --version
RUN composer install --no-interaction --no-suggest --no-progress 2>&1


RUN apt-get install -y libpq-dev \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql


   # vertica
#RUN apt-get install -y odbcinst unixodbc
#RUN wget "http://my.vertica.com/client_drivers/7.2.x/7.2.0-0/vertica-client-7.2.0-0.x86_64.tar.gz"
#RUN tar -xvf vertica*.gz
#RUN cp opt/vertica/opt/vertica/lib64/libverticaodbc.so /opt/vertica/lib/


CMD ["php-fpm"]
#RUN [ "./entrypoint.sh"]