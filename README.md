# PHP API
The PHP API for fuckTimer.

## Setup

### Requirements
(Install Webserver. (Tested: nginx (all common versions?))
1. Install PHP 7.4 or above as well as:
   1. `php-xml`
   2. `php-mysql`
   3. `php-mbstring`
2. Install an MySQL server.
   1. MariaDB 10.2 or above
   2. MySQL 5.7 or above
4. Install composer.

### Installation
1. `composer install`
2. Copy `.env.example` to `.env` and populate values.
3. `php artisan migrate:fresh` if you've not set up the DB already.

### Run
1. `php -S localhost:8080 -t public/` to serve locally.
