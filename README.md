# Laravel Offers Manager
Laravel Offers Manager is a web application built on the Laravel framework that allows you to manage offers using CRUD functions.

# Installation
* Clone the repository: git clone https://github.com/KarEem-H/offers_app.git
* Navigate to the project directory: cd laravel-offers
* Install dependencies: composer install
* Copy the .env.example file and rename it to .env: cp .env.example .env
* Generate a new application key: php artisan key:generate
* Edit the .env file to set the database connection parameters
* Run the database migrations: php artisan migrate
Seed the database with sample data (optional): php artisan db:seed
* Start the development server: php artisan serve

## Features
The Laravel Offers Manager application comes with the following features:

1. Create, read, update, and delete offers.
1. Filter offers by category, start date, and end date.
1. Sort offers by start date, end date, and discount percentage.
1. Paginate offers to display a limited number of offers per page.
1. Search for offers by name or description.
Upload images for each offer.
1. Validate input data to ensure consistency and correctness.
1. Use resource controllers and resource views for easy CRUD operations.
1. Use Laravel's built-in authentication system to restrict access to the application.

## Architecture
The project follows the Service Design Patterns, which separates the application into distinct layers:

1. Routes and Controllers: Handle HTTP requests and responses, and pass data to the service layer.
1. Service Layer: Implements the business logic of the application, interacts with the database, and returns data to the controller.
1. Repositories: Provides a clean and consistent API to interact with the database, abstracting the underlying implementation details.
1. Helpers: Reusable functions to perform common tasks, such as image manipulation and string formatting.

### Service Pattern
The application implements the Service Pattern to separate the business logic from the controller. The services are located in the app/Services directory and each service is responsible for a specific domain.

### Helper Files
The application also uses helper files to simplify common operations. The helper files are located in the app/Helpers directory and can be used in any part of the application.

## Installation Steps

- git clone **project_repo_url**
- cd **project_folder**
- run **composer install**
- edit project **.env** to your local database connection config
- run **php artisan key:generate**
- run **php artisan jwt:secret**
- run **php artisan migration:orderOldVoyagerMigrations**

