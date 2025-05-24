Okay, I understand. I will go through the "Development Roadmap" (Section 3) of the SRS document you provided and add the "🧑‍💻 **Developer Check:**" points immediately after each `**Cursor AI Prompt:**` block. These checks will be designed to guide the human user in testing and verifying the AI's output, supporting the educational goal.

Here is the updated SRS document with the "🧑‍💻 **Developer Check:**" additions:

---

```markdown
Act as an experienced Laravel educator and technical writer. Your task is to generate a comprehensive, highly readable, and easily navigable Software Requirements Specification (SRS) document for a tutorial project called "Ghodo School Admin Panel (مدرسة غدو - لوحة التحكم)".

This SRS is specifically designed for a beginner Laravel developer who will leverage an AI coding assistant, specifically Cursor AI, for code generation. The document must be formatted in Markdown, optimized for viewing and navigation within VS Code, particularly with the "Markdown All in One" extension installed, ensuring robust internal linking from the Table of Contents to sections and from sections back to the top/TOC where possible using standard Markdown practices.

The primary goal of this SRS is **educational**: it must guide the beginner through building the application using Laravel 12, AdminLTE 3+, and MySQL 8+, deeply explaining core concepts and Laravel best practices. It should empower them to understand the 'what' and 'why', enabling them to effectively prompt Cursor AI for the 'how' (code).

**This document structure is designed with the following features:**

*   A clear Software Requirements Specification (SRS) format.
*   A detailed Development Roadmap (Section 3) that breaks down the project into manageable phases and individual tasks.
*   **Inline, Sub-numbered, Structured Cursor AI Prompts** placed directly below the specific tasks in the Development Roadmap (Section 3). These prompts are formatted as clear, bulleted lists of instructions designed to be copied and pasted into Cursor AI.
*   Each structured inline Cursor AI prompt concludes with a specific request for the AI to suggest alternative or more standard Laravel practices and explain the reasoning.
*   **Inline "Developer Check" points** placed directly after each Cursor AI prompt in Section 3 to guide the user in verifying the AI-generated code.
*   Instructions for the developer to add a checkmark (✅) at the beginning of each task in the Development Roadmap as they complete it.

**Project Details:**
- Name: Ghodo School Admin Panel (مدرسة غدو - لوحة التحكم)
- Recommended Laravel Project/Repo Name: `ghodo-school-admin`
- Stack: Laravel 12, AdminLTE 3+ (with Vite), MySQL 8+
- UI: Arabic language, RTL layout. Use Laravel Localization (`lang` files).

**Core Functionality:**
- Authentication: Login/Logout (Recommend Laravel Breeze).
- Authorization: Two roles (`admin`, `staff`) with permissions enforced using Laravel Policies and Middleware.
- Dashboard: Role-specific overview widgets.
- User Management: CRUD operations for Admin users, accessible only by Admins (use `IsAdmin` middleware).
- Maintenance Requests: CRUD operations, accessible by both roles but with different permissions. Enforce via `MaintenanceRequestPolicy`.
- Material Requests: CRUD operations, similar role-based permissions enforced via `MaterialRequestPolicy`.

**SRS Content & Structure Requirements:**
1.  **Table of Contents (TOC):** Provide instructions for generating the TOC at the beginning using "Markdown All in One." The main document headings must be structured clearly (`#`, `##`, `###`) for the extension to parse.
2.  **Standard SRS Sections:** Include Introduction, Overall Description, Functional Requirements, Data Model, Use Cases, Workflows, **Detailed Development Roadmap**, and Non-Functional Requirements.
3.  **Deep Educational Focus:** Explain Laravel concepts and best practices with rationale. Use beginner-friendly language. Mention `php artisan` commands. Include "Key Learning Takeaway" boxes.
4.  **Cursor AI Integration Advice:** Include "Tips for Prompting Cursor AI" sections where appropriate, alongside the inline prompts in the roadmap.
5.  **Laravel Best Practices:** Mandate and explain Laravel 12 conventions.
6.  **Data Model Clarity:** Define migrations/tables, Eloquent relationships, `$fillable`.
7.  **Authorization Detail:** Explicitly detail Policies and Middleware usage.
8.  **Hints for Advanced Features:** Suggest potential "next steps" for continued learning.
9.  **Readability & Parsability:** Use enhanced Markdown (bolding, lists, visual separators) for clarity, scannability, and to be easily parsed by AI.
10. **Linking:** Ensure headings use standard Markdown for reliable TOC generation. Add `[Back to Top](#)` links at the end of major H2 sections.
11. **Constraint:** Do **NOT** output any source code *outside* of the example markdown structure and the generated SRS content. The SRS itself should focus on requirements, explanations, and prompts, not the final application code.

Produce a document that is exceptionally well-organized, educational, and directly usable by a beginner Laravel developer in conjunction with Cursor AI, ensuring the Markdown structure facilitates excellent internal navigation within VS Code.
```

---

## Software Requirements Specification (SRS) - Educational Version for AI-Assisted Development

**Project:** Ghodo School Admin Panel (مدرسة غدو - لوحة التحكم) - Beginner Laravel Tutorial Project with Cursor AI
**Version:** 1.9.2 (Developer Checkpoints Added)
**Date:** 2023-11-16
**Target Technologies:** Laravel 12, AdminLTE 3+, MySQL 8+
**Primary UI Language:** Arabic

---

*(**Note for Developer:** To generate the Table of Contents, open this file in VS Code and use the "Markdown All in One" extension via the Command Palette (`Ctrl+Shift+P` or Cmd+Shift+P)). Search for "Markdown All in One: Create Table of Contents". You can update it later if you modify headings using "Markdown All in One: Update Table of Contents". For navigation, also utilize VS Code's built-in Outline view or `Ctrl+Shift+O` / `Cmd+Shift+O` to jump to headings. **Structured Cursor AI Prompts** are included as bulleted lists inline below the specific development tasks they relate to in the Roadmap section. **Developer Check** points follow these prompts to help you verify. Add a checkmark (✅) at the beginning of each task item (like `✅ **Install Laravel 12:**`) as you complete it.)*

---

## 1. Introduction

### 1.1. Purpose & Educational Goals
This document outlines the requirements for the Ghodo School Admin Panel. **Its primary goal is educational:** to provide a structured project for learning fundamental **Laravel 12** concepts. By building this app, you (the beginner developer) will gain hands-on experience with:

*   The **Model-View-Controller (MVC)** architecture.
*   **Routing**, **Eloquent ORM**, **Database Migrations & Seeding**.
*   **Blade Templating**, **Form Handling & Validation** (using **Form Requests**).
*   **Authentication** & **Authorization** (using **Policies** and **Middleware**).
*   **Frontend Integration**
*   Following Laravel conventions for maintainable and efficient code.
*   Effectively using an **AI coding assistant (Cursor AI)** by providing clear, structured requirements.

### 1.2. Scope
This project covers:
*   User Authentication (Login/Logout).
*   Role-based Authorization (Admin, Staff).
*   A Dashboard with role-specific summary widgets.
*   User Management (CRUD operations, Admin-only access).
*   Maintenance Request Management (CRUD operations, with role-based permissions).
*   Material Request Management (CRUD operations, with role-based permissions).
Advanced features like real-time notifications, extensive reporting, or complex file uploads are **out of scope** for this initial learning phase.

### 1.3. Definitions & Acronyms
*   **Admin:** Administrator user role (`admin`).
*   **Staff:** Standard user role (`staff` - `موظف`).
*   **MVC:** Model-View-Controller.
    *   **Model:** Represents data and business logic (e.g., `App\Models\User`). Interacts with the database via Eloquent.
    *   **View:** Presentation layer (e.g., `resources/views/admin/users/index.blade.php`).
    *   **Controller:** Handles HTTP requests, interacts with Models, loads Views (e.g., `App\Http\Controllers\Admin\UserController`).
*   **Eloquent:** Laravel's Object-Relational Mapper.
*   **Blade:** Laravel's templating engine.
*   **Migration:** Version control for database schema (`database/migrations/`).
*   **Seeder:** Populates database with initial/test data (`database/seeders/`).
*   **Policy:** Class organizing authorization logic for a Model (`app/Policies/`).
*   **Middleware:** Filters HTTP requests entering your application (`app/Http/Middleware/`).
*   **Form Request:** Class for validating form data and authorizing requests (`app/Http/Requests/`).
*   **Vite:** Frontend build tool for asset compilation.
*   **Artisan:** Laravel's command-line interface (`php artisan`).
*   **CRUD:** Create, Read, Update, Delete.
*   **RTL:** Right-to-Left (for Arabic UI).
*   **Cursor AI:** Your AI coding assistant.

### 1.4. Target Technologies Stack & Laravel Best Practices
*   **Backend:** Laravel 12.x (PHP 8.2+)
*   **Frontend Template:** AdminLTE 3+ (integrated via Laravel Vite)
*   **Database:** MySQL 8+
*   **UI Language:** Arabic (RTL)
*   **Key Laravel Practices Emphasized:**
    *   **Routing:** Named routes, resourceful routing (`Route::resource`), route grouping.
    *   **Controllers:** Lean controllers, resourceful controllers, dependency injection, Route Model Binding.
    *   **Models:** Eloquent relationships, `$fillable` for mass assignment, attribute casting.
    *   **Views:** Blade layouts (`@extends`), components (`<x-name>`), directives (`@can`).
    *   **Form Requests:** For all `store` and `update` actions.
    *   **Authentication:** Laravel Breeze (recommended starting point).
    *   **Authorization:** Laravel Policies for model-specific permissions, Middleware for route/group protection.
    *   **Database:** Migrations for schema, Seeders for initial data.
    *   **Configuration:** `.env` for environment variables.
    *   **Vite:** For frontend asset management.
    *   **Localization:** For Arabic UI text (`lang/ar/`).
    *   **Eager Loading:** To prevent N+1 query problems.

---
[Back to Top](#)

## 2. Overall Description

### 2.1. Product Perspective
The Ghodo School Admin Panel is an internal, secure web application built on the Laravel 12 MVC framework. It will enable authorized school staff (Admins and Staff members) to manage administrative tasks through a role-specific web interface.

### 2.2. High-Level Functions
The application will provide:
*   Secure user login and logout.
*   A dashboard displaying key metrics relevant to the user's role.
*   Management of user accounts (Admin-only).
*   Tracking and management of maintenance requests.
*   Tracking and management of material requests.

### 2.3. User Characteristics & Roles
*   **Admin (`admin`):** Full system access. Can manage users, all requests, and system settings.
*   **Staff (`staff` - `موظف`):** Limited access. Can submit and manage their own maintenance/material requests (within defined status limitations for editing/deleting) and view information relevant to their tasks. Cannot manage users.
    *All users are expected to be fluent in Arabic and comfortable with standard web interfaces.*

---
[Back to Top](#)

## 3. Development Roadmap (Learning Path)

This roadmap suggests a structured approach to developing the project, focusing on learning core Laravel concepts progressively. Each step builds upon the previous ones. Add a checkmark (✅) next to each task once you complete it.

### 3.1. Phase 0: Project Setup & Environment
0.1.  ✅ **Install Laravel 12:** Use the command `composer create-project laravel/laravel ghodo-school-admin "12.*"`.
0.2.  ✅ **Configure `.env**:** Set up `APP_NAME`, `APP_URL`, and your database connection details (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Ensure you create the database in your MySQL client.
    **Cursor AI Prompt:**
    - Guide me on how to configure the `.env` file for a MySQL database named 'ghodo_admin_db'.
    - Provide the specific lines to modify.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Open your `.env` file.
    - Verify that `APP_NAME` is set to "Ghodo School Admin Panel".
    - Verify that `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` match your local MySQL setup.
    - Try running `php artisan config:cache` and then `php artisan config:clear`. If there's a syntax error in `.env`, these might fail.
0.3.  ✅ **Initial Migration:** Run `php artisan migrate` to create the default Laravel tables.
    **Cursor AI Prompt:**
    - Confirm the Artisan command to run initial database migrations.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Connect to your MySQL database using a client (e.g., phpMyAdmin, TablePlus, DBeaver).
    - Verify that the database `ghodo_admin_db` (or your chosen name) now contains tables like `users`, `password_reset_tokens`, `migrations`, etc.
0.4.  ✅ **Install Laravel Breeze:** Execute `php artisan breeze:install`. When prompted, select the "Blade with Alpine" stack (or your preference, but Blade is assumed for this SRS). Then run `npm install && npm run dev`. Verify that basic login and registration pages work (e.g., `/login`, `/register`).
    **Cursor AI Prompt:**
    - Show me the complete sequence of Artisan and npm commands required to install Laravel Breeze using the Blade stack and prepare the frontend assets.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - After running the commands, visit `/login` and `/register` in your browser.
    - Ensure the pages load correctly and basic Breeze styling is applied.
    - Try registering a new user and logging in/out.
    *   **Learning:** Laravel project installation, environment configuration (`.env`), database setup, initial migrations, and understanding Laravel's starter kits like Breeze for authentication scaffolding.

---

### 3.2. Phase 1: Authentication & Basic Layout
1.1.  **AdminLTE Integration:**
    *   4.1.1.1. ✅ **Download AdminLTE 3+ assets:** Place them in your `resources/` directory (e.g., `resources/backend/adminlte/`). (Manual Step)
    *   4.1.1.2. ✅ **Configure Laravel Vite:** Update `vite.config.js` to compile these AdminLTE assets and your custom `app.css` / `app.js` for the backend.
        **Cursor AI Prompt:**
        - Update the `vite.config.js` file to compile AdminLTE CSS (`adminlte.min.css`) and JS (`adminlte.min.js`) from `resources/backend/adminlte/dist/` along with my custom `resources/css/app_admin.css` and `resources/js/app_admin.js`.
        - Ensure the output directory is `public/build/`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `npm run dev` or `npm run build`.
        - Check your `public/build/assets` directory (or similar, depending on Vite's manifest output). You should see compiled versions of AdminLTE assets and your custom CSS/JS.
        - Ensure there are no compilation errors in the terminal.
    *   4.1.1.3. ✅ **Create main AdminLTE layout:** Create `resources/views/layouts/admin.blade.php`. This layout should include the AdminLTE header, footer, and a basic **RTL sidebar** structure. Use `@yield('content')` for the main page content.
        **Cursor AI Prompt:**
        - Generate the code for a basic Blade layout file at `resources/views/layouts/admin.blade.php`.
        - It should include the fundamental AdminLTE structure (HTML tag with RTL attributes, body, wrapper, header, sidebar, content wrapper with `@yield('content')`, footer).
        - Include `@vite` directives for the assets defined in `vite.config.js`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Create a simple test route that returns a view extending `layouts.admin` with some basic content in the `@section('content')`.
        - Visit this route in your browser. You should see the AdminLTE layout (header, sidebar, footer) with your content.
        - Check the browser's developer console for any errors related to missing CSS/JS.
    *   4.1.1.4. ✅ **Adapt Breeze views:** Modify the authentication views generated by Breeze (e.g., `resources/views/auth/login.blade.php`) to `@extends('layouts.admin')` and place their form content within the AdminLTE structure.
        **Cursor AI Prompt:**
        - Modify the Breeze login view located at `resources/views/auth/login.blade.php` to extend the `layouts.admin` layout.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        (Repeat for other Breeze views like `register.blade.php` as needed).
        🧑‍💻 **Developer Check:**
        - Visit the `/login` and `/register` pages.
        - They should now display within your AdminLTE layout instead of the default Breeze layout.
        - Ensure forms are still functional.
1.2.  **Localization Setup:**
    *   1.2.1. ✅ **Set default locale:** Set the default locale to `ar` in `config/app.php` (`'locale' => 'ar', 'fallback_locale' => 'en',`). (Manual Configuration)
    *   1.2.2. ✅ **Create Arabic translation files:** Create necessary files in `lang/ar/` (e.g., `auth.php`, `validation.php`, `pagination.php`, and a custom `messages.php`).
        **Cursor AI Prompt:**
        - Create the standard Laravel Arabic language files in the `lang/ar/` directory.
        - Include `auth.php`, `validation.php`, `pagination.php`, and an empty `messages.php` file.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Verify the `lang/ar` directory exists and contains the specified files.
        - Open `auth.php` and see if it has some default Arabic translations (Laravel ships with some).
    *   1.2.3. ✅ **Translate user-facing text:** Translate all user-facing text in the Breeze authentication views and your AdminLTE layout using `__('file.key')` or `@lang('file.key')`. (Manual Translation/Replacement)
        **Cursor AI Prompt:**
        - Provide an example of how to use the `__` helper to translate a simple phrase like 'Dashboard' or 'Login' in a Blade view, assuming the translation key exists in `lang/ar/messages.php`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Add a sample translation like `'Login' => 'تسجيل الدخول'` to `lang/ar/messages.php`.
        - Use `__('messages.Login')` in your `login.blade.php` view for the login button or heading.
        - Visit the login page. It should display "تسجيل الدخول".
    *   1.2.4. ✅ **Ensure RTL HTML tag:** Ensure the main HTML tag in `layouts/admin.blade.php` has `lang="ar" dir="rtl"`. (Part of Layout Creation)
    *   **Learning:** Frontend asset management with Vite, creating and using Blade layouts (`@extends`, `@section`, `@yield`), integrating a third-party admin template, implementing Laravel Localization for a non-English UI, and configuring RTL layout.

---

### 3.3. Phase 2: User (Admin) Management - Full CRUD & Authorization
*This is a critical phase for understanding core Laravel patterns.*
2.1.  **Data Model Update:**
    *   2.1.1. ✅ **Modify users migration:** Add `phone` (string, nullable), `civil_id` (string, nullable), and `role` (ENUM('admin', 'staff') with a default of 'staff') to the existing `create_users_table` migration (or a new one).
        **Cursor AI Prompt:**
        - Generate the code needed to add nullable string columns `phone` and `civil_id`, and an ENUM column `role` ('admin', 'staff' with 'staff' as default) to the `users` table migration file.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open the latest `users` table migration file.
        - Verify the new columns (`phone`, `civil_id`, `role`) are defined correctly with their types and constraints.
    *   2.1.2. ✅ **Run migration:** Run `php artisan migrate` (or `php artisan migrate:fresh` if you want to reset the DB). (Command)
        🧑‍💻 **Developer Check:** (After running migration)
        - Check your `users` table schema in your database client.
        - Confirm the new `phone`, `civil_id`, and `role` columns exist.
    *   2.1.3. ✅ **Update User model:** Add `phone`, `civil_id`, `role` to the `$fillable` array. Create an `isAdmin()` helper method: `public function isAdmin(): bool { return $this->role === 'admin'; }`.
        **Cursor AI Prompt:**
        - In the `App\Models\User` model, update the `$fillable` array to include `phone`, `civil_id`, and `role`.
        - Add a public method `isAdmin()` that returns a boolean based on whether the user's `role` is 'admin'.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Models/User.php`.
        - Verify `$fillable` includes the new fields.
        - Verify the `isAdmin()` method is present and correctly checks `this->role === 'admin'`.
2.2.  **Seeding:**
    *   2.2.1. ✅ **Create UserSeeder:** Use `php artisan make:seeder UserSeeder`. (Command)
    *   2.2.2. ✅ **Implement UserSeeder:** In the seeder's `run()` method, create at least one admin user (e.g., `User::create([... 'role' => 'admin', ...])`).
        **Cursor AI Prompt:**
        - In the `UserSeeder` class, write the `run` method to create one user with role 'admin' and password 'password', and one user with role 'staff' and password 'password'.
        - Ensure passwords are hashed using `Hash::make()`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `database/seeders/UserSeeder.php`.
        - Review the `run()` method logic. Ensure it uses `User::create()` or `DB::table('users')->insert()` and hashes passwords.
    *   2.2.3. ✅ **Call Seeder from DatabaseSeeder:** Update `database/seeders/DatabaseSeeder.php` to call `UserSeeder`. (Manual Code Addition)
    *   2.2.4. ✅ **Run seeder:** Run `php artisan db:seed` (or `migrate:fresh --seed`). (Command)
        🧑‍💻 **Developer Check:** (After running seeder)
        - Check the `users` table in your database.
        - Verify that the admin and staff users have been created with the correct roles.
2.3.  **Routing:**
    *   2.3.1. ✅ **Define admin route group:** Define a route group in `routes/web.php` for admin functionalities, including the resourceful route for 'users' and applying the `is_admin` middleware.
        ```php
        Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
            // Dashboard route
            Route::get('/dashboard', function() {
                return view('admin.dashboard');
            })->name('dashboard');

            // User management routes
            Route::resource('users', App\Http\Controllers\Admin\UserController::class)->middleware('is_admin');
            // Other admin resource routes will also go in this group
        });
        ```
        **Cursor AI Prompt:**
        - In `routes/web.php`, define a route group using `Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(...)`.
        - Inside this group, define a resourceful route for 'users' managed by `App\Http\Controllers\Admin\UserController`.
        - Apply the `is_admin` middleware to the 'users' resource route.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `routes/web.php`.
        - Verify the route group and the `Route::resource('users', ...)` are correctly defined with the specified middleware and naming.
        - Run `php artisan route:list` in your terminal and look for routes prefixed with `admin/users` (e.g., `admin.users.index`, `admin.users.create`).
2.4.  **Middleware for Admin Access:**
    *   2.4.1. ✅ **Create IsAdmin middleware:** Use `php artisan make:middleware IsAdmin`. (Command)
    *   2.4.2. ✅ **Implement IsAdmin middleware:** Implement its `handle` method to check if the authenticated user exists and if `auth()->user()->isAdmin()` is true. If the check fails, return an `abort(403)`.
        **Cursor AI Prompt:**
        - In the `IsAdmin` middleware's `handle` method, write the logic to check if the authenticated user exists and if `auth()->user()->isAdmin()` is true.
        - If the check fails, return an `abort(403)` response.
        - Otherwise, call `$next($request)` to allow the request to proceed.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Middleware/IsAdmin.php`.
        - Review the `handle` method. Ensure it correctly checks for an authenticated admin user and aborts with 403 if not.
    *   2.4.3. ✅ **Register IsAdmin middleware:** Register this middleware in `app/Http/Kernel.php` under `$routeMiddleware` (e.g., `'is_admin' => \App\Http\Middleware\IsAdmin::class`).
        **Cursor AI Prompt:**
        - In `app/Http/Kernel.php`, register the `App\Http\Middleware\IsAdmin` middleware with the alias `is_admin` in the `$routeMiddleware` array.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Kernel.php`.
        - Verify that `'is_admin' => \App\Http\Middleware\IsAdmin::class,` is present in the `$routeMiddleware` array.
    *   2.4.4. ✅ **Apply middleware to route:** This was part of the routing step above.
2.5.  **Controller:**
    *   2.5.1. ✅ **Create UserController:** Use `php artisan make:controller Admin/UserController --resource --model=User`. (Command)
        🧑‍💻 **Developer Check:**
        - Verify that `app/Http/Controllers/Admin/UserController.php` has been created.
        - Check that it contains stubs for `index`, `create`, `store`, `show`, `edit`, `update`, and `destroy` methods.
2.6.  **Policy:**
    *   2.6.1. ✅ **Create UserPolicy:** Use `php artisan make:policy UserPolicy --model=User`. (Command)
    *   2.6.2. ✅ **Implement UserPolicy methods:** Implement `viewAny`, `view`, `create`, `update`, and `delete` methods as described in the SRS (Admin can do anything, plus self-delete restriction).
        **Cursor AI Prompt:**
        - In the `UserPolicy` class, implement the `viewAny(User $user)` method to allow if the user is admin.
        - Implement the `view(User $user, User $model)` method to allow if the user is admin.
        - Implement the `create(User $user)` method to allow if the user is admin.
        - Implement the `update(User $user, User $model)` method to allow if the user is admin.
        - Implement the `delete(User $user, User $model)` method to allow if the user is admin AND the user ID is not the model ID being deleted.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Policies/UserPolicy.php`.
        - Review each implemented method to ensure the logic correctly reflects the authorization rules (e.g., only admin, self-delete prevention).
    *   2.6.3. ✅ **Register UserPolicy:** Register `UserPolicy` in `app/Providers/AuthServiceProvider.php`. 
        **Cursor AI Prompt:**
        - In `app/Providers/AuthServiceProvider.php`, add the UserPolicy to the `$policies` array.
        - Add the line: `App\Models\User::class => App\Policies\UserPolicy::class,` to the `$policies` array.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Providers/AuthServiceProvider.php`.
        - Verify that `App\Models\User::class => App\Policies\UserPolicy::class,` is present in the `$policies` array.
2.7.  **Form Requests:**
    *   2.7.1. ✅ **Create StoreUserRequest:** Use `php artisan make:request Admin/StoreUserRequest`. (Command)
    *   2.7.2. ✅ **Implement StoreUserRequest:** Implement its `authorize()` (admin only) and `rules()` methods (including password confirmation and unique email).
        **Cursor AI Prompt:**
        - In `Admin\StoreUserRequest`, write the `authorize()` method to return true only if the logged-in user is admin.
        - Implement the `rules()` method for creating a user with validation for `name` (required string), `email` (required email, unique in users table), `password` (required, min 8, confirmed), `role` (required, in 'admin','staff'), `phone` (nullable string), `civil_id` (nullable string).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/StoreUserRequest.php`.
        - Verify the `authorize()` method checks if the user is admin.
        - Review the `rules()` method to ensure all specified validation rules are present and correct.
    *   2.7.3. ✅ **Create UpdateUserRequest:** Use `php artisan make:request Admin/UpdateUserRequest`. (Command)
    *   2.7.4. ✅ **Implement UpdateUserRequest:** Implement its `authorize()` (admin only) and `rules()` methods (unique email ignoring current user, optional password).
        **Cursor AI Prompt:**
        - In `Admin\UpdateUserRequest`, write the `authorize()` method to return true only if the authenticated user's role is 'admin'.
        - Implement the `rules()` method for updating a user.
        - Rules should be similar to `StoreUserRequest` but the email uniqueness rule should ignore the user being updated using `Rule::unique('users')->ignore($this->user()->id)`.
        - The `password` rule should be `nullable|min:8|confirmed`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/UpdateUserRequest.php`.
        - Verify the `authorize()` method checks if the user is admin.
        - Review the `rules()`: check the email uniqueness rule (ignores current user) and that password fields are nullable.
2.8.  **Views (CRUD in `resources/views/admin/users/`):**
    *   2.8.1. ✅ **Create index.blade.php:** Display users in an AdminLTE table with actions guarded by `@can`.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/users/index.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE table to display a list of `$users` (passed from the controller).
        - Include table columns for Name, Email, and Role.
        - Add a column for Actions with Edit and Delete buttons.
        - Use Blade's `@can` directive with `UserPolicy` to show/hide the Edit button based on whether the logged-in user can `update` the specific user (`$userInstance`).
        - Use Blade's `@can` directive with `UserPolicy` to show/hide the Delete button based on whether the logged-in user can `delete` the specific user (`$userInstance`).
        - Include a link to the user creation page (`route('admin.users.create')`), also guarded by `@can('create', App\Models\User::class)`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `index` method is also implemented)
        - Log in as an admin. Navigate to `/admin/users`.
        - Verify the table displays user data.
        - Check if Edit/Delete buttons and the "Create User" link are visible and correctly guarded by `@can` (e.g., you shouldn't be able to delete yourself if that policy is active).
        - Log in as a staff user (if `is_admin` middleware allows, otherwise this test is for later). They should not see this page or the actions.
    *   2.8.2. ✅ **Create create.blade.php:** AdminLTE form for creating users.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/users/create.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for creating a new user.
        - Include form fields for Name, Email, Phone, Civil ID, Password, Password Confirmation.
        - Include a select dropdown for Role ('admin', 'staff').
        - The form should submit via POST to the user store route (`route('admin.users.store')`) and include `@csrf`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `create` method is also implemented)
        - Log in as admin. Navigate to `/admin/users/create`.
        - Verify the form displays correctly with all fields.
        - Check the form's `action` attribute and ensure `@csrf` is present in the source.
    *   2.8.3. ✅ **Create edit.blade.php:** AdminLTE form for editing users, pre-filled.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/users/edit.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for editing a user, pre-filled with the data from a `$user` variable (passed from the controller).
        - Include fields for Name, Email, Phone, Civil ID, and a select dropdown for Role.
        - Add separate optional fields for changing the password (`password`, `password_confirmation`).
        - The form should submit via POST to the user update route (`route('admin.users.update', $user)`), include `@csrf`, and use `@method('PUT')`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `edit` method is also implemented)
        - Log in as admin. Navigate to an edit page like `/admin/users/1/edit`.
        - Verify the form is pre-filled with the correct user's data.
        - Check the form's `action`, `@csrf`, and `@method('PUT')`.
    *   2.8.4. ✅ **Create show.blade.php:** (Optional) Display single user details.
2.9.  **Controller Method Implementation:**
    *   2.9.1. ✅ **Implement index method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `index()` method.
        - Authorize the `viewAny` ability on the User model using `$this->authorize('viewAny', User::class);`.
        - Fetch all users, paginating them with 10 items per page: `User::latest()->paginate(10)`.
        - Pass the paginated users to the `admin.users.index` view.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Log in as an admin user. Navigate to `/admin/users`.
        - Verify users are listed and paginated.
        - Log in as a staff user. Try to navigate to `/admin/users`. You should be blocked (403 error due to `is_admin` middleware and/or `authorize` in controller).
    *   2.9.2. ✅ **Implement create method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `create()` method.
        - Authorize the `create` ability on the User model: `$this->authorize('create', User::class);`.
        - Define an array of roles: `['admin' => 'Admin', 'staff' => 'Staff']`.
        - Return the `admin.users.create` view, passing the roles array to the view.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Log in as admin. Navigate to `/admin/users/create`.
        - The user creation form should appear.
        - Verify the "Role" dropdown is populated.
    *   2.9.3. ✅ **Implement store method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `store()` method.
        - Type-hint the `Admin\StoreUserRequest $request`. Authorization is handled automatically by the Form Request.
        - Get the validated data from the request: `$validatedData = $request->validated();`.
        - Hash the password in the validated data: `$validatedData['password'] = Hash::make($validatedData['password']);`.
        - Create a new User using the validated data: `User::create($validatedData);`.
        - Redirect to the `admin.users.index` route with a success flash message (e.g., `session()->flash('success', 'User created successfully!');`).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - As admin, go to `/admin/users/create`. Fill out and submit the form.
        - Verify the new user is created in the database with correct data and hashed password.
        - Verify you are redirected to the user index page and see a success message.
        - Test form validation by submitting invalid data (e.g., duplicate email, short password).
    *   2.9.4. ✅ **Implement show method:** (Optional)
    *   2.9.5. ✅ **Implement edit method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `edit(User $user)` method, using Route Model Binding.
        - Authorize the `update` ability for the specific `$user` instance: `$this->authorize('update', $user);`.
        - Define an array of roles: `['admin' => 'Admin', 'staff' => 'Staff']`.
        - Return the `admin.users.edit` view, passing the `$user` model and the roles array to the view.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - As admin, navigate to `/admin/users/{id}/edit` for an existing user.
        - Verify the edit form appears, pre-filled with the user's data.
        - Check if the "Role" dropdown is populated and selects the user's current role.
    *   2.9.6. ✅ **Implement update method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `update(Admin\UpdateUserRequest $request, User $user)` method, type-hinting the Form Request and using Route Model Binding. Authorization is handled by the Form Request.
        - Get the validated data: `$validatedData = $request->validated();`.
        - Check if a new password was provided in the request (`$request->filled('password')`). If so, hash it and update the password in `$validatedData`. Otherwise, remove the password fields from `$validatedData`.
        - Update the `$user` model instance with the validated data: `$user->update($validatedData);`.
        - Redirect to the `admin.users.index` route with a success flash message.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - As admin, go to a user's edit page. Change some data and submit.
        - Verify the user's data is updated in the database.
        - Verify password is changed if provided, and unchanged if not.
        - Verify redirection and success message.
        - Test validation by submitting invalid data.
    *   2.9.7. ✅ **Implement destroy method:**
        **Cursor AI Prompt:**
        - In `Admin\UserController`, implement the `destroy(User $user)` method, using Route Model Binding.
        - Authorize the `delete` ability for the specific `$user` instance: `$this->authorize('delete', $user);`.
        - Delete the `$user` model instance: `$user->delete();`.
        - Redirect to the `admin.users.index` route with a success flash message.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - As admin, on the user index page, try deleting a user (not yourself if self-delete is prevented).
        - Verify the user is removed from the database.
        - Verify redirection and success message.
        - Test the self-delete prevention if implemented in policy (try deleting your own admin account).
2.10. ✅ **Add Sidebar Link:** Add a link to "User Management" (`route('admin.users.index')`) in `layouts/admin.blade.php`, visible only to Admins (`@can('viewAny', App\Models\User::class)`).
    **Cursor AI Prompt:**
    - In the Blade file for your AdminLTE sidebar (`resources/views/layouts/admin.blade.php` or a partial it includes), add a navigation link for 'User Management'.
    - Point this link to `route('admin.users.index')`.
    - Make this link visible only if the authenticated user `can('viewAny', App\Models\User::class)` using Blade's `@can` directive.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Log in as admin: The "User Management" link should be visible in the sidebar and work.
    - Log in as staff: The "User Management" link should NOT be visible.
    *   **Key Learning Takeaway:** This phase covers the complete CRUD lifecycle, effective use of Resourceful Controllers, Route Model Binding, Form Requests for robust validation and request-specific authorization, Policies for model-level authorization, Middleware for route group protection, database seeding for initial admin setup, and conditional UI rendering with Blade's `@can` directive.
2.11. **Create User Tests:** Implement unit and feature tests for the User model and management.
    *   2.11.1. ☐ **Create UserModelTest:** Test model attributes and helper methods.
        **Cursor AI Prompt:**
        - Create a `UserModelTest.php` file in the `tests/Unit/` directory.
        - Test that the `User` model correctly defines its `$fillable` attributes (name, email, password, phone, civil_id, role).
        - Test the `isAdmin()` helper method returns true when role is 'admin' and false otherwise.
        - Use the `RefreshDatabase` trait to ensure a clean database state.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Unit/UserModelTest.php`.
        - Ensure all tests pass.
        - Review the generated test file to understand how model attributes and methods are tested.
    *   2.11.2. ☐ **Create UserManagementTest:** Test CRUD operations and permissions.
        **Cursor AI Prompt:**
        - Create a `UserManagementTest.php` file in the `tests/Feature/` directory.
        - Test that admin users can access the users index page, while staff users cannot (should get 403 response).
        - Test that admin users can create, update, and delete users.
        - Test the self-delete prevention policy - an admin cannot delete themselves.
        - Use the `RefreshDatabase` trait and set up test users in the setUp method.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Feature/UserManagementTest.php`.
        - Ensure all tests pass, covering different scenarios (admin access, staff restriction, CRUD actions, policy enforcement).
    *   **Key Learning Takeaway:** This phase covers the complete CRUD lifecycle, effective use of Resourceful Controllers, Route Model Binding, Form Requests for robust validation and request-specific authorization, Policies for model-level authorization, Middleware for route group protection, database seeding for initial admin setup, and conditional UI rendering with Blade's `@can` directive.

---
[Back to Top](#)

### 3.4. Phase 3: Dashboard Implementation
3.1.  ✅ **Implement Dashboard Route:** Added a route for the dashboard in the admin route group.
3.2.  ☐ **Add Routing:** Add the dashboard route within the authenticated admin group in `routes/web.php`.
    ```php
    // Inside the Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(...)
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    ```
    **Cursor AI Prompt:**
    - In `routes/web.php`, within the `Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(...)` block, define a GET route for `/dashboard`.
    - Map this route to the `index` method of `App\Http\Controllers\Admin\DashboardController`.
    - Name this route `admin.dashboard`.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Run `php artisan route:list | grep admin.dashboard`. Verify the route is listed correctly.
3.3.  ☐ **Create DashboardController:** Create the controller that will handle the dashboard logic.
    **Cursor AI Prompt:**
    - Use `php artisan make:controller Admin/DashboardController` to create the controller.
    - In the generated `DashboardController`, implement the `index()` method that returns `view('admin.dashboard')`.
    - Add comprehensive docblock comments explaining the controller's purpose and the index method's functionality.
    - The controller should be prepared to implement role-based data fetching logic in the next task.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Verify that `app/Http/Controllers/Admin/DashboardController.php` has been created.
    - Check that it contains an `index()` method that returns the dashboard view.
    - Navigate to `/admin/dashboard` and verify it loads without errors (assuming the view exists).
3.4.  ✅ **Create View:** Create `resources/views/admin/dashboard.blade.php`. It should `@extends('layouts.admin')`. (Manual Creation/Extension)
3.5.  **Logic:**
    *   3.5.1. ☐ **Implement Logic:** In `DashboardController@index` method, fetch counts based on user role and pass them to the view.
        **Cursor AI Prompt:**
        - In the `Admin\DashboardController@index` method, check if the authenticated user (`auth()->user()`) is admin using the `isAdmin()` helper method.
        - If the user is admin, fetch counts for: total users (`App\Models\User::count()`), total pending maintenance requests (status 'new' or 'in_progress' from `App\Models\MaintenanceRequest`), and total pending material requests (status 'pending' from `App\Models\MaterialRequest`). (Ensure these models exist or stub them).
        - If the user is staff (`!auth()->user()->isAdmin()`), fetch counts for: their own pending maintenance requests (created by `auth()->id()`, status 'new' or 'in_progress'), and their own pending material requests (created by `auth()->id()`, status 'pending'). Use Eloquent queries with `where('requester_id', auth()->id())` and appropriate status conditions.
        - Pass these fetched counts to the `admin.dashboard` view using an associative array (e.g., `compact('usersCount', 'pendingMaintenanceCount', ...)`).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Log in as an admin. Navigate to `/admin/dashboard`. Use `dd()` or Laravel Debugbar to inspect the variables passed to the view. Verify counts are logical (e.g., 0 if no requests yet).
        - Log in as a staff user. Navigate to `/admin/dashboard`. Verify counts are relevant to that staff member.
    *   **Learning:** Basic controller logic, conditional data fetching based on user role using Eloquent, passing data to views, and displaying data in Blade.
3.6.  ☐ **Display Widgets:** Display the counts in the view using AdminLTE `info-box` or `small-box` widgets.
    **Cursor AI Prompt:**
    - In `resources/views/admin/dashboard.blade.php`, add Blade code to display the counts passed from the controller (using the variable names you used when passing them).
    - Use AdminLTE `info-box` or `small-box` components for visual presentation of each count. Conditionally display admin-specific vs. staff-specific widgets using `@if(auth()->user()->isAdmin()) ... @else ... @endif`.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Log in as admin. View `/admin/dashboard`. Verify admin-specific widgets appear with correct counts.
    - Log in as staff. View `/admin/dashboard`. Verify staff-specific widgets appear with correct counts.
    - Check for any Blade errors if variables are not found.
3.7.  **Create Dashboard Tests:** Implement tests to verify dashboard displays correct data.
    *   ☐ **Create DashboardTest:** Test dashboard content for different user roles.
        **Cursor AI Prompt:**
        - Create a `DashboardTest.php` file in the `tests/Feature/` directory.
        - Test that both admin and staff users can access the dashboard.
        - Test that the dashboard displays role-appropriate data (admin sees all user counts, staff sees only their own request counts).
        - Create test data for users, maintenance requests, and material requests to verify correct counts are displayed.
        - Use the `RefreshDatabase` trait and set up test data in the setUp method.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Feature/DashboardTest.php`.
        - Ensure all tests pass, verifying that different roles see appropriate data on the dashboard.

---
[Back to Top](#)

### 3.5. Phase 4: Maintenance Request Management - CRUD & Role-Based Policies
1.  **Data Model:**
    *   4.1.1. ☐ **Create migration:** Use `php artisan make:migration create_maintenance_requests_table --create=maintenance_requests`. (Command)
    *   1.2. ☐ **Define schema:** Define schema as per [Section 5.3](#53-maintenance_requests-table) in the migration file.
        **Cursor AI Prompt:**
        - In the `create_maintenance_requests_table` migration file, define the table schema: an auto-incrementing primary `id`.
        - Add a foreign key `requester_id` (unsigned big integer) referencing the `users` table, with `on delete cascade`.
        - Add a nullable string column for `floor`.
        - Add a required string column for `location`.
        - Add a required string column for `title`.
        - Add a nullable text column for `description`.
        - Add an ENUM column for `priority` with values 'normal' and 'urgent', defaulting to 'normal'.
        - Add an ENUM column for `status` with values 'new', 'in_progress', 'completed', 'transferred', defaulting to 'new'.
        - Include timestamps (`created_at`, `updated_at`).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open the newly created migration file for `maintenance_requests`.
        - Verify all columns, types, constraints (foreign keys, defaults, enum values) are correctly defined.
    *   1.3. ☐ **Run migration:** Run `php artisan migrate`. (Command)
        🧑‍💻 **Developer Check:** (After running migration)
        - Check your database schema. The `maintenance_requests` table should exist with the defined columns.
    *   1.4. ☐ **Create Model:** Use `php artisan make:model MaintenanceRequest`. (Command)
    *   1.5. ☐ **Define Model properties/relationships:** Define `$fillable` and relationships (`requester`, `materialRequests`) as per [Section 5.5](#55-eloquent-model-relationships) in the model file.
        **Cursor AI Prompt:**
        - In the `App\Models\MaintenanceRequest` model, define the `$fillable` array to include `requester_id`, `floor`, `location`, `title`, `description`, `priority`, and `status`.
        - Define a `belongsTo` relationship named `requester` linking to the `App\Models\User` model.
        - Define a `hasMany` relationship named `materialRequests` linking to the `App\Models\MaterialRequest` model (you might need to create a stub `MaterialRequest` model for now if it doesn't exist).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Models/MaintenanceRequest.php`.
        - Verify `$fillable` is correct.
        - Verify the `requester()` and `materialRequests()` (if applicable yet) relationship methods are defined.
2.  **Routing:**
    *   2.1. ☐ **Add resourceful route:** Add the `maintenance-requests` resourceful route to the authenticated admin route group in `routes/web.php`.
        **Cursor AI Prompt:**
        - In `routes/web.php`, within the `Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(...)` block, add a resourceful route for `maintenance-requests`.
        - Specify that this route is managed by `App\Http\Controllers\Admin\MaintenanceRequestController`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan route:list | grep maintenance-requests`. Verify all 7 resourceful routes are listed under the `admin.` prefix.
3.  **Policy:**
    *   3.1. ☐ **Create Policy:** Use `php artisan make:policy MaintenanceRequestPolicy --model=MaintenanceRequest`. (Command)
    *   3.2. ☐ **Implement Policy methods:** Implement `viewAny`, `view`, `create`, `update`, and `delete` methods as detailed in [Functional Requirements - FR-MR](#46-fr-mr-maintenance-request-management) (admin full control; staff conditional).
        **Cursor AI Prompt:**
        - In the `MaintenanceRequestPolicy` class, implement the `viewAny(User $user)` method to allow if the user is admin or staff (`return $user->isAdmin() || $user->role === 'staff';`). Assume `isAdmin()` exists.
        - Implement the `view(User $user, MaintenanceRequest $maintenanceRequest)` method to allow if the user is admin OR if the user is staff AND they are the `requester_id` of the request.
        - Implement the `create(User $user)` method to allow if the user is admin or staff.
        - Implement the `update(User $user, MaintenanceRequest $maintenanceRequest)` method to allow if the user is admin OR if the user is staff AND they are the `requester_id` AND the request's `status` is 'new'.
        - Implement the `delete(User $user, MaintenanceRequest $maintenanceRequest)` method to allow if the user is admin. Staff cannot delete.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Policies/MaintenanceRequestPolicy.php`.
        - Carefully review each policy method to ensure it correctly implements the specified business rules for admin and staff users.
    *   3.3. ☐ **Register Policy:** Register in `app/Providers/AuthServiceProvider.php`. 
        **Cursor AI Prompt:**
        - In `app/Providers/AuthServiceProvider.php`, add the MaintenanceRequestPolicy to the `$policies` array.
        - Add the line: `App\Models\MaintenanceRequest::class => App\Policies\MaintenanceRequestPolicy::class,` to the `$policies` array.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Providers/AuthServiceProvider.php`.
        - Verify `App\Models\MaintenanceRequest::class => App\Policies\MaintenanceRequestPolicy::class,` is in `$policies`.
4.  **Controller & Form Requests:**
    *   4.1. ☐ **Create Controller:** Use `php artisan make:controller Admin/MaintenanceRequestController --resource --model=MaintenanceRequest`. (Command)
    *   4.2. ☐ **Create Store Request:** Use `php artisan make:request Admin/StoreMaintenanceRequestRequest`. (Command)
    *   4.3. ☐ **Implement Store Request:** Implement `authorize()` (authenticated) and `rules()` methods.
        **Cursor AI Prompt:**
        - In `Admin\StoreMaintenanceRequestRequest`, implement the `authorize()` method to return true if the user is authenticated (`auth()->check()`).
        - Implement the `rules()` method with validation rules for: `location` (required string, max 255), `title` (required string, max 255), `floor` (nullable string, max 255), `description` (nullable text), `priority` (required, in:normal,urgent), `status` (required, in:new,in_progress,completed,transferred).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/StoreMaintenanceRequestRequest.php`.
        - Verify `authorize()` returns `auth()->check()`.
        - Verify all validation rules in `rules()` are correct.
    *   4.4. ☐ **Create Update Request:** Use `php artisan make:request Admin/UpdateMaintenanceRequestRequest`. (Command)
    *   4.5. ☐ **Implement Update Request:** Implement `authorize()` (using policy) and `rules()` methods.
        **Cursor AI Prompt:**
        - In `Admin\UpdateMaintenanceRequestRequest`, implement the `authorize()` method to return the result of calling the `update` ability on the authenticated user for the maintenance request instance being updated. Access the request instance using `$this->route('maintenance_request')`.
        - Implement the `rules()` method with validation rules identical to `StoreMaintenanceRequestRequest`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/UpdateMaintenanceRequestRequest.php`.
        - Verify `authorize()` correctly uses the policy: `return $this->user()->can('update', $this->route('maintenance_request'));`.
        - Verify `rules()` are identical or appropriate for updates.
5.  **Views & Logic:**
    *   5.1. ☐ **Create index view:** Create `resources/views/admin/maintenance_requests/index.blade.php` to display requests with actions guarded by `@can`.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/maintenance_requests/index.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE card or box containing a table.
        - Display a list of `$maintenanceRequests` (passed from the controller), paginated.
        - Include table columns for Title, Location, Status, Priority, Created At, and Requester Name (accessing the `$request->requester->name` relationship).
        - Add an Actions column with Edit and Delete buttons.
        - Use Blade's `@can` directive with `$maintenanceRequestInstance` to show/hide the Edit button based on the `update` policy.
        - Use Blade's `@can` directive with `$maintenanceRequestInstance` to show/hide the Delete button based on the `delete` policy.
        - Include a link to the create page (`route('admin.maintenance-requests.create')`), also guarded by `@can('create', App\Models\MaintenanceRequest::class)`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `index` method is implemented)
        - Log in as admin. Navigate to `/admin/maintenance-requests`. Verify table, data, and actions (Edit/Delete/Create links) appear correctly based on policy.
        - Log in as staff. Navigate to `/admin/maintenance-requests`. Verify they can see requests (if policy allows `viewAny`). Check if Edit/Delete buttons are visible/hidden based on policy (e.g., can't delete, can only edit own 'new' requests).
    *   5.2. ☐ **Create create view:** Create `resources/views/admin/maintenance_requests/create.blade.php` for the form.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/maintenance_requests/create.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for creating a new maintenance request.
        - Include form fields for Floor, Location, Title, Description (textarea).
        - Include select dropdowns for Priority ('normal', 'urgent') and Status ('new', 'in_progress', 'completed', 'transferred'). Make 'new' the default selected option for Status.
        - The form should submit via POST to the maintenance request store route (`route('admin.maintenance-requests.store')`) and include `@csrf`. The `requester_id` will be set automatically in the controller.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `create` method is implemented)
        - Log in as admin or staff. Navigate to `/admin/maintenance-requests/create`.
        - Verify the form appears with all fields and correct default values.
    *   5.3. ☐ **Create edit view:** Create `resources/views/admin/maintenance_requests/edit.blade.php` for the pre-filled form with conditional status field based on policy.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/maintenance_requests/edit.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for editing a maintenance request, pre-filled with `$maintenanceRequest` data (passed from the controller).
        - Include form fields for Floor, Location, Title, Description (textarea), and select dropdowns for Priority and Status.
        - Pre-select the current `$maintenanceRequest->priority` and `$maintenanceRequest->status` in the dropdowns.
        - Use Blade's `@can('update', $maintenanceRequest)` or a more specific policy method like `changeStatus` if defined. For instance, if only admins can change status from 'new', or staff can only edit fields when status is 'new', reflect this by disabling fields or the entire form.
        - The form should submit via POST to the maintenance request update route (`route('admin.maintenance-requests.update', $maintenanceRequest)`) and include `@csrf`, and use `@method('PUT')`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `edit` method is implemented)
        - Log in as admin. Navigate to `/admin/maintenance-requests/{id}/edit`. Verify form is pre-filled and editable.
        - Log in as staff. Navigate to edit one of their 'new' requests. Verify form is pre-filled and editable (respecting policy).
        - As staff, navigate to edit one of their 'in_progress' requests. Verify fields are disabled or form is not submittable based on policy.
    *   5.4. ☐ **Create show view:** (Optional) Display full request details.
    *   5.5. ☐ **Implement Controller methods:** Implement `index`, `create`, `store`, `edit`, `update`, and `destroy` methods using Form Requests, `$this->authorize()`, Eloquent, eager loading, and redirects with flash messages. Ensure 'store' sets `requester_id`.
        **Cursor AI Prompt:**
        - In `Admin\MaintenanceRequestController`, implement the `index()` method. Authorize `viewAny`. Fetch maintenance requests, eager load the `requester` relationship, and paginate results (`paginate(15)`). Pass results to the `index` view.
        - Implement the `create()` method. Authorize `create`. Return the `create` view.
        - Implement the `store()` method. Type-hint `StoreMaintenanceRequestRequest`. Authorization is handled by the Form Request. Create the maintenance request using validated data, manually setting `requester_id` to `auth()->id()`. Redirect to the index route with a success flash message.
        - Implement the `show(MaintenanceRequest $maintenanceRequest)` method. Authorize `view` for the `$maintenanceRequest` instance. Eager load the `requester` relationship on `$maintenanceRequest`. Return the `show` view (if created), passing the `$maintenanceRequest`.
        - Implement the `edit(MaintenanceRequest $maintenanceRequest)` method. Authorize `update` for the `$maintenanceRequest` instance. Pass the `$maintenanceRequest` to the `edit` view.
        - Implement the `update(UpdateMaintenanceRequestRequest $request, MaintenanceRequest $maintenanceRequest)` method. Authorization is handled by the Form Request. Update the `$maintenanceRequest` instance with validated data. Redirect to the index route with a success flash message.
        - Implement the `destroy(MaintenanceRequest $maintenanceRequest)` method. Authorize `delete` for the `$maintenanceRequest` instance. Delete the request. Redirect to the index route with a success flash message.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - **Index:** Test as admin and staff (see checks for view 5.1).
        - **Create/Store:** Log in as staff/admin. Create a request. Verify it's in DB with correct `requester_id`, status, etc. Check redirection and flash message. Test validation.
        - **Edit/Update:** Log in as admin. Edit any request. Verify changes. Log in as staff. Edit *their own 'new'* request. Verify changes. Try to edit another's request or their own 'in_progress' request – should be blocked by policy/FormRequest `authorize`. Test validation.
        - **Destroy:** Log in as admin. Delete a request. Verify. Log in as staff. Try to delete – should be blocked.
        - **Show (if implemented):** Test access as per policy (admin can see all, staff can see own).
6.  ☐ **Add Sidebar Link:** Add link to `route('admin.maintenance-requests.index')` in the AdminLTE sidebar, visible to both roles.
    **Cursor AI Prompt:**
    - In the AdminLTE sidebar Blade file, add a navigation link for 'Maintenance Requests'.
    - Point this link to `route('admin.maintenance-requests.index')`.
    - This link should be visible to both 'admin' and 'staff' roles (logic within the page handles specific permissions, so no `@can` needed on the link itself based on current policy design for `viewAny`).
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Log in as admin. The "Maintenance Requests" link should be visible and work.
    - Log in as staff. The "Maintenance Requests" link should also be visible and work (page content will be filtered by policy).
    *   **Key Learning Takeaway:** Implementing Policies with more nuanced, condition-based authorization (role + ownership + data status), handling foreign key relationships correctly, reinforcing the full CRUD + Form Request + Policy pattern.
7.  **Create Maintenance Request Tests:** Implement unit and feature tests.
    *   7.1. ☐ **Create MaintenanceRequestModelTest:** Test model relationships and attributes.
        **Cursor AI Prompt:**
        - Create a `MaintenanceRequestModelTest.php` file in the `tests/Unit/` directory.
        - Test that the `MaintenanceRequest` model correctly defines its relationships: `requester()` (belongsTo User) and `materialRequests()` (hasMany MaterialRequest).
        - Test that all required attributes (requester_id, floor, location, title, description, priority, status) are fillable.
        - Use the `RefreshDatabase` trait and create test models to verify relationship loading.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Unit/MaintenanceRequestModelTest.php`.
        - Ensure all tests pass, verifying model setup.
    *   7.2. ☐ **Create MaintenanceRequestTest:** Test CRUD operations and permissions.
        **Cursor AI Prompt:**
        - Create a `MaintenanceRequestTest.php` file in the `tests/Feature/` directory.
        - Test CRUD operations: both admin and staff can create requests, view request lists (with proper filtering), and update requests.
        - Test permission rules: staff can only edit their own 'new' requests, only admin can delete requests.
        - Test that the maintenance request's requester_id is set to the authenticated user when created.
        - Use the `RefreshDatabase` trait and set up test users and requests in the setUp method.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Feature/MaintenanceRequestTest.php`.
        - Ensure all feature tests pass, covering the defined CRUD operations and permission rules.
    *   **Key Learning Takeaway:** Implementing Policies with more nuanced, condition-based authorization (role + ownership + data status), handling foreign key relationships correctly, reinforcing the full CRUD + Form Request + Policy pattern.

---
[Back to Top](#)

### 3.6. Phase 5: Material Request Management - CRUD & Role-Based Policies
1.  **Data Model:**
    *   4.1.1. ☐ **Create migration:** Use `php artisan make:migration create_material_requests_table --create=material_requests`. (Command)
    *   1.2. ☐ **Define schema:** Define schema as per [Section 5.4](#54-material_requests-table) in the migration file (includes nullable `maintenance_request_id` FK).
        **Cursor AI Prompt:**
        - In the `create_material_requests_table` migration file, define the table schema: an auto-incrementing primary `id`.
        - Add a foreign key `requester_id` (unsigned big integer) referencing the `users` table, with `on delete cascade`.
        - Add a nullable foreign key `maintenance_request_id` (unsigned big integer) referencing the `maintenance_requests` table, with `on delete set null`.
        - Add a required string column for `item_description` (max 255).
        - Add a required unsigned integer column for `quantity`.
        - Add a nullable decimal column for `cost` with precision 8, 2.
        - Add a nullable ENUM column for `funding_source` with values 'school_budget', 'maintenance', 'other'.
        - Add an ENUM column for `status` with values 'pending', 'approved', 'rejected', 'fulfilled', defaulting to 'pending'.
        - Include timestamps (`created_at`, `updated_at`).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open the `material_requests` migration file.
        - Verify all columns, types, FKs (especially `on delete set null`), and constraints.
    *   1.3. ☐ **Run migration:** Run `php artisan migrate`. (Command)
        🧑‍💻 **Developer Check:** (After migration)
        - Confirm `material_requests` table exists in DB with correct schema.
    *   1.4. ☐ **Create Model:** Use `php artisan make:model MaterialRequest`. (Command)
    *   1.5. ☐ **Define Model properties/relationships:** Define `$fillable` and relationships (`requester`, `maintenanceRequest`) as per [Section 5.5](#55-eloquent-model-relationships) in the model file.
        **Cursor AI Prompt:**
        - In the `App\Models\MaterialRequest` model, define the `$fillable` array to include `requester_id`, `maintenance_request_id`, `item_description`, `quantity`, `cost`, `funding_source`, and `status`.
        - Define a `belongsTo` relationship named `requester` linking to the `App\Models\User` model.
        - Define a nullable `belongsTo` relationship named `maintenanceRequest` linking to the `App\Models\MaintenanceRequest` model.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Models/MaterialRequest.php`.
        - Verify `$fillable` and relationship methods (`requester`, `maintenanceRequest`).
2.  **Routing:**
    *   2.1. ☐ **Add resourceful route:** Add the `material-requests` resourceful route to the authenticated admin route group in `routes/web.php`.
        **Cursor AI Prompt:**
        - In `routes/web.php`, within the `Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(...)` block, add a resourceful route for `material-requests`.
        - Specify that this route is managed by `App\Http\Controllers\Admin\MaterialRequestController`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan route:list | grep material-requests`. Ensure routes are correctly registered.
3.  **Policy:**
    *   3.1. ☐ **Create Policy:** Use `php artisan make:policy MaterialRequestPolicy --model=MaterialRequest`. (Command)
    *   3.2. ☐ **Implement Policy methods:** Implement `viewAny`, `view`, `create`, `update`, and `delete` methods (admin full control; staff conditional based on ownership/status).
        **Cursor AI Prompt:**
        - In the `MaterialRequestPolicy` class, implement the `viewAny(User $user)` method to allow if the user is admin or staff (`return $user->isAdmin() || $user->role === 'staff';`).
        - Implement the `view(User $user, MaterialRequest $materialRequest)` method to allow if the user is admin OR if the user is staff AND they are the `requester_id` of the request.
        - Implement the `create(User $user)` method to allow if the user is admin or staff.
        - Implement the `update(User $user, MaterialRequest $materialRequest)` method to allow if the user is admin OR if the user is staff AND they are the `requester_id` AND the request's `status` is 'pending'.
        - Implement the `delete(User $user, MaterialRequest $materialRequest)` method to allow if the user is admin. Staff cannot delete.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Policies/MaterialRequestPolicy.php`.
        - Review each method ensuring rules for admin/staff (ownership, status) are correct.
    *   3.3. ☐ **Register Policy:** Register in `app/Providers/AuthServiceProvider.php`. (Part of Auth/Auth AI Tip)
        🧑‍💻 **Developer Check:**
        - Verify `App\Models\MaterialRequest::class => App\Policies\MaterialRequestPolicy::class,` is in `AuthServiceProvider`.
4.  **Controller & Form Requests:**
    *   4.1. ☐ **Create Controller:** Use `php artisan make:controller Admin/MaterialRequestController --resource --model=MaterialRequest`. (Command)
    *   4.2. ☐ **Create Store Request:** Use `php artisan make:request Admin/StoreMaterialRequestRequest`. (Command)
    *   4.3. ☐ **Implement Store Request:** Implement `authorize()` (authenticated) and `rules()` (including nullable FK validation).
        **Cursor AI Prompt:**
        - In `Admin\StoreMaterialRequestRequest`, implement the `authorize()` method to return true if the user is authenticated (`auth()->check()`).
        - Implement the `rules()` method with validation rules for: `item_description` (required string, max 255), `quantity` (required integer, min:1), `cost` (nullable numeric, min:0), `funding_source` (nullable, in:school_budget,maintenance,other), `status` (required, in:pending,approved,rejected,fulfilled).
        - For `maintenance_request_id`, add a nullable rule that checks if the ID exists in the `maintenance_requests` table if it is provided using `Rule::exists('maintenance_requests', 'id')`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/StoreMaterialRequestRequest.php`.
        - Verify `authorize()` and all `rules()`, especially the conditional `maintenance_request_id` existence.
    *   4.4. ☐ **Create Update Request:** Use `php artisan make:request Admin/UpdateMaterialRequestRequest`. (Command)
    *   4.5. ☐ **Implement Update Request:** Implement `authorize()` (using policy) and `rules()` methods.
        **Cursor AI Prompt:**
        - In `Admin\UpdateMaterialRequestRequest`, implement the `authorize()` method to return the result of calling the `update` ability on the authenticated user for the material request instance being updated. Access the request instance using `$this->route('material_request')`.
        - Implement the `rules()` method with validation rules identical to `StoreMaterialRequestRequest`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open `app/Http/Requests/Admin/UpdateMaterialRequestRequest.php`.
        - Verify `authorize()` uses policy, and `rules()` are correct.
5.  **Views & Logic:** Implement CRUD views in `resources/views/admin/material_requests/`.
    *   5.1. ☐ **Create index view:** Create `resources/views/admin/material_requests/index.blade.php` to display requests with actions guarded by `@can`, eager loading relationships.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/material_requests/index.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE card or box containing a table.
        - Display a list of `$materialRequests` (passed from the controller), paginated.
        - Include table columns for Item, Quantity, Cost, Status, Created At, Requester Name, and Maintenance Request Link (show ID or link if `maintenanceRequest` relationship exists).
        - Add an Actions column with Edit and Delete buttons.
        - Use Blade's `@can` directive with `$materialRequestInstance` to show/hide the Edit button based on the `update` policy.
        - Use Blade's `@can` directive with `$materialRequestInstance` to show/hide the Delete button based on the `delete` policy.
        - Include a link to the create page (`route('admin.material-requests.create')`), also guarded by `@can('create', App\Models\MaterialRequest::class)`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `index` method is implemented)
        - Log in as admin/staff. Navigate to `/admin/material-requests`.
        - Verify table displays data, including linked Maintenance Request info.
        - Check visibility of Edit/Delete/Create actions based on policy.
    *   5.2. ☐ **Create create view:** Create `resources/views/admin/material_requests/create.blade.php` with the form, including the optional maintenance request dropdown populated with open requests.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/material_requests/create.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for creating a new material request.
        - Include form fields for Item Description, Quantity, Cost, Funding Source (dropdown with options 'school_budget', 'maintenance', 'other'), and Status (dropdown with options 'pending', 'approved', 'rejected', 'fulfilled'). Make 'pending' the default for Status.
        - Include an optional select dropdown for 'Maintenance Request ID'. Populate this dropdown with a list of *open* maintenance requests (their ID and Title) passed from the controller (e.g., in a `$openMaintenanceRequests` variable). Make the 'None' option available (value `null`).
        - The form should submit via POST to the material request store route (`route('admin.material-requests.store')`) and include `@csrf`. The `requester_id` will be set automatically in the controller.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `create` method is implemented)
        - Navigate to `/admin/material-requests/create`.
        - Verify form fields and that the "Maintenance Request ID" dropdown is populated with open requests (if any exist).
    *   5.3. ☐ **Create edit view:** Create `resources/views/admin/material_requests/edit.blade.php` with the pre-filled form, respecting policy restrictions on fields.
        **Cursor AI Prompt:**
        - Generate the Blade code for `resources/views/admin/material_requests/edit.blade.php`.
        - Extend `layouts.admin`.
        - Create an AdminLTE form for editing a material request, pre-filled with `$materialRequest` data (passed from the controller).
        - Include form fields for Item Description, Quantity, Cost, Funding Source (dropdown), and Status (dropdown).
        - Pre-select the current values in the dropdowns.
        - Include the optional select dropdown for 'Maintenance Request ID', populated with *open* maintenance requests and pre-select the current `$materialRequest->maintenance_request_id`.
        - Use Blade's `@can` directive (referencing `MaterialRequestPolicy`) to disable or hide fields like Status, Cost, or Funding Source if the user is staff and the policy restricts changes based on status ('pending').
        - The form should submit via POST to the material request update route (`route('admin.material-requests.update', $materialRequest)`) and include `@csrf`, and use `@method('PUT')`.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:** (After controller `edit` method is implemented)
        - As admin, edit a material request. Verify pre-fill and dropdowns.
        - As staff, edit *their own 'pending'* material request. Verify pre-fill, dropdowns, and editable fields.
        - As staff, try to edit their *own 'approved'* request. Verify fields are disabled/form non-submittable based on policy.
    *   5.4. ☐ **Create show view:** (Optional) Display full request details.
    *   5.5. ☐ **Implement Controller methods:** Implement `index`, `create`, `store`, `edit`, `update`, and `destroy` methods using Form Requests, `$this->authorize()`, Eloquent, eager loading, and redirects with flash messages. Ensure 'store' sets `requester_id`, and 'create'/'edit' fetch open maintenance requests for the dropdown.
        **Cursor AI Prompt:**
        - In `Admin\MaterialRequestController`, implement the `index()` method. Authorize `viewAny`. Fetch material requests, eager load `requester` and `maintenanceRequest` relationships, and paginate results (`paginate(15)`). Pass results to the `index` view.
        - Implement the `create()` method. Authorize `create`. Fetch *open* maintenance requests (status 'new' or 'in_progress') to populate the dropdown in the form. Pass these open requests to the `create` view under a variable name like `$openMaintenanceRequests`.
        - Implement the `store()` method. Type-hint `StoreMaterialRequestRequest`. Authorization is handled by the Form Request. Create the material request using validated data, manually setting `requester_id` to `auth()->id()`. Redirect to the index route with a success flash message.
        - Implement the `show(MaterialRequest $materialRequest)` method. Authorize `view` for the `$materialRequest` instance. Eager load `requester` and `maintenanceRequest` relationships on `$materialRequest`. Return the `show` view (if created), passing the `$materialRequest`.
        - Implement the `edit(MaterialRequest $materialRequest)` method. Authorize `update` for the `$materialRequest` instance. Fetch *open* maintenance requests to populate the dropdown in the form. Pass the `$materialRequest` and the list of `$openMaintenanceRequests` to the `edit` view.
        - Implement the `update(UpdateMaterialRequestRequest $request, MaterialRequest $materialRequest)` method. Authorization is handled by the Form Request. Update the `$materialRequest` instance with validated data. Redirect to the index route with a success flash message.
        - Implement the `destroy(MaterialRequest $materialRequest)` method. Authorize `delete` for the `$materialRequest` instance. Delete the request. Redirect to the index route with a success flash message.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - **Index/Create/Store/Edit/Update/Destroy:** Perform similar checks as for Maintenance Requests, ensuring the `maintenance_request_id` linkage works, dropdowns are populated, and policies are enforced for staff (e.g., can only edit 'pending' requests).
6.  ☐ **Add Sidebar Link:** Add link to `route('admin.material-requests.index')` in the AdminLTE sidebar.
    **Cursor AI Prompt:**
    - In the AdminLTE sidebar Blade file, add a navigation link for 'Material Requests'.
    - Point this link to `route('admin.material-requests.index')`.
    - This link should be visible to both 'admin' and 'staff' roles.
    - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
    🧑‍💻 **Developer Check:**
    - Log in as admin/staff. Verify "Material Requests" link is visible and functional.
    *   **Key Learning Takeaway:** Reinforcing the advanced authorization patterns, working with optional foreign key relationships, and building complex forms with dynamic data (dropdown for related requests).
7.  **Create Material Request Tests:** Implement unit and feature tests.
    *   7.1. ☐ **Create MaterialRequestModelTest:** Test model relationships and attributes.
        **Cursor AI Prompt:**
        - Create a `MaterialRequestModelTest.php` file in the `tests/Unit/` directory.
        - Test that the `MaterialRequest` model correctly defines its relationships: `requester()` (belongsTo User) and `maintenanceRequest()` (belongsTo MaintenanceRequest).
        - Test that all required attributes (requester_id, maintenance_request_id, item_description, quantity, cost, funding_source, status) are fillable.
        - Verify that the model correctly handles nullable relationships (maintenanceRequest can be null).
        - Use the `RefreshDatabase` trait and create test models to verify relationship loading.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Unit/MaterialRequestModelTest.php`. Ensure tests pass.
    *   7.2. ☐ **Create MaterialRequestTest:** Test CRUD operations and permissions.
        **Cursor AI Prompt:**
        - Create a `MaterialRequestTest.php` file in the `tests/Feature/` directory.
        - Test CRUD operations: both admin and staff can create requests, view request lists (with proper filtering), and update requests.
        - Test permission rules: staff can only edit their own 'pending' requests, only admin can delete requests.
        - Test that material requests can be optionally linked to maintenance requests and that the relationship works correctly.
        - Test that the material request's requester_id is set to the authenticated user when created.
        - Use the `RefreshDatabase` trait and set up test users, maintenance requests, and material requests in the setUp method.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Run `php artisan test tests/Feature/MaterialRequestTest.php`. Ensure all feature tests pass.
    *   **Key Learning Takeaway:** Reinforcing the advanced authorization patterns, working with optional foreign key relationships, and building complex forms with dynamic data (dropdown for related requests).

---
[Back to Top](#)

### 3.7. Phase 6: Refinements & Next Steps
1.  ☐ **Review Dashboard Data:** Ensure all dashboard widgets are fetching and displaying correct, live data based on the implemented modules and user roles. (Refinement of Phase 3 Logic)
2.  **Eager Loading Review:** Go through all controller `index` and `show` methods (and any other places where related models are accessed in loops). Implement eager loading using `->with(['relationshipName', 'otherRelationship'])` where appropriate to prevent N+1 query problems. Use Laravel Debugbar (see Non-Functional Requirements) to verify query counts.
    *   2.1. ☐ **Maintenance Requests:**
        **Cursor AI Prompt:**
        - In the `Admin\MaintenanceRequestController@index` method, modify the Eloquent query to ensure the `requester` relationship is eager loaded using `->with('requester')` when fetching maintenance requests.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Install Laravel Debugbar (`composer require barryvdh/laravel-debugbar --dev`).
        - Visit the maintenance requests index page. Check the "Queries" tab in Debugbar. Note the number of queries.
        - If you were previously looping through requests and accessing `$request->requester->name` without eager loading, you should see a reduction in queries after implementing `->with('requester')`.
    *   2.2. ☐ **Material Requests:**
        **Cursor AI Prompt:**
        - In the `Admin\MaterialRequestController@index` method, modify the Eloquent query to ensure the `requester` and `maintenanceRequest` relationships are eager loaded using `->with(['requester', 'maintenanceRequest'])` when fetching material requests.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Visit the material requests index page.
        - Use Laravel Debugbar to verify that eager loading for `requester` and `maintenanceRequest` has reduced the number of database queries compared to not using `->with()`.
3.  **UI/UX Polish:**
    *   3.1. ☐ **Arabic Labels:** Ensure all forms have clear Arabic labels from localization files. (Manual task using `__('...')`)
    *   3.2. ☐ **Flash Messages:** Implement consistent flash messages (e.g., using `session()->flash('success', 'Message')`) for create, update, delete actions, and display them in your `layouts.admin` Blade file.
        **Cursor AI Prompt:**
        - In the `layouts/admin.blade.php` file, add Blade code within the main content area (e.g., right below the header or content-header) to check for and display success, error, or warning flash messages stored in the session using keys like `success`, `error`, `warning`.
        - Use AdminLTE alert styles for displaying these messages (e.g., `alert alert-success`, `alert alert-danger`, `alert alert-warning`).
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Perform a CRUD action (e.g., create a user). Verify the appropriate flash message (success, error) is displayed correctly with AdminLTE styling.
        - Check all CRUD actions across modules for consistent flash message display.
        **Cursor AI Prompt:**
        - Provide an example of how to redirect back to a list page (e.g., `route('admin.users.index')`) after a successful form submission in a Laravel controller's `store` or `update` method.
        - Show how to attach a success flash message (e.g., 'User created successfully!') to the session during the redirect using the `with()` method on the redirect response.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Review a `store` or `update` method in one of your controllers (e.g., `UserController`).
        - Ensure it uses `redirect()->route(...)->with('success', 'Your message');` or similar.
    *   3.3. ☐ **Styling Check:** Check for consistent styling and responsive behavior. (Manual Testing/CSS)
4.  ☐ **Comprehensive Testing:** Log in as different user roles and test every feature and permission boundary. (Manual Task)
    *   4.1. ☐ **Run all unit and feature tests:** Execute the full test suite with `php artisan test` and fix any failures.
        **Cursor AI Prompt:**
        - Execute all tests using `php artisan test` command.
        - Review any failing tests and fix the underlying issues.
        - Focus on edge cases where authorization rules might not be properly enforced.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - After running `php artisan test`, ensure the output shows all tests passing.
        - If any tests fail, debug the relevant code and test logic until they pass.
    *   4.2. ☐ **Generate and review test coverage reports:** Configure PHPUnit to generate coverage reports to identify untested code.
        **Cursor AI Prompt:**
        - Update your `phpunit.xml` file to enable code coverage reporting (e.g., add `<coverage processUncoveredFiles="true"><include><directory suffix=".php">./app</directory></include><report><html outputDirectory="build/coverage"/></report></coverage>`).
        - Generate a coverage report using `php artisan test --coverage`. (You might need Xdebug installed and configured for PHP).
        - Identify areas of the application with low test coverage and add additional tests to cover those areas.
        - Could you suggest any alternative or more standard Laravel practices for this specific task/code block, and explain why they might be better?
        🧑‍💻 **Developer Check:**
        - Open the generated HTML coverage report (e.g., in `build/coverage/index.html`).
        - Review the coverage percentages for your controllers, models, policies, etc.
        - Identify any critical logic that is not covered by tests.
5.  ☐ **Code Review & Refactoring (Self-Review):** Review code for cleanliness, repetition, and adherence to standards. (Manual Task)
    *   Read through your code. Is it clean and understandable?
    *   Are there any repetitive code blocks that could be refactored into helper methods or Blade components?
    *   Is the naming of variables, methods, and routes consistent and meaningful?
    *   **Learning:** Optimizing application performance with eager loading, improving user experience with feedback (flash messages), the importance of thorough testing across different user roles, and basic code refactoring principles.
    *   **Hints for Advanced Features (Post-Project Learning):**
        *   **File Uploads:** Allow users to attach images or documents to Maintenance Requests.
        *   **Notifications:** Send email notifications when a request status changes.
        *   **Reporting:** Generate simple reports (e.g., number of requests per month).
        *   **API Endpoints:** Create API endpoints for your resources using Laravel Sanctum for authentication.
        *   **Automated Testing:** Learn to write unit and feature tests with PHPUnit/PEST.

---
[Back to Top](#)

## 4. Functional Requirements

*(This section details *what* the system must do. The Roadmap in Section 3 outlines *how* to build it progressively.)*

### 4.1. General Notes for Development
*   ✅ **Modular Approach:** (Conceptual Note)
*   ✅ **Test Manually:** (Manual Task)
*   ✅ **Artisan Commands:** (Commands listed for reference, prompts focus on *after* command code)
*   ✅ **Laravel Documentation:** (Resource Note)
*   ✅ **Laravel Debugbar:** (Recommendation/Setup Note)

### 4.2. FR-AUTH: Authentication & Authorization
*   ✅ **FR-AUTH-01:** Use Laravel Breeze (Covered in Phase 0 & 1 AI Prompts).
*   ✅ **FR-AUTH-02:** Roles in `users` table (Covered in Phase 2 Data Model AI Prompts).
*   ✅ **FR-AUTH-03:** `auth` middleware for admin group (Covered in Phase 2 Routing AI Prompt).
*   ✅ **FR-AUTH-04:** Role-based restrictions via middleware/policies/Blade (Covered in Phase 2, 3, 4, 5 AI Prompts - IsAdmin middleware, Policy implementation, @can directives, Controller authorization).

### 4.3. FR-GBL: Global UI Elements (AdminLTE)
*   ✅ **FR-GBL-01:** Use AdminLTE (Covered in Phase 1 AI Prompts).
*   ✅ **FR-GBL-02:** Arabic & RTL (Implemented with proper RTL styling for both admin and login layouts, with correct text alignment and icon positioning for Arabic interface).
*   ☐ **FR-GBL-03:** Sidebar navigation based on role (Covered in Phase 2, 4, 5 Sidebar Link AI Prompts using `@can`).

### 4.4. FR-DASH: Dashboard
*   ☐ **FR-DASH-01:** Summary widgets (Covered in Phase 3 AI Prompts).
*   ☐ **FR-DASH-02:** Role-specific content (Covered in Phase 3 AI Prompts - Controller Logic).

### 4.5. FR-ADM: User (Administrator & Staff) Management \[Admin Only Access]
*   ✅ **FR-ADM-01 to FR-ADM-05:** CRUD & Admin-Only Access (Covered extensively in Phase 2 AI Prompts - Migration, Model, Seeder, Routes, Middleware, Policy, Form Requests, Views, Controller Methods, Sidebar Link).

### 4.6. FR-MR: Maintenance Request Management
*   ✅ **FR-MR-01 to FR-MR-05:** CRUD & Role-Based Policies (Covered extensively in Phase 4 AI Prompts - Migration, Model, Routes, Policy, Form Requests, Views, Controller Methods, Sidebar Link).

### 4.7. FR-MAT: Material Request Management
*   ✅ **FR-MAT-01 to FR-MAT-05:** CRUD & Role-Based Policies (Covered extensively in Phase 5 AI Prompts - Migration, Model, Routes, Policy, Form Requests, Views, Controller Methods, Sidebar Link).

---
[Back to Top](#)

## 5. Data Model (MySQL)

### 5.1. Database Schema Overview
✅ Covered by the specific migration prompts in Phases 2, 4, and 5.

### 5.2. `users` Table
✅ Base table created by Laravel migration
☐ Additional fields (role, phone, civil_id) to be added in Phase 2

### 5.3. `maintenance_requests` Table
☐ To be implemented in Phase 4

### 5.4. `material_requests` Table
☐ To be implemented in Phase 5

### 5.5. Eloquent Model Relationships
☐ To be implemented in Phases 2, 4, and 5

### 5.6. Database Seeding
☐ To be implemented in Phase 2

---
[Back to Top](#)

## 6. Use Cases
✅ These are illustrative scenarios. Development tasks are derived from the Functional Requirements and implemented in the Roadmap.

---
[Back to Top](#)

## 7. Workflows
✅ These describe sequences of operations. Development tasks are derived from the Functional Requirements and implemented in the Roadmap.

---
[Back to Top](#)

## 8. Non-Functional Requirements

### 8.1. Usability (NFR-USAB)
*   ✅ **NFR-USAB-01:** UI/AdminLTE consistency (Covered in Phase 1 Layout and subsequent view prompts using AdminLTE components).
*   ✅ **NFR-USAB-02:** Arabic & RTL (Covered in Phase 1 AI prompts).

### 8.2. Security (NFR-SEC)
*   ✅ **NFR-SEC-01:** XSS, CSRF, SQLi protection (Laravel default protections implemented)
*   ✅ **NFR-SEC-02:** Authentication/Password Hashing (Laravel Breeze implemented in Phase 0/1)
*   ✅ **NFR-SEC-03:** Authorization Enforcement (Implemented with UserPolicy and IsAdmin middleware)
*   ✅ **NFR-SEC-04:** Server-side Validation (Implemented in Form Request classes for User management)

### 8.3. Performance (NFR-PERF)
*   ✅ **NFR-PERF-01:** Page Load Times (Goal, not code generation prompt).
*   ✅ **NFR-PERF-02:** Eager Loading (Implemented in UserManagementTest and other controllers).
*   ✅ **NFR-PERF-03:** Pagination (Implemented in the UserController index method).

### 8.4. Maintainability (NFR-MAINT)
*   ✅ **NFR-MAINT-01 to NFR-MAINT-05:** Coding Standards, MVC, Lean Controllers, Comments, Config (These are principles the *user* should follow while using the AI, and the AI's generated code *should* ideally adhere to them. Not specific AI prompts for *generating* these concepts themselves).

### 8.5. Compatibility (NFR-COMP)
*   ✅ **NFR-COMP-01:** Browser Compatibility (Goal, not code generation prompt - depends on frontend code).

### 8.6. Asset Management (NFR-VITE)
*   ✅ **NFR-VITE-01:** Use Laravel Vite (Covered in Phase 1 AI prompts).

---
[Back to Top](#)