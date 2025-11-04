FROM php:8.4-fpm

# Update system
RUN apt update -y --fix-missing && apt upgrade -y

# Install Packeges
RUN apt install -y \
    git \
    vim \
    curl \
    wget \
    zip \
    libcurl4 \
    libcurl4-openssl-dev \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    libbz2-dev \
    libpng-dev \
    pkg-config

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install and enable php extensions
RUN pecl install apcu xdebug
RUN docker-php-ext-install pdo_pgsql curl intl opcache gd zip bz2 sockets
RUN docker-php-ext-enable intl opcache zip bz2 xdebug

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

CMD ["php-fpm"]
