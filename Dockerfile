# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Install dependencies and PHP extensions for PostgreSQL and MySQLi
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli pgsql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy your project files into the container
COPY . /var/www/html/

# Set proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for web traffic
EXPOSE 80
