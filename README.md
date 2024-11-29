## Installation
Project is using Laravel Sail to set it up.

1. Clone the repository locally and go to the root of that directory 
2. `cp .env.example .env`
3. Initially, `composer` is required; run `composer install`
4. Turn off locally running MySQL, Redis and Nginx (if applicable) as port interfering will happen when running Sail
5. `./vendor/bin/sail up -d` to start the project (slow initally as images need to be pulled) 
6. `./vendor/bin/sail artisan migrate --seed` to run migrations and seed dummy data
