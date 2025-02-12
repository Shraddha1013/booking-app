Project Create:
-----------------
- composer create-project --prefer-dist laravel/laravel booking-app

Generate application key:
----------------------
- php artisan key:generate

Database Migrate:
------------------
- php artisan migrate
- php artisan migrate:fresh


Authentication:
--------------
- composer require laravel/breeze --dev
- php artisan breeze:install
- npm install 

Project Run:
--------------
- npm run dev

Controller:
---------------
- php artisan make:controller Auth/VerificationController
- php artisan make:controller BookingController


Model:
------------------
- php artisan make:model Booking -m

Request:
-----------
- php artisan make:request BookingRequest



Credential:

email: test_user_bookingapp1@yopmail.com
pwd: Sam@123456


