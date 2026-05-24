# Ecommerce Practica — Mini Proyecto 4

Sistema de comercio electrónico desarrollado con Laravel como parte del Mini Proyecto 4 de Desarrollo Web. Incluye autenticación con 2FA, gestión de productos y ventas, dashboards por rol, políticas de acceso, y despliegue en la nube con integración continua.

## Tecnologías usadas

- **PHP 8.3** — Lenguaje principal
- **Laravel 11** — Framework web
- **SQLite** — Base de datos (desarrollo/pruebas) / MySQL (producción opcional)
- **GitHub Actions** — Integración continua (CI)
- **Render.com** — Despliegue en la nube (CD)
- **Docker** — Contenedor para despliegue
- **Vite** — Compilación de assets frontend

## Características del sistema

- Autenticación con 2 factores (OTP por correo)
- Roles: administrador, gerente y cliente
- CRUD de productos, categorías, ventas y usuarios
- Políticas de acceso por rol (Laravel Policies)
- Dashboard con estadísticas por rol
- Notificaciones por correo al validar ventas
- Subida de archivos (fotos de productos, tickets de venta)

## Instalación local

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/practica-ecomerce.git
cd practica-ecomerce

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Crear base de datos SQLite
touch database/database.sqlite

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Compilar assets
npm run build

# 8. Enlace de storage
php artisan storage:link

# 9. Iniciar servidor
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

**Credenciales de prueba:**
| Rol           | Correo                          | Clave |
|---------------|---------------------------------|-------|
| Administrador | admin@tuxtla.tecnm.mx           | 123   |
| Gerente       | gerente@tienda.com              | 123   |

## Ejecución de pruebas

```bash
php artisan test
```

Las pruebas usan SQLite en memoria (configurado en `phpunit.xml`). No requieren configuración adicional.

```bash
# Ver detalle de cada prueba
php artisan test --verbose
```

## Pipeline CI (GitHub Actions)

El archivo `.github/workflows/laravel.yml` ejecuta automáticamente al hacer push o pull request a `main`:

1. Clonar repositorio
2. Instalar PHP 8.2
3. Instalar dependencias Composer
4. Configurar entorno (.env + APP_KEY)
5. Configurar SQLite
6. Ejecutar migraciones
7. Ejecutar seeders
8. Ejecutar pruebas automáticas

## Despliegue en la nube

La aplicación está desplegada en **Render.com** usando Docker.

**URL pública:** `https://ecommerce-practica.onrender.com`

### Despliegue manual en Render

1. Crear cuenta en [render.com](https://render.com)
2. New → Web Service → conectar este repositorio
3. Seleccionar `Docker` como entorno
4. Configurar las variables de entorno listadas abajo
5. Render despliega automáticamente en cada push a `main` (CD)

### Variables de entorno requeridas

Configurar en la plataforma cloud (NO subir al repositorio):

```
APP_NAME=EcommercePractica
APP_ENV=production
APP_KEY=           # Generar con: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
LOG_CHANNEL=stderr
```

## Estructura del proyecto

```
.
├── .github/
│   └── workflows/
│       └── laravel.yml      # Pipeline CI
├── app/
│   ├── Http/Controllers/    # AuthController, ProductoController, etc.
│   ├── Mail/                # Mailables (2FA, ventas)
│   ├── Models/              # Usuario, Producto, Venta, etc.
│   └── Policies/            # VentaPolicy, UsuarioPolicy
├── database/
│   ├── factories/           # Factories para pruebas y seeders
│   ├── migrations/          # Migraciones de base de datos
│   └── seeders/             # DatabaseSeeder con datos iniciales
├── docker/                  # Configuración Docker (Apache + start script)
├── tests/
│   └── Feature/
│       └── EcommerceTest.php # 7 pruebas automáticas
├── Dockerfile               # Imagen para deploy en la nube
├── render.yaml              # Configuración de Render.com
└── .env.example             # Variables de entorno de ejemplo
```