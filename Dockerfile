FROM php:8.1.3-fpm-alpine3.15

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    openssl \
    curl \
    git vim unzip cron \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    pdo_mysql \
    tokenizer

# Install PHP Xdebug 2.9.8
RUN pecl install -o xdebug-2.9.8

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g n \
    && n stable

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

CMD ["php-fpm"]