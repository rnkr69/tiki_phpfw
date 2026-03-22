# Tiki PHPFW

Framework PHP minimalista para aplicaciones web con enrutado simple, controladores, modelos sobre MySQL (mysqli), vistas con **Twig**, middleware básico (autenticación y CSRF), validación, i18n por JSON y utilidades de correo (PHPMailer) y PDF (Dompdf). 

Creado como proyecto personal desde cero intentando poner a prueba mis conocimientos sobre frameworks. Usando 0 IA para su creación.

## Requisitos

- PHP 8.0 o superior (recomendado 8.1+)
- Extensión **mysqli**
- **Composer**
- Servidor web con document root apuntando a la carpeta `public/` (o equivalente en desarrollo)
- MySQL / MariaDB

## Instalación

1. **Clonar o copiar** el proyecto en tu entorno (por ejemplo la carpeta de WAMP/XAMPP o tu vhost).

2. **Instalar dependencias:**

   ```bash
   composer install
   ```

3. **Configurar entorno:** copia `.env.example` a `.env` y ajusta valores (aplicación, base de datos y correo si usas envíos):

   ```bash
   copy .env.example .env
   ```

   Edita al menos `APP_URL`, `MYSQL_*` y, si aplica, las variables `MAIL_*`.

4. **Crear la base de datos:** el esquema debe coincidir con `MYSQL_SCHEMA` en `.env`. Si la base aún no existe, el script de instalación puede crearla (ver siguiente paso).

5. **Ejecutar el instalador** desde la raíz del proyecto (por consola, en el directorio del framework):

   ```bash
   php install.php
   ```

   Este script:

   - Ejecuta las migraciones SQL definidas en `database/migrations/`.
   - Si MySQL devuelve error “base de datos desconocida”, intenta crear el esquema usando `database/generate/schema.php` (nombre según `MYSQL_SCHEMA`) y vuelve a aplicar migraciones.
   - Crea las carpetas `storage/`, `storage/logs`, `storage/pdf` y `storage/twigcache` si no existen.

6. **Servidor web:** la URL pública debe servir **`public/index.php`** como front controller. Ejemplo con el servidor integrado de PHP:

   ```bash
   php -S localhost:8080 -t public
   ```

   En WAMP, configura un virtual host con `DocumentRoot` apuntando a `.../tiki_phpfw/public`.

## Cómo usarlo (resumen)

### Rutas

Las URLs se definen en `routes/main.php` como array asociativo: path → `[Controlador, método, [middlewares opcionales]]`.

```php
$routes = [
    "/contacto" => ["Main", "contacto"],
    "/admin"    => ["Dashboard", "panel", ["auth"]],
];
```

- Sin tercer elemento se usa el grupo por defecto de `config/main.php` (`middleware` → normalmente `web`).
- Con `["auth"]` se aplica el stack definido en `config/middlewares.php` (por ejemplo sesión obligatoria).

### Controladores

Archivos PHP en `controllers/`; el nombre de la clase debe coincidir con el nombre del fichero (sin `.php`). Los métodos son acciones invocadas por la ruta. Para vistas HTML se suele llamar a `Controller::getView('nombre_vista', $datos)` o, si la clase extiende `Controller`, `$this->getView(...)`.

### Vistas

Plantillas **Twig** en `views/` (`*.html`). En producción (`ENVIRONMENT=prod` en `.env`) Twig puede usar caché en `storage/twigcache`.

### Modelos

Clases en `model/` que extienden `Model`. Cada modelo apunta a una tabla (`$table` / `$tables`) y puede usar `save()`, `delete()`, `Model::get($id)`, `Model::getWhere(...)` según la descripción en `database/descriptions/` (generada a partir de la tabla).

### Configuración de aplicación

Valores generales en `config/main.php`. Middlewares nombrados en `config/middlewares.php`.

### Internacionalización

Ficheros JSON en `i18n/` (por ejemplo `es.json`, `en.json`). La clase `i18n` expone métodos estáticos según las claves del JSON; el idioma por defecto y variantes se configuran en `config/main.php` (`i18n_fallback`, `i18n_langVariants`).

### Respuestas JSON

Desde un controlador puedes usar `Controller::sendJson($data)` para devolver JSON.

---

Para una guía más visual y ejemplos adicionales, con la app en marcha visita la ruta **`/documentation`** (página incluida en el proyecto).

## Estructura principal

| Ruta / carpeta        | Rol |
|-----------------------|-----|
| `public/index.php`    | Punto de entrada HTTP |
| `kernel/`             | Router, DB, HTTP, Twig, validación, etc. |
| `controllers/`        | Controladores |
| `model/`              | Modelos |
| `views/`              | Plantillas Twig |
| `middleware/`         | Middlewares |
| `routes/main.php`     | Tabla de rutas |
| `config/`             | Configuración y grupos de middleware |
| `database/migrations/`| SQL de migraciones |
| `storage/`            | Logs, caché Twig, PDFs generados |

## Licencia

Este proyecto está publicado bajo la **Licencia MIT**. Consulta el archivo [`LICENSE`](LICENSE) para el texto legal completo.
