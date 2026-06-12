# Menggunakan image PHP resmi yang sudah include Apache web server
FROM php:8.2-apache

# Instal ekstensi PostgreSQL yang dibutuhkan oleh CodeIgniter 4
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Aktifkan modul mod_rewrite Apache supaya URL routing CI4 (seperti /item) bekerja
RUN a2enmod rewrite

# Ubah DocumentRoot Apache agar langsung mengarah ke folder public milik CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Salin seluruh kodingan proyek kamu ke dalam direktori server kontainer
COPY . /var/www/html/

# Berikan hak akses penuh (permission) agar folder upload gambar tidak error saat dicoba
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/public/assets/img/upload

# Buka port standar server
EXPOSE 80
