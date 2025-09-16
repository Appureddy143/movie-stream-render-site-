# Use official PHP image with Apache
FROM php:8.2-apache

# Install PostgreSQL PHP extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Fix Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy your PHP app to the container
COPY . /var/www/html/

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Run Apache in foreground
CMD ["apache2-foreground"]
