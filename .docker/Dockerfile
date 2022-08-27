FROM php:8.1-fpm

ARG UID=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
  zlib1g-dev libzip-dev zip unzip git \
# Create user & group
  && useradd -ms /bin/bash serveruser -u $UID \
  && mkdir -p /project/code \
  && chown -R $UID:$UID /project/code \
  && docker-php-ext-install zip \
# Xdebug installation
  && pecl install xdebug && docker-php-ext-enable xdebug

# Copy xdebug configuration
COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/

# Composer installation
RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

WORKDIR /project/code

USER serveruser
