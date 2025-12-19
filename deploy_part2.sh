#!/bin/bash
set -e
echo "Starting Deployment Part 2..."

# 6. Fix index.php paths
echo "Patching index.php..."
# We use simple quotes to avoid bash substitution issues if any
sed -i "s|__DIR__.'/../vendor|__DIR__.'/../ulasis-app/vendor|g" public_html/index.php
sed -i "s|__DIR__.'/../bootstrap|__DIR__.'/../ulasis-app/bootstrap|g" public_html/index.php

# 7. Install Dependencies
echo "Installing Dependencies..."
cd ulasis-app
if ! command -v composer &> /dev/null; then
    echo "Composer not found, downloading..."
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev --optimize-autoloader
else
    composer install --no-dev --optimize-autoloader
fi

# 8. Artisan Commands
echo "Running Artisan..."
php artisan key:generate || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan migrate --force

# 9. Storage Link
echo "Linking Storage..."
cd ../public_html
rm -rf storage
ln -s ../ulasis-app/storage/app/public storage

echo "Deployment Part 2 Completed Successfully!"
