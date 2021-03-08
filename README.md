# PHP API
The PHP API for fuckTimer.

## Setup

### Requirements
1. Install PHP 7.3 or above as well as:
   1. `php-xml`
   2. `php-mysql`
   3. `php-mbstring`
2. Install MariaDB 10.5 or above.
3. Install composer.

### Installation
1. `composer install`
2. Copy `.env.example` to `.env` and populate values.
3. `php artisan migrate:fresh` if you've not set up the DB already.

### Run
1. `php -S localhost:8080 -t public/` to serve locally.
