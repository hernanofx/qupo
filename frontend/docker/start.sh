#!/usr/bin/env sh
set -e

echo "Listing /usr/share/nginx/html contents (for debug):"
ls -la /usr/share/nginx/html || echo "No files found in /usr/share/nginx/html"

# Set backend host default if not provided
BACKEND_HOST=${BACKEND_HOST:-backend:8000}
echo "Backend host configured as: $BACKEND_HOST"

# Use envsubst to substitute environment variables in nginx config
envsubst '$BACKEND_HOST' < /etc/nginx/conf.d/default.conf > /etc/nginx/conf.d/default.conf.tmp
mv /etc/nginx/conf.d/default.conf.tmp /etc/nginx/conf.d/default.conf

echo "Starting nginx..."
exec nginx -g 'daemon off;'
