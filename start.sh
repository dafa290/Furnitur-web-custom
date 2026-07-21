#!/bin/bash
if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force
php artisan config:clear
php artisan route:clear
php artisan cache:clear

php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
