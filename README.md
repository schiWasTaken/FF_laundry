## Dev Setup
standard laravel setup

install modules with `npm install`, `composer install`

modify .env to connect to a database and run `php artisan migrate`

run vite manifest with `npm run dev`

generate encryption key with `php artisan key:generate`

## Login info
when the database is seeded, access admin with
- email: admin@example.com
- password: password

(if you didn't seed admin try running `php artisan db:seed --class=AdminUserSeeder`)



