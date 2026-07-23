#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    echo "Installing PHP dependencies..."
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=base64" .env; then
    php artisan key:generate --force
fi

echo "Waiting for MySQL at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
until mysqladmin ping -h "${DB_HOST:-mysql}" -P "${DB_PORT:-3306}" -u"${DB_USERNAME:-root}" -p"${DB_PASSWORD}" --silent 2>/dev/null; do
    sleep 2
done
echo "MySQL is up."

php artisan migrate --force
php artisan db:seed --force

if [ ! -f node_modules/.bin/vite ]; then
    echo "Installing JS dependencies..."
    npm install
fi

echo "Building frontend assets..."
npm run build

php artisan storage:link || true

echo "Starting Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8000
