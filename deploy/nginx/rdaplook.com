# RDAPLook — Nginx server block
# Drop into /etc/nginx/sites-available/rdaplook.com
# then: ln -s /etc/nginx/sites-available/rdaplook.com /etc/nginx/sites-enabled/rdaplook.com
#
# Do NOT modify nginx.conf or any other existing site block.
# Certbot will replace the ssl_certificate paths below automatically.

# ── Cloudflare real IP restoration ──────────────────────────────────────────
# Place these in the server block (not in http block) so they only apply here.
# Source: https://www.cloudflare.com/ips/

# ── HTTP → HTTPS redirect ────────────────────────────────────────────────────
server {
    listen 80;
    listen [::]:80;
    server_name rdaplook.com www.rdaplook.com;

    # Allow certbot ACME challenge
    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }

    location / {
        return 301 https://rdaplook.com$request_uri;
    }
}

# ── www → non-www redirect ───────────────────────────────────────────────────
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name www.rdaplook.com;

    # Certbot will replace these two lines
    ssl_certificate     /etc/letsencrypt/live/rdaplook.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/rdaplook.com/privkey.pem;
    include             /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam         /etc/letsencrypt/ssl-dhparams.pem;

    return 301 https://rdaplook.com$request_uri;
}

# ── Main HTTPS block ─────────────────────────────────────────────────────────
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name rdaplook.com;

    # Certbot will replace these two lines
    ssl_certificate     /etc/letsencrypt/live/rdaplook.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/rdaplook.com/privkey.pem;
    include             /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam         /etc/letsencrypt/ssl-dhparams.pem;

    # ── Cloudflare real IP restoration ──────────────────────────────────────
    real_ip_header     CF-Connecting-IP;
    set_real_ip_from   173.245.48.0/20;
    set_real_ip_from   103.21.244.0/22;
    set_real_ip_from   103.22.200.0/22;
    set_real_ip_from   103.31.4.0/22;
    set_real_ip_from   141.101.64.0/18;
    set_real_ip_from   108.162.192.0/18;
    set_real_ip_from   190.93.240.0/20;
    set_real_ip_from   188.114.96.0/20;
    set_real_ip_from   197.234.240.0/22;
    set_real_ip_from   198.41.128.0/17;
    set_real_ip_from   162.158.0.0/15;
    set_real_ip_from   104.16.0.0/13;
    set_real_ip_from   104.24.0.0/14;
    set_real_ip_from   172.64.0.0/13;
    set_real_ip_from   131.0.72.0/22;
    set_real_ip_from   2400:cb00::/32;
    set_real_ip_from   2606:4700::/32;
    set_real_ip_from   2803:f800::/32;
    set_real_ip_from   2405:b500::/32;
    set_real_ip_from   2405:8100::/32;
    set_real_ip_from   2a06:98c0::/29;
    set_real_ip_from   2c0f:f248::/32;

    # ── Security headers ────────────────────────────────────────────────────
    # Note: these are inherited by location / only.
    # Static asset locations below must repeat them to avoid nginx's
    # "add_header in child block replaces parent" behaviour.
    add_header X-Frame-Options        "SAMEORIGIN"           always;
    add_header X-Content-Type-Options "nosniff"              always;
    add_header Referrer-Policy        "strict-origin-when-cross-origin" always;
    add_header X-XSS-Protection       "1; mode=block"        always;

    # ── Gzip ────────────────────────────────────────────────────────────────
    gzip              on;
    gzip_vary         on;
    gzip_proxied      any;
    gzip_comp_level   6;
    gzip_buffers      16 8k;
    gzip_http_version 1.1;
    gzip_types
        text/plain
        text/css
        text/javascript
        application/javascript
        application/json
        application/x-javascript
        font/truetype
        font/opentype
        application/vnd.ms-fontobject
        image/svg+xml;

    # ── Upstream proxy settings (inherited by all proxy_pass locations) ──────
    proxy_http_version 1.1;
    proxy_set_header   Host              $host;
    proxy_set_header   X-Real-IP         $remote_addr;
    proxy_set_header   X-Forwarded-For   $proxy_add_x_forwarded_for;
    proxy_set_header   X-Forwarded-Proto $scheme;
    proxy_set_header   X-Forwarded-Host  $host;
    proxy_set_header   Connection        "";
    proxy_read_timeout 60s;

    # ── Static asset caching ─────────────────────────────────────────────────
    # Security headers duplicated here because add_header in a child location
    # does not inherit the server-block add_header directives.
    location ~* \.(css|js|woff|woff2|ttf|otf|eot|svg)$ {
        expires    1y;
        add_header Cache-Control        "public, immutable"              always;
        add_header X-Frame-Options        "SAMEORIGIN"                   always;
        add_header X-Content-Type-Options "nosniff"                      always;
        add_header Referrer-Policy        "strict-origin-when-cross-origin" always;
        add_header X-XSS-Protection       "1; mode=block"                always;
        access_log off;
        proxy_pass http://127.0.0.1:8100;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|webp|avif)$ {
        expires    30d;
        add_header Cache-Control        "public"                         always;
        add_header X-Frame-Options        "SAMEORIGIN"                   always;
        add_header X-Content-Type-Options "nosniff"                      always;
        add_header Referrer-Policy        "strict-origin-when-cross-origin" always;
        add_header X-XSS-Protection       "1; mode=block"                always;
        access_log off;
        proxy_pass http://127.0.0.1:8100;
    }

    # ── All other requests → Docker (nginx inside container handles routing) ──
    location / {
        proxy_pass http://127.0.0.1:8100;
    }

    location = /favicon.ico { access_log off; log_not_found off; proxy_pass http://127.0.0.1:8100; }
    location = /robots.txt  { access_log off; log_not_found off; proxy_pass http://127.0.0.1:8100; }

    # ── Block hidden files ────────────────────────────────────────────────────
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # ── Logs ─────────────────────────────────────────────────────────────────
    access_log /var/log/nginx/rdaplook.access.log;
    error_log  /var/log/nginx/rdaplook.error.log;
}
