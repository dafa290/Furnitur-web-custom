#!/bin/bash

# Setup environment variables for SQLite
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Modify .env to use SQLite
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_HOST=.*/#DB_HOST=127.0.0.1/' .env
sed -i 's/DB_PORT=.*/#DB_PORT=3306/' .env
sed -i 's/DB_DATABASE=.*/DB_DATABASE=\/app\/database\/database.sqlite/' .env
sed -i 's/DB_USERNAME=.*/#DB_USERNAME=root/' .env
sed -i 's/DB_PASSWORD=.*/#DB_PASSWORD=/' .env

# Create SQLite database file
touch database/database.sqlite

# Generate app key if needed
php artisan key:generate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Start Laravel development server on port 7860
php artisan serve --host=0.0.0.0 --port=7860
