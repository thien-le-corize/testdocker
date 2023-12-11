# Use PHP 8.0 image
FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libbz2-dev \
    libgmp-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create www-data group if it doesn't exist
RUN getent group www-data || groupadd -g 33 www-data

# Create system user to run Composer and Artisan Commands
RUN useradd -ms /bin/bash -u $uid -g www-data $user

# Create necessary directories
RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set the working directory
WORKDIR /var/www

USER $user

# Copy composer files and install dependencies
COPY composer.json composer.lock /var/www/
RUN composer install --no-scripts --no-autoloader \
    && composer clear-cache

# Copy the rest of the application code
COPY . /var/www/

# Generate optimized autoload files
RUN composer dump-autoload --optimize --no-scripts
