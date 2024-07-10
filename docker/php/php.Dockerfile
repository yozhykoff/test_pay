FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
  libzip-dev \
  libonig-dev \
  cron \
  libfreetype6-dev \
  libicu-dev \
  libjpeg62-turbo-dev \
  libmcrypt-dev \
  libxslt1-dev \
  zip \
  libpng-dev \
  libxml2-dev \
  libxslt-dev \
  curl \
  vim \
  wget \
  git \
  procps \
  wget


RUN set -x \
    && pecl install -f xdebug-3.3.2

RUN docker-php-ext-enable xdebug

RUN docker-php-ext-install -j$(nproc) iconv

RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/

RUN docker-php-ext-install -j$(nproc) gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

ENV PHP_MEMORY_LIMIT 2G
ENV PHP_MAX_EXECUTION_TIME=300
ENV PHP_POST_MAX_SIZE=500M
ENV PHP_UPLOAD_MAX_FILESIZE=1024M

RUN chmod -R g+rwX /var/www
RUN chmod -R g+s /var/www


ENV PHP_IDE_CONFIG 'serverName=Pay'
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey = PAY" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set working directory
WORKDIR /var/www/html

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
