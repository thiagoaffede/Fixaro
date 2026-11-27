#!/bin/sh
# Arranque del contenedor en Render: prepara Laravel, corre migraciones y levanta Apache.
set -e
cd /var/www/html

# Render genera APP_KEY como base64 sin el prefijo que espera Laravel.
case "$APP_KEY" in
  base64:*|"") ;;
  *) export APP_KEY="base64:$APP_KEY" ;;
esac

if [ -z "$APP_KEY" ]; then
  echo "Falta la variable APP_KEY" >&2
  exit 1
fi

php artisan storage:link --force >/dev/null 2>&1 || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
