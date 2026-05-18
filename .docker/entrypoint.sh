#!/bin/sh
set -e

# Ensure required storage subdirectories exist in the named volume.
# .dockerignore excludes their contents; realpath() returns false if missing,
# which causes Laravel to throw "Please provide a valid cache path."
mkdir -p \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/logs \
    /var/www/html/storage/app/public

# On every container start, sync the built public/ assets from the image snapshot
# into the shared named volume so nginx always serves the current build.
cp -r /var/www/html/public-snapshot/. /var/www/html/public/

exec "$@"
