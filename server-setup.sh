#!/bin/bash
# RDAPLook — Server Setup
# Run once on a fresh Ubuntu 20.04 VPS.
# SAFE on a shared VPS: checks before installing, never upgrades existing packages.
# MySQL is NOT installed — RDAPLook uses only Redis for caching.
set -euo pipefail

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

skip()    { echo -e "${YELLOW}[SKIP]${NC}    $1"; }
install() { echo -e "${GREEN}[INSTALL]${NC} $1"; }
section() { echo -e "\n${GREEN}=== $1 ===${NC}"; }

section "Updating apt package list (no upgrade)"
apt-get update -y

# ── PHP 8.3 + extensions ────────────────────────────────────────────────────
# Note: php8.3-mysql is omitted — no MySQL dependency
section "PHP 8.3"
if php8.3 --version &>/dev/null 2>&1; then
    skip "PHP 8.3 already installed"
else
    install "PHP 8.3 + extensions"
    apt-get install -y software-properties-common
    add-apt-repository -y ppa:ondrej/php
    apt-get update -y
    apt-get install -y \
        php8.3-fpm \
        php8.3-redis \
        php8.3-curl \
        php8.3-mbstring \
        php8.3-xml \
        php8.3-zip \
        php8.3-bcmath \
        php8.3-intl \
        php8.3-sockets \
        php8.3-sqlite3
fi

# ── Nginx ────────────────────────────────────────────────────────────────────
section "Nginx"
if systemctl is-active --quiet nginx 2>/dev/null; then
    skip "Nginx already running"
else
    install "Nginx"
    apt-get install -y nginx
    systemctl enable nginx
    systemctl start nginx
fi

# ── Redis ────────────────────────────────────────────────────────────────────
section "Redis"
if systemctl is-active --quiet redis-server 2>/dev/null; then
    skip "Redis already running"
else
    install "Redis"
    apt-get install -y redis-server
    systemctl enable redis-server
    systemctl start redis-server
fi

# ── Composer ─────────────────────────────────────────────────────────────────
section "Composer"
if command -v composer &>/dev/null; then
    skip "Composer already installed ($(composer --version --no-ansi 2>/dev/null | head -1))"
else
    install "Composer"
    EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
        echo "Composer installer checksum mismatch — aborting"
        rm composer-setup.php
        exit 1
    fi
    php composer-setup.php --quiet
    rm composer-setup.php
    mv composer.phar /usr/local/bin/composer
    chmod +x /usr/local/bin/composer
fi

# ── Node.js 20 via nvm ───────────────────────────────────────────────────────
section "Node.js 20"
export NVM_DIR="$HOME/.nvm"
if [ -s "$NVM_DIR/nvm.sh" ]; then
    . "$NVM_DIR/nvm.sh"
fi
if command -v node &>/dev/null && node --version | grep -q '^v20'; then
    skip "Node.js 20 already installed ($(node --version))"
else
    install "Node.js 20 via nvm"
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
    nvm install 20
    nvm use 20
    nvm alias default 20
    NODE_BIN_DIR="$NVM_DIR/versions/node/$(nvm version)/bin"
    ln -sf "$NODE_BIN_DIR/node" /usr/local/bin/node
    ln -sf "$NODE_BIN_DIR/npm"  /usr/local/bin/npm
    ln -sf "$NODE_BIN_DIR/npx"  /usr/local/bin/npx
fi

# ── Certbot ──────────────────────────────────────────────────────────────────
section "Certbot"
if command -v certbot &>/dev/null; then
    skip "Certbot already installed ($(certbot --version 2>&1))"
else
    install "Certbot + python3-certbot-nginx"
    apt-get install -y certbot python3-certbot-nginx
fi

# ── Summary ──────────────────────────────────────────────────────────────────
section "Installed versions"
echo "PHP:      $(php8.3 --version 2>/dev/null | head -1)"
echo "Nginx:    $(nginx -v 2>&1)"
echo "Redis:    $(redis-server --version 2>/dev/null)"
echo "Composer: $(composer --version --no-ansi 2>/dev/null | head -1)"
echo "Node:     $(node --version 2>/dev/null)"
echo "npm:      $(npm --version 2>/dev/null)"
echo "Certbot:  $(certbot --version 2>&1)"
echo ""
echo "Setup complete. Continue with README-DEPLOY.md step 2."
