# Use an official PHP image with Apache
FROM php:8.2-apache

# Copy project files to the container
COPY . /var/www/html/

# Optional: enable Apache mod_rewrite (if using .htaccess or routing)
RUN a2enmod rewrite

# Set permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
