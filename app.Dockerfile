FROM php:8.3-fpm

# Install system dependencies (I never remember these I have to look them up most of the time.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a non-root user
RUN groupadd -g 1000 appuser && useradd -u 1000 -g appuser -m appuser

# Set working directory
WORKDIR /var/www

# Copy application files
COPY --chown=appuser:appuser . /var/www

# Setting some permissions because the server needs to be able to write to these files
RUN chmod -R 755 /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R appuser:appuser /var/www


USER appuser

RUN composer install --no-interaction --no-plugins --no-scripts

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
