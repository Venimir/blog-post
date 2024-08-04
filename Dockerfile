FROM php:8.1.10-apache
EXPOSE 9000
EXPOSE 3000
WORKDIR /var/www/html
#Mod Rewrite
RUN a2enmod rewrite

#Linux Libraries
RUN apt-get update -y && apt-get install -y \
    iputils-ping \
    libicu-dev \
    libmagickwand-dev \
    unzip unzip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    npm
RUN npm install npm@latest -g && \
    npm install n -g && \
    n latest

#Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#PHP Extensions
RUN docker-php-ext-install gettext intl pdo_mysql mysqli gd

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
