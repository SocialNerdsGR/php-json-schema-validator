FROM php:8.1-fpm

ARG UID
ARG GID

RUN apt-get update && apt-get install -y --no-install-recommends \
  zlib1g-dev libzip-dev zip unzip  \+-
# Create user & group \
  && useradd --uid $UID --user-group serveruser \
  && chown -R $GID:$GID /var/www/html && chmod -R 775 /var/www/html \
  && docker-php-ext-install zip \
# Xdebug installation
  && pecl install xdebug && docker-php-ext-enable xdebug

# Copy xdebug configuration
COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/

# Composer installation
RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

WORKDIR /var/www/html

USER serveruser
