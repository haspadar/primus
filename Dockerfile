FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    bash \
    fish \
    libzip-dev \
    libicu-dev \
    zlib1g-dev \
    libonig-dev \
    tzdata \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install intl zip opcache bcmath mbstring

# Install Xdebug
RUN pecl install xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install Composer (latest)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set timezone
RUN ln -fs /usr/share/zoneinfo/Europe/Minsk /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist

ENTRYPOINT ["fish"]
