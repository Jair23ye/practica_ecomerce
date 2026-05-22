#!/bin/bash
set -e

# Generar clave si no existe
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Enlace simbólico de storage
php artisan storage:link --force 2>/dev/null || true

# Ejecutar migraciones
php artisan migrate --force

# Limpiar y cachear configuración para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar Apache
apache2-foreground