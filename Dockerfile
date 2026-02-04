FROM php:8.2-cli

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
    && docker-php-ext-install pdo_pgsql mbstring zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório da aplicação
WORKDIR /app

# Copiar arquivos
COPY . .

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependências front-end
RUN npm install && npm run build

# Permissões
RUN chmod -R 775 storage bootstrap/cache

# Storage link
RUN php artisan storage:link || true

EXPOSE 10000

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true


CMD php artisan migrate --force --seed || true && php artisan serve --host=0.0.0.0 --port=10000
