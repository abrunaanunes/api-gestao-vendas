#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

cd /var/www

if [ ! -f "/var/www/.env" ];
then
    cp /var/www/.env.${env}  /var/www/.env
fi

if [ ! -d "/var/www/vendor" ];
then
    composer install --no-ansi --no-interaction --no-progress --optimize-autoloader
fi

if [ $(grep -c '^APP_KEY=.*$' .env) -eq 0 ]
then
    echo "Application key not set. Generating one."
    php artisan key:generate
fi

if ["$role" = "app"]; then
    php artisan migrate
    php artisan db:seed DatabaseSeeder
fi

### Inicia o serviço baseado na ROLE
if [ "$env" == "production" ]; then
    echo "Caching configuration..."
    (cd /var/www && php artisan config:cache && php artisan route:cache && php artisan view:cache)
else
    echo "Clearing caches..."
    (cd /var/www && php artisan config:clear && php artisan route:clear && php artisan view:clear)
fi


if [ "$role" = "app" ]; then
    exec apache2-foreground
elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    php /var/www/artisan queue:work --verbose --tries=3 --queue=managers,sellers,default --timeout=90
elif [ "$role" = "scheduler" ]; then
    # SIMULA CRON
    php /var/www/artisan schedule:work
    # while [ true ]
    # do
    #   php /var/www/artisan schedule:run --verbose --no-interaction &
    #   sleep 60
    # done
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
