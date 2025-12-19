Oracle Cloud VM deployment guide for Ulasis (Laravel)

Overview
--------
This guide helps you deploy your Laravel app to an Oracle Cloud Ubuntu VM (Always Free instance recommended).
It covers:
- Provisioning the VM
- Installing dependencies (Nginx, PHP-FPM, Composer, MariaDB)
- Deploying code and configuring `.env`
- Setting up Nginx site and obtaining TLS via Certbot
- Running migrations, caching config, and enabling background queue worker

1) Provision an Ubuntu VM on Oracle Cloud
---------------------------------------
- Create an instance (VM.Standard.E2.1.Micro or Always Free shape) with Ubuntu 22.04 or 24.04.
- Configure a public IPv4 and make sure SSH ingress is allowed.
- Note the public IP address.

2) DNS
------
- In your DNS provider, create these records:
  - A record: ulasis.site -> <your VM public IP>
  - A record: www.ulasis.site -> <your VM public IP>

3) SSH and run bootstrap script
-------------------------------
On your local machine:
```bash
# copy deploy script to server and run
scp deploy/oracle_setup.sh ubuntu@<VM_IP>:/tmp/oracle_setup.sh
ssh ubuntu@<VM_IP>
# on server (as ubuntu):
sudo bash /tmp/oracle_setup.sh ubuntu /var/www/ulasis
```
The script installs packages and shows post-clone manual steps.

4) Clone your repo and install composer deps
-------------------------------------------
On the VM, as the deploy user:
```bash
cd /var/www/ulasis
git clone <your-repo-url> .
composer install --no-dev --optimize-autoloader
cp .env.example .env
# Edit .env: set APP_ENV=production, APP_DEBUG=false, APP_URL=https://ulasis.site
# Set DB connection (or use managed DB): DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Set MAIL settings (SMTP provider) - see SMTP section below
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache
```

5) Nginx configuration
----------------------
Copy `deploy/nginx_ulasis.conf` to `/etc/nginx/sites-available/ulasis` and create a symlink:
```bash
sudo cp deploy/nginx_ulasis.conf /etc/nginx/sites-available/ulasis
sudo ln -s /etc/nginx/sites-available/ulasis /etc/nginx/sites-enabled/ulasis
sudo nginx -t
sudo systemctl reload nginx
```

6) Obtain TLS certificate
-------------------------
Use certbot to obtain and enable certificates (will edit nginx config automatically):
```bash
sudo certbot --nginx -d ulasis.site -d www.ulasis.site
# follow the interactive prompts
```

7) Queue worker (systemd)
-------------------------
Copy unit file and enable it:
```bash
sudo cp deploy/ulasis-queue.service /etc/systemd/system/ulasis-queue.service
sudo systemctl daemon-reload
sudo systemctl enable --now ulasis-queue.service
```
If you use horizon or supervisor, adapt accordingly.

8) Cron (Laravel Scheduler)
---------------------------
Add cron entry for the deploy user or root:
```cron
* * * * * cd /var/www/ulasis && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

9) Database
-----------
You can either install MariaDB/MySQL on the VM (the setup script installed mariadb-server) or use a managed DB.
To create DB and user on the VM (secure if only accessible internally):
```sql
sudo mysql -u root
CREATE DATABASE ulasis;
CREATE USER 'ulasis'@'localhost' IDENTIFIED BY 'strongpassword';
GRANT ALL PRIVILEGES ON ulasis.* TO 'ulasis'@'localhost';
FLUSH PRIVILEGES;
```
Update `.env` accordingly:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ulasis
DB_USERNAME=ulasis
DB_PASSWORD=strongpassword

10) SMTP for production
-----------------------
Use Mailgun/SendGrid/Mailtrap/SMTP provider. Example for Mailgun:

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain
MAIL_PASSWORD=secret
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@ulasis.site
MAIL_FROM_NAME="Ulasis"

11) Post-deploy checks
----------------------
- Visit https://ulasis.site in a browser.
- Register an account and confirm verification email delivery.
- Check logs: tail -f storage/logs/laravel.log
- Check systemd status: sudo systemctl status ulasis-queue.service

Security notes
--------------
- Keep `.env` off version control and never commit credentials.
- Use a managed DB or lock down MariaDB to accept only local connections.
- Regularly update packages and PHP security releases.

If you want, I can now:
- Generate a ready-to-use Dockerfile + Fly.io config instead (if you later change platform), or
- Create a small script to create the MySQL user + DB and to upload the `.env` safely,
- Or produce an Nginx + systemd deploy playbook you can run remotely (Ansible style).

