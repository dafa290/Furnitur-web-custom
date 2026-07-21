FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update -y && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql pdo_sqlite zip opcache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Create .env from .env.example so composer & artisan work during build
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Fix Windows CRLF line endings in start.sh and make it executable
RUN sed -i 's/\r$//' start.sh && chmod +x start.sh

# Expose the port Hugging Face uses (Removed to allow Railway dynamic PORT)

# Run the startup script
CMD ["./start.sh"]
