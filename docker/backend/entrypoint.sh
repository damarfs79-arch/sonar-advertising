#!/bin/bash
set -e

if [ ! -f /var/www/backend/.env ]; then
    if [ -f /var/www/backend/.env.example ]; then
        echo "[Backend] Copying .env from .env.example..."
        cp /var/www/backend/.env.example /var/www/backend/.env
    fi
fi

mkdir -p /var/www/backend/storage/framework/cache/data \
         /var/www/backend/storage/framework/sessions \
         /var/www/backend/storage/framework/views \
         /var/www/backend/storage/logs \
         /var/www/backend/storage/app/public \
         /var/www/backend/bootstrap/cache

chown -R www-data:www-data /var/www/backend/storage /var/www/backend/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/backend/storage /var/www/backend/bootstrap/cache 2>/dev/null || true

if [ -f /var/www/backend/database/database.sqlite ]; then
    chmod 664 /var/www/backend/database/database.sqlite 2>/dev/null || true
fi
chmod 775 /var/www/backend/database 2>/dev/null || true

if [ -f /var/www/backend/.env ]; then
    if ! grep -q "^APP_KEY=base64:" /var/www/backend/.env; then
        echo "[Backend] Generating application key..."
        php artisan key:generate --force || true
    fi
fi

if [ ! -L /var/www/backend/public/storage ]; then
    php artisan storage:link || true
fi

exec "$@"
