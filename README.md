# WIA Studio

Laravel + Vite architectural website for WIA Studio.

## Requirements

- XAMPP with PHP 8.2+
- Composer dependencies in `vendor`
- NPM dependencies in `node_modules`
- SQLite enabled for PHP

## Main Routes

- `/` studio landing page
- `/projects` project archive
- `/projects/{slug}` project detail page
- `/contact` contact form POST route
- `/admin` inquiry and content dashboard
- `/api/projects` JSON project resources
- `/api/projects/{slug}` JSON project detail resource

## Database

The app uses SQLite:

`database/database.sqlite`

Run:

```bash
php artisan migrate:fresh --seed
```

## Frontend

Static design assets live in:

- `public/assets/css/app.css`
- `public/assets/js/app.js`

Laravel/Vite entry files live in:

- `resources/css/app.css`
- `resources/js/app.js`

Build assets with:

```bash
npm run build
```

## Local URLs

XAMPP:

`http://localhost/Wia%20Studio/`

Artisan server:

```bash
php artisan serve --host=127.0.0.1 --port=8098
```
