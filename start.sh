#!/bin/bash
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Ensure SQLite database files exist so PDO SQLite never crashes
mkdir -p database
touch database/database.sqlite
touch database/laravel.sqlite

php artisan key:generate --force
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Auto migrate and seed database on startup
php artisan migrate --force --seed || true

PORT_TO_USE="${PORT:-7860}"

php artisan serve --host=0.0.0.0 --port="$PORT_TO_USE"
