# Utiliser l'image PHP officielle
FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update \
    && apt-get install -y default-mysql-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le fichier composer.json
COPY ./composer.json /var/www/html

# Copier les fichiers du projet
COPY ./ /var/www/html

# Installer les dépendances PHP via Composer
RUN composer install

# Configurer Apache pour définir ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

#Configuration de la réécriture de l'URL d'apache
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80
