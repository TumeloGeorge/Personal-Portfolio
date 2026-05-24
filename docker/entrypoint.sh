#!/bin/sh
set -e

GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo "${BLUE}Starting Laravel portfolio application...${NC}"

# Substitute PORT into nginx config
export NGINX_PORT=${PORT:-80}
envsubst '${NGINX_PORT}' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf

# Wait for database to be ready (only when DB_HOST is explicitly set)
if [ -n "$DB_HOST" ] && [ "$SKIP_DB_CHECK" != "true" ]; then
    echo "${BLUE}Waiting for database connection...${NC}"
    while ! nc -z ${DB_HOST} ${DB_PORT:-3306} 2>/dev/null; do
        echo "Waiting for database..."
        sleep 2
    done
    echo "${GREEN}Database is ready!${NC}"
fi

# Run migrations if needed
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "${BLUE}Running database migrations...${NC}"
    php artisan migrate --force
    echo "${GREEN}Migrations completed!${NC}"
fi

# Run seeders if needed
if [ "$RUN_SEEDERS" = "true" ]; then
    echo "${BLUE}Running database seeders...${NC}"
    php artisan db:seed
    echo "${GREEN}Seeders completed!${NC}"
fi

# Cache config for production
if [ "$APP_ENV" = "production" ]; then
    echo "${BLUE}Caching configuration...${NC}"
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "${GREEN}Configuration cached!${NC}"
fi

php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "${GREEN}Application is ready!${NC}"
echo "${BLUE}Starting services...${NC}"

exec "$@"
