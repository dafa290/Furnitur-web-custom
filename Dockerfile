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

RUN docker-php-ext-install pdo_mysql pdo_sqlite zip

# Install Node.js 20 from NodeSource (Vite 5 needs Node 18+)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Create .env from .env.example so composer & artisan work during build
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Make startup script executable
RUN chmod +x start.sh

# Expose the port Hugging Face uses
EXPOSE 7860

# Run the startup script
CMD ["./start.sh"]
