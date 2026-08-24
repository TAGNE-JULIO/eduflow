#!/bin/bash
set -e

echo "==> Running Laravel deployment tasks..."

# Cache configuration, routes, and views if APP_KEY is present
if [ -n "$APP_KEY" ]; then
    echo "==> Caching config, routes and views..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Run database migrations automatically if enabled
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "==> Running database migrations..."
    php artisan migrate --force || true
fi

echo "==> Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
