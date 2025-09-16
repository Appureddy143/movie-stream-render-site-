FROM php:8.2-apache

# Install PostgreSQL extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Enable rewrite
RUN a2enmod rewrite

# Set a ServerName so Apache doesn’t warn
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy your app
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Make sure Apache listens on all interfaces
# Note: The base image’s default config usually listens on all interfaces
# But if you have custom vhost or ports config, ensure it's `Listen 80` and `VirtualHost *:80`

EXPOSE 80

# Entrypoint
CMD ["apache2-foreground"]
