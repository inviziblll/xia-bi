FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y locales curl wget git apt-transport-https freetds-dev unixodbc unixodbc-dev zip unzip gnupg

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update
#RUN ACCEPT_EULA=Y apt-get install -y msodbcsql
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql17

RUN pecl install pdo_sqlsrv sqlsrv && docker-php-ext-enable pdo_sqlsrv sqlsrv


#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y libxml2-dev supervisor &&  docker-php-ext-install soap bcmath

RUN rm -rf /tmp/*d

RUN apt-get update && \
    apt-get install -y \
        libc-client-dev libkrb5-dev && \
    rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install -j$(nproc) imap

RUN mkdir -p /var/www/
WORKDIR /var/www/html


ENTRYPOINT ["bash", "-c", "service supervisor restart  && php-fpm "]




