# Utiliser une image PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires pour les extensions PHP et Composer
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        git \
        unzip

# Installer les extensions PHP
RUN docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/project_0/public

# Mettre à jour la configuration d'Apache pour utiliser le nouveau document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Activer le mod_rewrite pour Apache
RUN a2enmod rewrite

# Changer la propriété pour www-data
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80
