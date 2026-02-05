FROM php:8.2-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm \
    nginx \
    && docker-php-ext-install pdo_pgsql mbstring zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar código
COPY . .

# PHP deps
RUN composer install --no-dev --optimize-autoloader

# Frontend
RUN npm install && npm run build

# Permissões
RUN chmod -R 775 storage bootstrap/cache

# Limpeza
RUN php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan cache:clear || true

# Configuração Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

EXPOSE 10000

CMD sh -c "chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan storage:link || true \
    && php artisan migrate --force || true \
    && php-fpm -D \
    && nginx -g 'daemon off;'"
