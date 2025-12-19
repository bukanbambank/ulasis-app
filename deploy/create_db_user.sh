#!/usr/bin/env bash
set -euo pipefail

# create_db_user.sh
# Usage (on server, run as root or with sudo):
#   sudo bash create_db_user.sh <db_name> <db_user> <db_password> [host]
# Example:
#   sudo bash create_db_user.sh ulasis ulasis S3cur3P@ssw0rd

DB_NAME=${1:-}
DB_USER=${2:-}
DB_PASS=${3:-}
DB_HOST=${4:-localhost}

if [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS" ]; then
  echo "Usage: sudo bash create_db_user.sh <db_name> <db_user> <db_password> [host]"
  exit 2
fi

# Detect mysql client command (mysql or mariadb)
if command -v mysql >/dev/null 2>&1; then
  MYSQL_CMD="mysql"
else
  echo "mysql client not found. Please install mariadb-client or mysql-client and try again."
  exit 1
fi

# Execute SQL as root via sudo mysql (works for Ubuntu with no root password)
SQL="CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n"
SQL+="CREATE USER IF NOT EXISTS '$DB_USER'@'$DB_HOST' IDENTIFIED BY '$DB_PASS';\n"
SQL+="GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'$DB_HOST';\n"
SQL+="FLUSH PRIVILEGES;\n"

echo "Creating database and user..."

# If sudo mysql exists, use it; otherwise attempt running mysql directly
if sudo bash -c "command -v mysql >/dev/null 2>&1"; then
  echo -e "$SQL" | sudo mysql -v
else
  echo -e "$SQL" | $MYSQL_CMD -u root -p
fi

echo "Done. Database '$DB_NAME' and user '$DB_USER' created (host: $DB_HOST)."

# Print .env snippet
cat <<EOF

Add this to your .env file (example):

DB_CONNECTION=mysql
DB_HOST=$DB_HOST
DB_PORT=3306
DB_DATABASE=$DB_NAME
DB_USERNAME=$DB_USER
DB_PASSWORD=$DB_PASS

EOF
