FROM php:7.4-apache

# Install required packages
RUN apt-get update && \
    apt-get install -y libssh2-1-dev libssh2-1 && \
    rm -rf /var/lib/apt/lists/*

# Install ssh2 extension
RUN pecl install ssh2-1.3.1 && \
    docker-php-ext-enable ssh2

# Copy application files to container
COPY index.php /var/www/html

# Expose port 80
EXPOSE 80
