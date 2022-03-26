#!/bin/sh

while ! mysql -u $DATABASE_USER -p$DATABASE_PASS -h $DATABASE_HOST -P $DATABASE_PORT  -e ";" ; do
  echo "Awaiting mysql - sleeping"
  sleep 1
done

cd /php_app

php composer.phar install
php composer.phar setup-database

php-fpm