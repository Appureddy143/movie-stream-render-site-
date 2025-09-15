# Use an official PHP image with Apache
FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache rewrite module (if needed)
RUN a2enmod rewrite

# Copy project files into the container
COPY . /var/www/html/

# Set permissions for Apache to access files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
