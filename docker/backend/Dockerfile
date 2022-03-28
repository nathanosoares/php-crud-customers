FROM php:8.1-fpm-alpine


# icu-dev - Unicode library
# oniguruma-dev - Regex library
# tzdata - Timezone library

RUN apk update --no-cache \
    && apk add \
    icu-dev \ 
    oniguruma-dev \
    tzdata \
    mysql-client \
    nginx 

RUN docker-php-ext-install intl
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo_mysql

RUN rm -rf /var/cache/apk/*

WORKDIR  /backend

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

CMD ["php-fpm"]