FROM php:8.2-apache

RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod ssl rewrite

# Generate self-signed SSL certificate (RSA 2048-bit)
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/secureweb.key \
    -out /etc/ssl/certs/secureweb.crt \
    -subj "/C=ID/ST=Jawa Barat/L=Bandung/O=Telkom University/OU=Teknik Komputer/CN=192.168.1.39"

# Apply SSL virtual host config
COPY apache/ssl.conf /etc/apache2/sites-available/ssl.conf
RUN a2dissite 000-default && a2ensite ssl

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80 443
