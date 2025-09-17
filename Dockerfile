FROM php:8.2-apache

# Fix ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable Apache rewrite module
RUN a2enmod rewrite

# ✅ Install MySQLi and PDO MySQL
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Copy all files to Apache web root
COPY . /var/www/html/

# Set proper file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
