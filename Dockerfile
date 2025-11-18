FROM docker_test-php:latest
COPY . /var/www/html
WORKDIR /var/www/html