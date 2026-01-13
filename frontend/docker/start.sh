#!/usr/bin/env sh
set -e

echo "Listing /usr/share/nginx/html contents (for debug):"
ls -la /usr/share/nginx/html || echo "No files found in /usr/share/nginx/html"

# Set backend host default if not provided
BACKEND_HOST=${BACKEND_HOST:-backend:8000}
export BACKEND_HOST
# Sanity: ensure not empty
if [ -z "$BACKEND_HOST" ]; then
  echo "WARNING: BACKEND_HOST is empty, defaulting to backend:8000"
  BACKEND_HOST=backend:8000
  export BACKEND_HOST
fi

echo "Backend host configured as: $BACKEND_HOST"

# Use envsubst to substitute environment variables in nginx config
# If BACKEND_HOST is still the default (backend:8000) we avoid creating a proxy to an unresolved host
if [ "$BACKEND_HOST" = "backend:8000" ]; then
  echo "BACKEND_HOST is default (backend:8000); configuring /api/v1 to return 502 until real backend is provided"
  # Replace the proxy_pass line with a simple 502 response so nginx won't fail to start
  sed 's/proxy_pass http:\/\/\$BACKEND_HOST;/return 502;/' /etc/nginx/conf.d/default.conf > /etc/nginx/conf.d/default.conf.tmp
  mv /etc/nginx/conf.d/default.conf.tmp /etc/nginx/conf.d/default.conf
else
  envsubst '$BACKEND_HOST' < /etc/nginx/conf.d/default.conf > /etc/nginx/conf.d/default.conf.tmp
  mv /etc/nginx/conf.d/default.conf.tmp /etc/nginx/conf.d/default.conf
fi

echo "Starting nginx..."
exec nginx -g 'daemon off;'
