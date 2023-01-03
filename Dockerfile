FROM php:8.0.2-fpm

COPY composer.lock composer.json /var/www/

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    libmagickwand-dev \
    curl

RUN apt install -y nodejs npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install imagemagick
RUN pecl install imagick && \
    docker-php-ext-enable imagick

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
#RUN pecl install xdebug-2.6.1 && docker-php-ext-enable xdebug

ARG UID=1000
ARG GID=1000

# Add user for laravel application
RUN groupadd -g ${GID} www
RUN useradd -u ${UID} -ms /bin/bash -g www www

COPY . /var/www

COPY --chown=www:www . /var/www

RUN npm install

USER www

EXPOSE 9000
CMD ["php-fpm"]
