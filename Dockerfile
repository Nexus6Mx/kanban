FROM php:8.2-apache

# Instalar la extensión de base de datos mysqli y la extensión zip
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip

# Configurar el DocumentRoot de Apache para que apunte al directorio /var/www/html
COPY . /var/www/html/

# Asegurarse de que el propietario del directorio sea el usuario de Apache
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80
