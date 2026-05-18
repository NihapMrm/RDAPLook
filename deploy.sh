#!/bin/bash
# RDAPLook — Manual deployment script
# Run from anywhere; always scopes to /var/www/rdaplook.
set -euo pipefail

APP_DIR="/var/www/rdaplook"

echo "[deploy] Starting RDAPLook deployment..."

cd "$APP_DIR"

echo "[deploy] Pulling latest code..."
git pull origin main

echo "[deploy] Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "[deploy] Building frontend assets..."
npm ci
npm run build

echo "[deploy] Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[deploy] Restarting queue worker..."
sudo systemctl restart rdaplook-worker

echo "[deploy] Reloading Nginx..."
sudo systemctl reload nginx

echo ""
echo "RDAPLook deployed successfully at $(date)"
