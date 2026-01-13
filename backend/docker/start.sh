#!/usr/bin/env sh
set -e

# Wait for DB (simple loop)
if [ -n "$DATABASE_URL" ]; then
  echo "DATABASE_URL detected, proceeding to migrate"
fi

# Run migrations and seed (non destructive for production if already migrated)
php artisan migrate --force || true
php artisan db:seed --class=HernanUserSeeder --force || true

# Generate app key if not exists
if [ -z "$(php artisan key:generate --show 2>/dev/null)" ]; then
  php artisan key:generate
fi

# Start Laravel dev server (for small production, consider using nginx+php-fpm)
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
