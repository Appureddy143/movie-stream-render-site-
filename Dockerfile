FROM php:8.2-apache

# Fix ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable Apache rewrite
RUN a2enmod rewrite

# Install dependencies for PostgreSQL PHP extension
RUN apt-get update && apt-get install -y libpq-dev

# Install pdo_pgsql extension
RUN docker-php-ext-install pdo_pgsql

# Copy app files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
