FROM php:8.2-cli

# Définir le dossier de travail dans le container
WORKDIR /var/www/html

# Tu peux installer des extensions PHP si besoin, par exemple :
# RUN docker-php-ext-install mysqli pdo pdo_mysql
