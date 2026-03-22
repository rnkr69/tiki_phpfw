# Tiki PHPFW

A minimal PHP framework for web apps with simple routing, controllers, MySQL (mysqli) models, **Twig** views, basic middleware (authentication and CSRF), validation, JSON-based i18n, and mail (PHPMailer) and PDF (Dompdf) helpers.

Built from scratch as a personal project to put framework concepts into practice, without using AI in its creation.

## Requirements

- PHP 8.0 or newer (8.1+ recommended)
- **mysqli** extension
- **Composer**
- A web server whose document root points at the `public/` directory (or equivalent for local dev)
- MySQL or MariaDB

## Installation

1. **Clone or copy** the project into your environment (e.g. WAMP/XAMPP folder or your vhost).

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Environment:** copy `.env.example` to `.env` and adjust values (app, database, and mail if you send email):

   ```bash
   cp .env.example .env
   ```

   On Windows (cmd/PowerShell) you can use `copy .env.example .env` instead.

   Set at least `APP_URL`, `MYSQL_*`, and if needed the `MAIL_*` variables.

4. **Database:** the schema name must match `MYSQL_SCHEMA` in `.env`. If the database does not exist yet, the install script can create it (see next step).

5. **Run the installer** from the project root:

   ```bash
   php install.php
   ```

   This script:

   - Runs SQL migrations under `database/migrations/`.
   - If MySQL reports an “unknown database” error, it tries to create the schema via `database/generate/schema.php` (using the name from `MYSQL_SCHEMA`) and then runs migrations again.
   - Creates `storage/`, `storage/logs`, `storage/pdf`, and `storage/twigcache` if they are missing.

6. **Web server:** the public URL should use **`public/index.php`** as the front controller. Example with PHP’s built-in server:

   ```bash
   php -S localhost:8080 -t public
   ```

   On WAMP, point the virtual host `DocumentRoot` at `.../tiki_phpfw/public`.

## Usage (overview)

### Routes

URLs are defined in `routes/main.php` as an associative array: path → `[Controller, method, [optional middleware group]]`.

```php
$routes = [
    "/contact" => ["Main", "contact"],
    "/admin"   => ["Dashboard", "panel", ["auth"]],
];
```

- If the third element is omitted, the default group from `config/main.php` is used (`middleware` → usually `web`).
- With `["auth"]`, the stack from `config/middlewares.php` applies (e.g. session required).

### Controllers

PHP files in `controllers/`; the class name must match the file name (without `.php`). Methods are actions invoked by the route. For HTML views, call `Controller::getView('view_name', $data)` or, if the class extends `Controller`, `$this->getView(...)`.

### Views

**Twig** templates in `views/` (`*.html`). In production (`ENVIRONMENT=prod` in `.env`), Twig can cache templates in `storage/twigcache`.

### Models

Classes in `model/` extending `Model`. Each model targets a table (`$table` / `$tables`) and can use `save()`, `delete()`, `Model::get($id)`, `Model::getWhere(...)`, guided by metadata in `database/descriptions/` (generated from the table structure).

### Application configuration

General values in `config/main.php`. Named middleware stacks in `config/middlewares.php`.

### Internationalization

JSON files in `i18n/` (e.g. `es.json`, `en.json`). The `i18n` class exposes static methods based on JSON keys; default language and variants are set in `config/main.php` (`i18n_fallback`, `i18n_langVariants`).

### JSON responses

From a controller you can use `Controller::sendJson($data)` to return JSON.

---

For a more visual guide and extra examples, run the app and open **`/documentation`** (included in the project).

## Project layout

| Path / folder          | Purpose |
|------------------------|---------|
| `public/index.php`     | HTTP entry point |
| `kernel/`              | Router, DB, HTTP, Twig, validation, etc. |
| `controllers/`         | Controllers |
| `model/`               | Models |
| `views/`               | Twig templates |
| `middleware/`          | Middleware classes |
| `routes/main.php`      | Route table |
| `config/`              | App config and middleware groups |
| `database/migrations/` | SQL migrations |
| `storage/`             | Logs, Twig cache, generated PDFs |

## License

This project is released under the **MIT License**. See [`LICENSE`](LICENSE) for the full legal text.
