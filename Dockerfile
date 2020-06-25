FROM php:7.1.16-fpm


RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -


RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/8/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update && apt-get install -y locales \
    curl \
    git \
    apt-transport-https \
    freetds-dev unixodbc \
    unixodbc-dev \
    zip \
    unzip  \
    wget \
    gnupg \
    libxml2-dev \
    supervisor \
    libc-client-dev \
    libkrb5-dev  \
    libpng-dev \
    nodejs

RUN ACCEPT_EULA=Y apt-get install -y msodbcsql

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen



RUN pecl install pdo_sqlsrv sqlsrv && docker-php-ext-enable pdo_sqlsrv sqlsrv


#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install -j$(nproc) imap  soap bcmath  gd
