# --- PHP deps stage (only to get vendor assets used by Vite/Tailwind) ---
FROM composer:2.8 AS php_deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --no-scripts \
  --ignore-platform-reqs

# --- Frontend build stage ---
FROM node:20-bookworm-slim AS frontend
WORKDIR /app

# Copy only what Vite needs to build
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm install --frozen-lockfile; \
    elif [ -f yarn.lock ]; then corepack enable && yarn install --frozen-lockfile; \
    else npm install; fi

COPY vite.config.* ./
COPY resources ./resources
COPY public ./public
COPY tailwind.config.* postcss.config.* ./

# Bring in vendor files referenced by Tailwind v4 `@source` / `@import` directives.
# - resources/css/app.css imports ../../vendor/wireui/wireui/ts/global.css
# - resources/css/app.css scans ../../vendor/wireui/wireui via @source
# - resources/css/app.css scans Laravel pagination views via @source
COPY --from=php_deps /app/vendor/wireui/wireui /app/vendor/wireui/wireui
COPY --from=php_deps /app/vendor/laravel/framework/src/Illuminate/Pagination/resources/views /app/vendor/laravel/framework/src/Illuminate/Pagination/resources/views

RUN if [ -f package-lock.json ]; then npm run build; \
    elif [ -f pnpm-lock.yaml ]; then pnpm run build; \
    elif [ -f yarn.lock ]; then yarn build; \
    else npm run build; fi

# --- PHP/FrankenPHP stage ---
FROM dunglas/frankenphp:1.5-php8.3-bookworm

# Install Composer (using latest 2026 version)
COPY --from=composer:2.8 /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# System dependencies for Debian (apt-get instead of apk)
RUN apt-get update && apt-get install -y --no-install-recommends \
    bash \
    gosu \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (standard for FrankenPHP/Octane)
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    zip \
    opcache \
    pcntl

# PHP config
COPY docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /app

# Copy dependency files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# Copy application
COPY . .

# Copy built Vite assets into final image
COPY --from=frontend /app/public/build /app/public/build


# Set permissions for the www-data user
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/views \
    storage/framework/sessions \
    storage/framework/testing \
    storage/logs \
    storage/app/public \
    bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Entrypoint fixes permissions for mounted volumes, then drops privileges.
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Generate optimized autoload files
# RUN composer dump-autoload --optimize

# Disable FrankenPHP auto-update in Octane
ENV OCTANE_FRANKENPHP_AUTO_UPDATE=0

ENTRYPOINT ["/usr/local/bin/entrypoint"]

# Start Octane
# Use octane:frankenphp for more direct control in Docker
CMD ["php", "artisan", "octane:start", \
    "--server=frankenphp", \
    "--host=0.0.0.0", \
    "--port=8000", \
    "--workers=1", \
    "--max-requests=250", \
    "--no-interaction"]

