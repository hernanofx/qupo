FROM php:8.2-fpm
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

COPY . /var/www
RUN composer install --no-dev --prefer-dist --no-interaction

# Add start script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
