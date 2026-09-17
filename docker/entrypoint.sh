#!/bin/sh
set -e

# O SQLite fica no volume /data para os dados sobreviverem aos deploys (RNF-06)
DB_FILE="${DB_DATABASE:-/data/database.sqlite}"
touch "$DB_FILE"

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
