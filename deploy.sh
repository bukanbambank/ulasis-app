#!/bin/bash
set -e

echo "Starting Deployment..."

# 1. Prepare Directories
echo "Cleaning old app..."
rm -rf ulasis-app
mkdir -p ulasis-app

# 2. Extract Core
echo "Extracting Core..."
unzip -q -o ulasis-core.zip -d ulasis-app

# 3. Setup Env
echo "Configuring Environment..."
if [ -f .env.production ]; then
    mv .env.production ulasis-app/.env
else
    echo ".env.production not found! Using example."
    cp ulasis-app/.env.example ulasis-app/.env
fi

# 4. Extract Assets (Build)
echo "Extracting Assets..."
rm -rf ulasis-assets
unzip -q -o ulasis-build.zip -d ulasis-assets
if [ -d "ulasis-assets/public/build" ]; then
    mkdir -p ulasis-app/public/build
    cp -r ulasis-assets/public/build/* ulasis-app/public/build/
fi

# 5. Public HTML Setup
echo "Updating public_html..."
# Backup old public_html?
# mkdir -p public_html_bak
# cp -r public_html/* public_html_bak/
# Clean public_html (Be careful!)
rm -rf public_html/*
cp -r4 ulasis-app/public/* public_html/
cp -r ulasis-app/public/.htaccess public_html/ 2>/dev/null || true

# 6. Fix index.php paths
echo "Patching index.php..."
sed -i "s|__DIR__.'/../vendor|__DIR__.'/../ulasis-app/vendor|g" public_html/index.php
sed -i "s|__DIR__.'/../bootstrap|__DIR__.'/../ulasis-app/bootstrap|g" public_html/index.php

# 7. Install Dependencies
echo "Installing Dependencies (Composer)..."
cd ulasis-app
# Check if composer is available, else download it
if ! command -v composer &> /dev/null; then
    echo "Composer not found, downloading..."
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev --optimize-autoloader
else
    composer install --no-dev --optimize-autoloader
fi

# 8. Artisan Commands
echo "Running Artisan commands..."
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# 9. Storage Link
echo "Linking Storage..."
cd ../public_html
rm -rf storage
ln -s ../ulasis-app/storage/app/public storage

echo "Deployment Completed Successfully!"
