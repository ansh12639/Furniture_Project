#!/bin/bash
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until mysql -h "${DB_HOST:-mysql}" -P "${DB_PORT:-3306}" -u "${DB_USER:-root}" -p"${DB_PASSWORD:-}" -e "SELECT 1" > /dev/null 2>&1; do
  echo "MySQL is not ready yet. Retrying in 3s..."
  sleep 3
done

echo "MySQL is ready!"

# Create database if it doesn't exist
mysql -h "${DB_HOST:-mysql}" -P "${DB_PORT:-3306}" -u "${DB_USER:-root}" -p"${DB_PASSWORD:-}" \
  -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME:-furniture_db}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import schema only if products table is empty (idempotent)
PRODUCT_COUNT=$(mysql -h "${DB_HOST:-mysql}" -P "${DB_PORT:-3306}" -u "${DB_USER:-root}" -p"${DB_PASSWORD:-}" \
  "${DB_NAME:-furniture_db}" -se "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME:-furniture_db}' AND table_name='products';" 2>/dev/null || echo "0")

if [ "$PRODUCT_COUNT" = "0" ]; then
  echo "Importing database schema and seed data..."
  mysql -h "${DB_HOST:-mysql}" -P "${DB_PORT:-3306}" -u "${DB_USER:-root}" -p"${DB_PASSWORD:-}" \
    "${DB_NAME:-furniture_db}" < /var/www/html/database/init.sql
  echo "Database initialized successfully!"
else
  echo "Database already initialized, skipping import."
fi

# Start Apache
exec "$@"
