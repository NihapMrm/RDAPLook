#!/bin/bash
# RDAPLook — Manual deployment script (Docker)
# Run from anywhere; always scopes to /var/www/rdaplook.
set -euo pipefail

APP_DIR="/var/www/rdaplook"

echo "[deploy] Starting RDAPLook deployment..."

cd "$APP_DIR"

echo "[deploy] Pulling latest code..."
git pull origin main

# Copy production env if .env is missing or stale
if [ ! -f .env ]; then
    cp .env.production .env
    echo "[deploy] Copied .env.production → .env (remember to set APP_KEY and RAPIDAPI_PROXY_SECRET)"
fi

echo "[deploy] Building Docker images..."
docker compose build --no-cache

echo "[deploy] Starting containers..."
docker compose up -d

echo "[deploy] Waiting for app container to be healthy..."
sleep 5

echo "[deploy] Running post-deploy artisan commands..."
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan package:discover --ansi
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

echo "[deploy] Reloading host Nginx..."
sudo systemctl reload nginx

echo ""
echo "RDAPLook deployed successfully at $(date)"
