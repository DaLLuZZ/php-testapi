# PHP API
The PHP API for fuckTimer.

## Status: Inactive
Code isn't "optimized", lot of test/old code left, ... please waste your time for your own codes.
This project was born as a meme. So you'll not find the "best code" here, but I'm sure you're the best coder with your private plugins.

## Setup

### Requirements
1. Web- and MySQL server required. Google, Bing and DuckDuckGo Search provides enough tutorials
      - Notes:
         - Caddy (Webserver) won't work correctly.
         - Supported MySQL servers: `MariaDB 10.2` (or above) or `MySQL 5.7` (or above)
2. Install PHP 7.4 or above as well as:
   - `php-xml`
   - `php-mysql`
   - `php-mbstring`
3. Install composer.
   - `curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer`
   - https://getcomposer.org/doc/00-intro.md

### Installation
1. `composer install --optimize-autoloader --no-dev`
2. Copy `.env.example` to `.env` and populate values.
3. `php artisan migrate:fresh` if you've not set up the DB already.

### Run
PHP Example:
- `php -S localhost:8080 -t public/` to serve locally.

nginx Example:
- [config example](https://laravel.com/docs/8.x/deployment#nginx)

Docker Example:
- `curl -sSL https://get.docker.com/ | CHANNEL=stable bash`
- `apt install docker-compose`
- Change webserver port in docker-compose.yml, if you don't want 8080
- `docker-compose up -d`

### Update from older version(s):
- Upload files from this repository
- Run `php artisan migrate`
