#!/bin/sh
set -eu

cd /var/www/html

php artisan config:clear
php artisan migrate --force

php artisan db:seed \
    --class=ChatbotKnowledgeSeeder \
    --force

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

php artisan config:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

exec apache2-foreground