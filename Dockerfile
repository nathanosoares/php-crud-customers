FROM php:8.1-fpm-alpine

# icu-dev - Unicode library
# oniguruma-dev - Regex library
# oniguruma-dev - Timezone library

RUN apk update --no-cache \
    && apk add \
    icu-dev \ 
    oniguruma-dev \
    tzdata \
    mysql-client

RUN docker-php-ext-install intl
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo_mysql

RUN rm -rf /var/cache/apk/*

ADD config/setup.sh /
RUN chmod +x /setup.sh
CMD ["/setup.sh"]