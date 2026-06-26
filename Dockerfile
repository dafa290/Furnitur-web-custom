FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update -y && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql pdo_sqlite zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Make startup script executable
RUN chmod +x start.sh

# Expose the port Hugging Face uses
EXPOSE 7860

# Run the startup script
CMD ["./start.sh"]
