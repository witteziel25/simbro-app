#!/bin/bash

# Optimasi Laravel (menghapus cache lama dan membuat cache baru)
echo "Optimizing Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database
# Menggunakan --force agar berjalan otomatis di environment production
echo "Running database migrations..."
php artisan migrate --force

# Link storage lokal (berjaga-jaga jika ada file non-cloudinary)
php artisan storage:link

# Jalankan Apache dalam mode foreground
echo "Starting Apache..."
apache2-foreground
