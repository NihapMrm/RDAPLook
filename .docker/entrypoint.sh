#!/bin/sh
set -e

# On every container start, sync the built public/ assets from the image snapshot
# into the shared named volume so nginx always serves the current build.
# Uses cp -r with the trailing /. to copy contents (not the directory itself),
# and -n is intentionally omitted so updated builds overwrite stale files.
cp -r /var/www/html/public-snapshot/. /var/www/html/public/

exec "$@"
