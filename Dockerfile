FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    zip \
    libicu-dev \
    zlib1g-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

# Run composer install with no interaction and optimize autoloader
RUN composer install --no-interaction --optimize-autoloader --no-scripts

# Run scripts separately (optional)
RUN composer run-script post-install-cmd

CMD ["php-fpm"]
