# Utiliser l'image PHP officielle
FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances PHP via Composer
RUN composer install

# Enable Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Copier la configuration VirtualHost dans Apache
COPY ./virtualhost.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80
