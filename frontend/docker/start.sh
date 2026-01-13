#!/usr/bin/env sh
set -e

echo "Listing /usr/share/nginx/html contents (for debug):"
ls -la /usr/share/nginx/html || echo "No files found in /usr/share/nginx/html"

echo "Starting nginx..."
exec nginx -g 'daemon off;'
