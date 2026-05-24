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

# Ejecutar seeders solo si no hay usuarios (primera instalación)
USER_COUNT=$(php -r "
try {
    \$db = new PDO('sqlite:' . getenv('DB_DATABASE'));
    echo \$db->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
} catch (Exception \$e) {
    echo 0;
}
" 2>/dev/null || echo 0)

if [ "$USER_COUNT" = "0" ]; then
    echo "Base de datos vacía — ejecutando seeders..."
    php artisan db:seed --force
    echo "Seeders completados."
fi

# Cachear configuración para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Reparar permisos del archivo SQLite para que Apache (www-data) pueda escribir
chown -R www-data:www-data /var/www/html/database
chmod 775 /var/www/html/database
chmod 664 /var/www/html/database/database.sqlite

# Iniciar Apache
apache2-foreground