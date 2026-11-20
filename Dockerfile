FROM php:8.2-apache

# Install dependencies sistem & driver PostgreSQL (Supabase) + MySQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql bcmath gd zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Aktifkan mod_rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke folder public/ milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Salin seluruh file proyek
COPY . .

# Salin Composer binary dan install dependencies (production)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Berikan izin ke storage dan bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Salin dan siapkan script entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Port default Render Web Service
EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
