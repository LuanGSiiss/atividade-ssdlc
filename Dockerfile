FROM php:8.4-apache

# unzip é usado pelo Composer para extrair os pacotes
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

# Apache: porta 8080 (permite rodar sem root), DocumentRoot em /public, rotas amigáveis
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf \
    && a2enmod rewrite headers \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Dependências primeiro, para aproveitar o cache de camadas
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache /data \
    && chown -R www-data:www-data storage bootstrap/cache /data \
    && chmod +x docker/entrypoint.sh

ARG APP_VERSION=dev
ENV APP_VERSION=${APP_VERSION}

# RNF-05: o contêiner não roda como root
USER www-data

EXPOSE 8080
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
CMD ["apache2-foreground"]
