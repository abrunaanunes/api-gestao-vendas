ARG PHP_VERSION=8.2
FROM php:${PHP_VERSION}-apache-bullseye

ENV APACHE2_CONF ./docker/config/apache2.conf
ENV PHP_INI ./docker/config/php.ini
ENV VHOST_FILE ./docker/config/000-default.conf

COPY $APACHE2_CONF /etc/apache2/apache2.conf
COPY $VHOST_FILE /etc/apache2/sites-available/000-default.conf

RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    echo "America/Sao_Paulo" > /etc/timezone

# Instala dependências
RUN apt-get update && apt-get install -y \
    git \
    zlib1g-dev \
    unzip \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxml2-dev \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql exif pgsql pdo_pgsql zip soap \
    && apt-get purge -y --auto-remove wget

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuração Apache
WORKDIR /var/www
RUN rm -Rf /var/www/html && a2enmod rewrite && a2enmod ssl

# Copia arquivos da aplicação e instala dependências
COPY --chown=www-data:www-data . /var/www
COPY --chown=www-data:www-data .env /var/www/.env

RUN composer install --no-ansi --no-interaction --no-progress --optimize-autoloader