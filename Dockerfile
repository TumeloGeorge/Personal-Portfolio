# Multi-stage build for Laravel app

# Stage 1: Build assets
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY . .

RUN npm run build

# Stage 2: PHP application
FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    autoconf \
    bash \
    build-base \
    curl \
    freetype-dev \
    icu-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    linux-headers \
    mariadb-dev \
    oniguruma-dev \
    postgresql-dev \
    supervisor \
    nginx \
    gettext \
    yaml-dev \
    zlib-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        gd \
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        opcache \
        intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app
# Set permissions for www-data user
# Copy application code
COPY --chown=www-data:www-data . .
# Copy .env file
# Copy built assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies for the production image only
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-scripts

# Create storage directories and set permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views /var/log/supervisor /var/run \
    && chown -R www-data:www-data storage bootstrap/cache /var/log/supervisor /var/run \
    && chmod -R 775 storage bootstrap/cache /var/log/supervisor /var/run

# Copy nginx configuration
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Copy supervisor configuration
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
