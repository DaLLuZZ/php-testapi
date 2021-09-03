FROM php:8.0.10-fpm
# Both 7.4 and 8.0.3 works

COPY composer.lock composer.json /var/www/
WORKDIR /var/www

# Install deps, could remove most to decrease size
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev

# DEBUG TOOLS
#RUN apt-get install vim git curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip exif pcntl

# Install composer and install production packages
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/ && composer install --no-dev

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy app data
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
