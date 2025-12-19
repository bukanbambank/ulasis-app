#!/usr/bin/env bash
set -euo pipefail

# Oracle Cloud / Ubuntu setup script (tested on Ubuntu 22.04 / 24.04)
# Usage: run as root or use sudo
# Example:
#   sudo bash oracle_setup.sh your_user /var/www/ulasis
# Parameters:
# $1 - deploy user (will be created if not exists)
# $2 - webroot (defaults to /var/www/ulasis)

DEPLOY_USER=${1:-ubuntu}
WEBROOT=${2:-/var/www/ulasis}
REPO_DIR=${3:-$WEBROOT}
APP_ENV=${4:-production}

echo "Deploy script started: user=$DEPLOY_USER, webroot=$WEBROOT"

# --- Basic system packages ---
apt-get update -y
apt-get upgrade -y
apt-get install -y curl wget git unzip ca-certificates lsb-release software-properties-common

# --- Create deploy user if missing ---
if ! id -u "$DEPLOY_USER" >/dev/null 2>&1; then
  adduser --disabled-password --gecos "" "$DEPLOY_USER"
  usermod -aG sudo "$DEPLOY_USER"
fi

# --- Install PHP 8.1 (or latest available) and extensions ---
# Adjust PHP version if desired
PHP_VERSION=8.1
add-apt-repository -y ppa:ondrej/php
apt-get update -y
apt-get install -y php${PHP_VERSION} php${PHP_VERSION}-fpm php${PHP_VERSION}-mysql php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring php${PHP_VERSION}-curl php${PHP_VERSION}-zip php${PHP_VERSION}-gd php${PHP_VERSION}-bcmath php${PHP_VERSION}-intl php${PHP_VERSION}-opcache

# --- Composer ---
EXPECTED_COMPOSER="/usr/local/bin/composer"
if [ ! -f "$EXPECTED_COMPOSER" ]; then
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# --- Nginx ---
apt-get install -y nginx
systemctl enable nginx

# --- MySQL (you may prefer a managed DB) ---
apt-get install -y mariadb-server
systemctl enable mariadb
# Secure install (interactive) is recommended. We leave credentials creation manual in README.

# --- Certbot ---
apt-get install -y certbot python3-certbot-nginx

# --- PHP-FPM tuning ---
systemctl enable php${PHP_VERSION}-fpm

# --- Firewall ---
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw --force enable

# --- Clone repo as deploy user ---
if [ ! -d "$WEBROOT" ]; then
  mkdir -p "$WEBROOT"
  chown "$DEPLOY_USER":"$DEPLOY_USER" "$WEBROOT"
fi

# After cloning, perform composer install as deploy user
# Example:
# sudo -i -u $DEPLOY_USER bash -c "cd $WEBROOT && git clone <repo> . && composer install --no-dev --optimize-autoloader"

cat <<'EOF'
=== Post-clone manual steps (run as the deploy user or adjust paths) ===
1) cd into project (webroot)
2) composer install --no-dev --optimize-autoloader
3) cp .env.example .env
4) Edit .env with production settings (APP_ENV=production, APP_DEBUG=false, APP_URL=https://ulasis.site, DB_*, MAIL_*)
5) php artisan key:generate
6) php artisan migrate --force
7) php artisan storage:link
8) php artisan config:cache; php artisan route:cache; php artisan view:cache
9) chown -R www-data:www-data storage bootstrap/cache
10) Setup systemd service (provided in deploy/) and enable it
11) Configure Nginx site (deploy/nginx_ulasis.conf) - symlink to /etc/nginx/sites-enabled/
12) Obtain TLS certificate: sudo certbot --nginx -d ulasis.site -d www.ulasis.site
EOF

echo "Setup script finished. Run post-clone manual steps listed above as the deploy user." 
