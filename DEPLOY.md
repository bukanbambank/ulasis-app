# Deployment Guide for cPanel

## Overview
This guide describes how to deploy the **Ulasis v2** application to a cPanel shared hosting environment.

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer (local)
- Node.js & NPM (local)

## Directory Structure Plan
Shared hosting typically splits files into `public_html` (web root) and a protected folder for application code.

```text
/home/username/
├── ulasis-app/           <-- Application Core (Protected)
│   ├── app/
│   ├── config/
│   ├── .env
│   └── ...
└── public_html/          <-- Publicly Accessible
    ├── index.php         <-- Modified entry point
    ├── build/            <-- Compiled Assets
    └── storage/          <-- Symlink
```

## Step-by-Step Deployment

### 1. Build Locally
Prepare the application for production locally:
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Prepare Files for Upload
1.  **Core Files:** Zip everything **EXCEPT** `node_modules`, `.git`, `.idea`, `tests`.
    *   *Note:* You CAN upload `vendor` if you can't run composer on server. If you can run composer on server, exclude `vendor` too.
2.  **Public Files:** Separate the contents of the `public/` directory.

### 3. Upload to Server
1.  **Core:** Upload the core zip to `/home/username/ulasis-app/`. Extract it.
2.  **Public:** Upload the contents of `public/` to `/home/username/public_html/` (or your subdomain folder).

### 4. Configure `index.php`
Edit `/home/username/public_html/index.php` to point to the core folder:

```php
// Existing line:
// require __DIR__.'/../vendor/autoload.php';

// Change to:
require __DIR__.'/../ulasis-app/vendor/autoload.php';

// Existing line:
// $app = require_once __DIR__.'/../bootstrap/app.php';

// Change to:
$app = require_once __DIR__.'/../ulasis-app/bootstrap/app.php';
```

### 5. Environment Configuration
1.  Upload `.env.example` to `/home/username/ulasis-app/.env`.
2.  Edit `.env`:
    *   Set `APP_ENV=production`
    *   Set `APP_DEBUG=false`
    *   Set `APP_URL=https://yourdomain.com`
    *   Configure Backend DB credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

### 6. Database Setup
1.  Create a Database and User in cPanel "MySQL Databases".
2.  Run Migrations:
    *   **Option A (Terminal):** `cd ~/ulasis-app && php artisan migrate --force`
    *   **Option B (Manual):** Import a local SQL dump via phpMyAdmin.

### 7. Storage Linking
Run this command in terminal to link storage:
```bash
cd ~/public_html
ln -s ../ulasis-app/storage/app/public storage
```
*If terminal is unavailable, you can use a PHP script calling `symlink()`.*

### 8. Verification
1.  Visit `https://yourdomain.com/bmad_cpanel_check.php` (Upload it first) to check requirements.
2.  Test Login and core features.

## Troubleshooting
- **403 Forbidden:** Check `.htaccess` in `public_html`.
- **500 Error:** Check `../ulasis-app/storage/logs/laravel.log`.
- **Assets 404:** Ensure `npm run build` ran and `public/build` exists.
