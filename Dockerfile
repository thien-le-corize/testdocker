# Sử dụng hình ảnh PHP 8.0
FROM php:8.0-fpm

# Arguments được định nghĩa trong docker-compose.yml
ARG user
ARG uid

# Cài đặt các dependency hệ thống và các extension PHP cần thiết
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
    libgmp-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo người dùng hệ thống để chạy Composer và Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Chuyển quyền user
USER $user

# Sao chép các file Composer và cài đặt dependencies
COPY composer.json composer.lock /var/www/
RUN composer install --no-scripts --no-autoloader \
    && composer clear-cache

# Sao chép mã nguồn ứng dụng
COPY . /var/www/

# Tạo optimized autoload files
RUN composer dump-autoload --optimize --no-scripts
