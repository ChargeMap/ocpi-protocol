FROM php:7.4-cli

# Update system
RUN apt-get update && rm /etc/apt/preferences.d/no-debian-php && apt-get install --yes git libzip-dev zip

# Install composer
ENV COMPOSER_HOME "/home/www-data/.composer"
RUN mkdir -p $COMPOSER_HOME && chmod -R 777 $COMPOSER_HOME && curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN pecl install xdebug-2.9.1 \
    && docker-php-ext-enable xdebug
