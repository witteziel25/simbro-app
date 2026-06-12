FROM php:8.3-apache

# Update dan Install dependencies OS
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libwebp-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP (termasuk GD dengan WEBP, dan pdo_mysql untuk Aiven MySQL)
RUN docker-php-ext-configure gd --with-webp
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Mengaktifkan Apache mod_rewrite
RUN a2enmod rewrite

# Mengganti konfigurasi Apache agar menunjuk ke folder public Laravel
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menyiapkan folder kerja
WORKDIR /var/www/html

# Copy semua file ke dalam container
COPY . .

# Set hak akses
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies PHP (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Jadikan start.sh dapat dieksekusi
RUN chmod +x /var/www/html/start.sh

# Jalankan start.sh saat container mulai
ENTRYPOINT ["/var/www/html/start.sh"]
