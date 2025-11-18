FROM docker_test-php:latest

# Installer PDO MySQL si ton image ne l'a pas encore
RUN docker-php-ext-install pdo pdo_mysql

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier ton projet dans le container
COPY . /var/www/html
