# ── Stage 1: Build frontend assets ───────────────────────────────────────────
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ── Stage 2: Production image ─────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

# Install system libs needed by PHP extensions, plus PECL build toolchain.
# curl, mbstring, and xml are pre-compiled in php:8.2-fpm-alpine — no install needed.
RUN apk add --no-cache libzip-dev icu-dev ${PHPIZE_DEPS} \
    && docker-php-ext-install -j$(nproc) zip bcmath intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del ${PHPIZE_DEPS} \
    && apk add --no-cache libzip icu-libs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source (secrets excluded via .dockerignore)
COPY . .

# Overlay Vite-built assets from the frontend stage
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R a+rX /var/www/html/public

# Snapshot of public/ used by the entrypoint to refresh the shared nginx volume on each deploy
RUN cp -r /var/www/html/public /var/www/html/public-snapshot

COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
