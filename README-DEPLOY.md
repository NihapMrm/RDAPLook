# RDAPLook — Deployment Guide

Target: Ubuntu 20.04, Atlantic.net VPS, domain rdaplook.com via Cloudflare.  
**No database required.** RDAPLook is stateless — Redis handles all caching.

---

## Isolation rules

- **Never** modify `/etc/nginx/nginx.conf` or existing server blocks
- **Never** touch existing MySQL databases (MySQL is not installed for this project)
- **Never** run `apt upgrade` — only install specific missing packages
- **Never** run artisan commands outside `/var/www/rdaplook`
- Redis: use **DB index 2** only (0 and 1 reserved for other projects)
- Certbot: always pass `--cert-name rdaplook` to avoid touching other certs

---

## Step 1 — Clone the repo

```bash
mkdir -p /var/www/rdaplook
git clone https://github.com/YOUR_ORG/rdaplook.git /var/www/rdaplook
```

---

## Step 2 — Run server-setup.sh

```bash
cd /var/www/rdaplook
chmod +x server-setup.sh
sudo bash server-setup.sh
```

Installs: PHP 8.3 (no mysql extension), Nginx, Redis, Composer, Node.js 20, Certbot.  
Skips anything already present. Does **not** install MySQL.

---

## Step 3 — Configure environment

```bash
cp .env.production /var/www/rdaplook/.env
nano /var/www/rdaplook/.env
```

Fill in:
- `APP_KEY` — leave blank for now, generated in the next step
- `RAPIDAPI_PROXY_SECRET` — from RapidAPI dashboard → My APIs → rdaplook → Security

No database credentials needed.

---

## Step 4 — Install dependencies and generate key

```bash
cd /var/www/rdaplook
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan key:generate
```

---

## Step 5 — Set permissions

```bash
chown -R www-data:www-data /var/www/rdaplook
chmod -R 755 /var/www/rdaplook
chmod -R 775 /var/www/rdaplook/storage
chmod -R 775 /var/www/rdaplook/bootstrap/cache
```

---

## Step 6 — Enable Nginx site

```bash
# Copy config (do NOT edit nginx.conf or any existing block)
cp /var/www/rdaplook/deploy/nginx/rdaplook.com /etc/nginx/sites-available/rdaplook.com
ln -s /etc/nginx/sites-available/rdaplook.com /etc/nginx/sites-enabled/rdaplook.com

# Test — must pass before reloading
nginx -t

systemctl reload nginx
```

---

## Step 7 — Obtain SSL certificate

```bash
# --cert-name prevents touching any other certificates on this server
certbot --nginx \
  --cert-name rdaplook \
  -d rdaplook.com \
  -d www.rdaplook.com \
  --non-interactive \
  --agree-tos \
  --email admin@rdaplook.com
```

Certbot rewrites the `ssl_certificate` paths in the site block automatically.

---

## Step 8 — Set up Cloudflare DNS

1. Log in to Cloudflare → select **rdaplook.com**
2. **DNS → Records → Add record:**
   - Type: `A`, Name: `@`, IPv4: `YOUR_SERVER_IP`, Proxy: **ON (orange cloud)**
   - Type: `A`, Name: `www`, IPv4: `YOUR_SERVER_IP`, Proxy: **ON (orange cloud)**
3. **SSL/TLS → Overview** → encryption mode: **Full (strict)**
4. **SSL/TLS → Edge Certificates** → enable **Always Use HTTPS**

> Your server IPv4 is on the Atlantic.net dashboard under the droplet details.

---

## Step 9 — Queue worker systemd service

```bash
cp /var/www/rdaplook/deploy/rdaplook-worker.service /etc/systemd/system/rdaplook-worker.service

systemctl daemon-reload
systemctl enable rdaplook-worker
systemctl start rdaplook-worker

# Verify
systemctl status rdaplook-worker
journalctl -u rdaplook-worker -f
```

---

## Step 10 — Cache config for production

```bash
cd /var/www/rdaplook
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 11 — Set up GitHub Actions CI/CD

Add these secrets in GitHub → Settings → Secrets → Actions:

| Secret            | Value                                         |
|-------------------|-----------------------------------------------|
| `SERVER_IP`       | Your VPS IPv4 address                         |
| `SERVER_USER`     | SSH user (e.g. `root` or `deploy`)            |
| `SSH_PRIVATE_KEY` | Contents of `~/.ssh/id_rsa` (private key)     |

The deploy user needs passwordless sudo for two commands. Add to `/etc/sudoers.d/rdaplook`:

```
deploy ALL=(ALL) NOPASSWD: /bin/systemctl restart rdaplook-worker, /bin/systemctl reload nginx
```

Every push to `main` now deploys automatically.

---

## Step 12 — Test all 4 endpoints

```bash
SECRET="your_rapidapi_proxy_secret"

# Domain RDAP
curl -s https://rdaplook.com/api/v1/domain/google.com \
  -H "X-RapidAPI-Proxy-Secret: $SECRET" | jq .

# DNS records
curl -s https://rdaplook.com/api/v1/dns/google.com \
  -H "X-RapidAPI-Proxy-Secret: $SECRET" | jq .

# Availability
curl -s https://rdaplook.com/api/v1/availability/google.com \
  -H "X-RapidAPI-Proxy-Secret: $SECRET" | jq .

# Bulk check
curl -s -X POST https://rdaplook.com/api/v1/bulk \
  -H "X-RapidAPI-Proxy-Secret: $SECRET" \
  -H "Content-Type: application/json" \
  -d '{"domains":["google.com","google.net","google.org"]}' | jq .
```

Missing or wrong secret → `{"error": true, "code": "FORBIDDEN", "message": "Access via RapidAPI only."}`

---

## Redis DB isolation

RDAPLook uses Redis **DB 2** exclusively (`REDIS_DB=2`, `REDIS_CACHE_DB=2`).

```bash
# Verify RDAPLook keys are all on DB 2
redis-cli -n 2 keys "*"

# DBs 0 and 1 should be untouched
redis-cli -n 0 keys "*"
redis-cli -n 1 keys "*"
```

---

## Useful commands

```bash
# Restart queue worker
systemctl restart rdaplook-worker

# Watch worker logs live
journalctl -u rdaplook-worker -f

# Test Nginx config without reloading
nginx -t

# Reload Nginx
systemctl reload nginx

# Clear Redis cache for RDAPLook only (DB 2)
redis-cli -n 2 flushdb

# Re-deploy manually
cd /var/www/rdaplook && bash deploy.sh
```
