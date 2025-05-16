# Ghodo School Admin Panel

A comprehensive school administration system built with Laravel 12, featuring role-based authentication, user management, maintenance requests, and material requests management.

## Project Overview

The Ghodo School Admin Panel is an internal, secure web application designed for educational institutions to manage administrative tasks. It includes:

- Role-based authentication (Admin and Staff roles)
- Dashboard with role-specific metrics
- User management (Admin only)
- Maintenance request tracking
- Material request management
- RTL support with Arabic language interface

## Technology Stack

- **Backend**: Laravel 12
- **Frontend Template**: AdminLTE 3+
- **Database**: MySQL 8+
- **Authentication**: Laravel Breeze
- **Asset Compilation**: Vite

## Installation

1. Clone the repository
   ```
   git clone https://github.com/elkholyaa/ghodo-school-admin.git
   cd ghodo-school-admin
   ```

2. Install PHP dependencies
   ```
   composer install
   ```

3. Copy the environment file and configure it
   ```
   cp .env.example .env
   ```
   
4. Configure your database in the `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ghodo_admin_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Generate application key
   ```
   php artisan key:generate
   ```

6. Run migrations
   ```
   php artisan migrate
   ```

7. Install NPM dependencies and compile assets
   ```
   npm install
   npm run dev
   ```

8. Serve the application
   ```
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser to access the application.

## Features

- **Authentication**: Secure login/logout functionality
- **User Management**: CRUD operations for managing admin and staff users
- **Maintenance Requests**: Track and manage maintenance issues
- **Material Requests**: Track and manage material procurement
- **Dashboard**: Overview of system metrics relevant to user role
- **Localization**: Arabic language support with RTL layout

## Development Notes

This project follows Laravel's best practices and conventions:
- Route Model Binding
- Form Request Validation
- Authorization via Policies and Gates
- Eloquent ORM for database interactions
- Blade templating with components
- Vite for asset compilation
