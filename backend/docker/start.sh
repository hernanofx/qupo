#!/usr/bin/env sh
set -e

# Generate APP_KEY first if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:YOUR_KEY_HERE" ]; then
  echo "Generating APP_KEY..."
  # Generate a base64-encoded 32-byte random key
  APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
  export APP_KEY
  echo "Generated APP_KEY: $APP_KEY"
fi

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
  
  # Write to .env for Laravel to pick up
  cat > /var/www/.env <<EOF
APP_NAME=Qupo
APP_ENV=${APP_ENV:-production}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}
APP_KEY=${APP_KEY}

DB_CONNECTION=pgsql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_DATABASE=$DB_DATABASE
DB_USERNAME=$DB_USERNAME
DB_PASSWORD=$DB_PASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_CHANNEL=${LOG_CHANNEL:-stack}
LOG_LEVEL=${LOG_LEVEL:-info}
MAIL_MAILER=log
EOF
  echo ".env generated from DATABASE_URL"

  # Clear and warm config cache so Laravel picks up new .env values
  echo "Clearing config cache..."
  php artisan config:clear || echo "config:clear failed"
  echo "Caching config..."
  php artisan config:cache || echo "config:cache failed"
fi

# Set default APP_URL if not provided
if [ -z "$APP_URL" ] || [ "$APP_URL" = "https://<BE_RAILWAY_DOMAIN>" ]; then
  APP_URL="http://localhost:${PORT:-8000}"
  export APP_URL
fi

# Run migrations with verbose output
echo "Running migrate:status..."
php artisan migrate:status --verbose || echo "migrate:status failed"

echo "Running migrations..."
php artisan migrate --force --verbose || {
  echo "Migration failed, attempting to continue..."
}

# Show database tables using PDO (for debugging)
echo "Checking DB tables via PDO..."
php -r 'try { $pdo = new PDO("pgsql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT").";dbname=".getenv("DB_DATABASE"), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\'"); $rows = $stmt->fetchAll(PDO::FETCH_COLUMN); echo "tables: ".implode(",",$rows).PHP_EOL; } catch (Exception $e) { echo "pdo error: ".$e->getMessage().PHP_EOL; }' || echo "pdo check failed"

# Run seeder with verbose output
echo "Seeding database..."
php artisan db:seed --class=HernanUserSeeder --force --verbose || {
  echo "Seeding failed, app will continue..."
}

echo "Starting Laravel server on port ${PORT:-8000}..."

# Start Laravel dev server (for small production, consider using nginx+php-fpm)
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
