#!/bin/bash
set -e

# ── 1. Setup .env ──────────────────────────────────────────────────────────
if [ ! -f .env ]; then
    cp .env.example .env
fi

# ── 2. Configure SQLite ────────────────────────────────────────────────────
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's/^#\?DB_HOST=.*/#DB_HOST=127.0.0.1/' .env
sed -i 's/^#\?DB_PORT=.*/#DB_PORT=3306/' .env
sed -i 's/^#\?DB_DATABASE=.*/#DB_DATABASE=/' .env
sed -i 's/^#\?DB_USERNAME=.*/#DB_USERNAME=/' .env
sed -i 's/^#\?DB_PASSWORD=.*/#DB_PASSWORD=/' .env

# ── 3. Set correct APP_URL for HuggingFace Spaces ─────────────────────────
# SPACE_HOST is injected by HuggingFace automatically (e.g. ajeg-furnitur-web.hf.space)
if [ -n "$SPACE_HOST" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=https://$SPACE_HOST|" .env
    echo "APP_URL set to: https://$SPACE_HOST"
else
    echo "SPACE_HOST not set, using default APP_URL"
fi

# ── 4. Create SQLite database file ────────────────────────────────────────
mkdir -p database
touch database/database.sqlite
chmod 666 database/database.sqlite

# ── 5. Storage permissions ────────────────────────────────────────────────
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache

# ── 6. Laravel bootstrap ──────────────────────────────────────────────────
php artisan key:generate --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# ── 7. Database migrations & seeding ─────────────────────────────────────
php artisan migrate --force
php artisan db:seed --force

# ── 8. Start server on HuggingFace port ──────────────────────────────────
echo "Starting Laravel on 0.0.0.0:7860 ..."
php artisan serve --host=0.0.0.0 --port=7860
