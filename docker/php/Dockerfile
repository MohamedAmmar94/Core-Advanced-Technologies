# Base image PHP with Apache
FROM php:8.4-apache

# Set working directory
WORKDIR /var/www/html
# Install supervisor
# Install system dependencies
RUN apt-get update && apt-get install -y  && apt-get install -y supervisor\
    git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libxml2-dev curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite
# Copy supervisor config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# Copy entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set permissions for Laravel folders
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
