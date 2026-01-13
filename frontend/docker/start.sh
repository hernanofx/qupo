#!/usr/bin/env sh
set -e

echo "Listing /usr/share/nginx/html contents (for debug):"
ls -la /usr/share/nginx/html || echo "No files found in /usr/share/nginx/html"

# Prefer explicit BACKEND_URL (including scheme) if provided
if [ -n "$BACKEND_URL" ]; then
  echo "Using explicit BACKEND_URL: $BACKEND_URL"
  export BACKEND_URL
else
  # Fallback to BACKEND_HOST if supplied and not the default placeholder
  BACKEND_HOST=${BACKEND_HOST:-backend:8000}
  export BACKEND_HOST
  if [ -n "$BACKEND_HOST" ] && [ "$BACKEND_HOST" != "backend:8000" ]; then
    BACKEND_URL="http://$BACKEND_HOST"
    export BACKEND_URL
    echo "Derived BACKEND_URL=$BACKEND_URL from BACKEND_HOST"
  else
    echo "No BACKEND_URL provided and BACKEND_HOST is default; leaving BACKEND_URL empty"
    BACKEND_URL=""
    export BACKEND_URL
  fi
fi

# Configure nginx: if BACKEND_URL empty, replace proxy_pass with return 502; else perform env substitution
if [ -z "$BACKEND_URL" ]; then
  echo "No BACKEND_URL configured; /api/v1 will return 502 until a backend is provided"
  sed 's/proxy_pass \$BACKEND_URL;/return 502;/' /etc/nginx/conf.d/default.conf > /etc/nginx/conf.d/default.conf.tmp
  mv /etc/nginx/conf.d/default.conf.tmp /etc/nginx/conf.d/default.conf
else
  envsubst '$BACKEND_URL' < /etc/nginx/conf.d/default.conf > /etc/nginx/conf.d/default.conf.tmp
  mv /etc/nginx/conf.d/default.conf.tmp /etc/nginx/conf.d/default.conf
fi

echo "Starting nginx..."
exec nginx -g 'daemon off;'
