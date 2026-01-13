#!/usr/bin/env sh
set -e

# Parse DATABASE_URL if provided (format: postgresql://user:pass@host:port/database)
if [ -n "$DATABASE_URL" ]; then
  echo "DATABASE_URL detected, parsing connection parameters"
  # Extract components from DATABASE_URL
  # Expected format: postgresql://postgres:password@host:port/dbname
  DB_URL="$DATABASE_URL"
  # Remove postgresql:// prefix
  DB_URL="${DB_URL#postgresql://}"
  # Extract user:pass
  DB_CREDS="${DB_URL%%@*}"
  DB_USERNAME="${DB_CREDS%%:*}"
  DB_PASSWORD="${DB_CREDS#*:}"
  # Extract host:port/dbname
  DB_HOST_PORT="${DB_URL#*@}"
  DB_HOST="${DB_HOST_PORT%%:*}"
  DB_PORT="${DB_HOST_PORT#*:}"
  DB_PORT="${DB_PORT%%/*}"
  DB_DATABASE="${DB_HOST_PORT#*/}"
  
  # Export for Laravel
  export DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD
  echo "Parsed: Host=$DB_HOST, Port=$DB_PORT, DB=$DB_DATABASE, User=$DB_USERNAME"
fi

# Set default APP_URL if not provided
if [ -z "$APP_URL" ] || [ "$APP_URL" = "https://<BE_RAILWAY_DOMAIN>" ]; then
  APP_URL="http://localhost:${PORT:-8000}"
  export APP_URL
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
