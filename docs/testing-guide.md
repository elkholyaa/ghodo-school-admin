# Testing Guide for Ghodo School Admin

## Overview

This document outlines the testing strategy and procedures for the Ghodo School Admin Panel project. It provides guidelines for testing different components of the application to ensure quality and functionality.

## Test Environment

- **Database**: MySQL 8+ (as configured in `.env`: DB_CONNECTION=mysql, DB_DATABASE=ghodo_admin_db)
- **PHP Version**: 8.2+
- **Laravel Version**: 12.x
- **Browser Support**: Chrome, Firefox, Safari, Edge (latest versions)
- **Testing Framework**: PHPUnit (built into Laravel)
- **Development Tools**:
  - Laravel Debugbar (barryvdh/laravel-debugbar): For debugging and performance monitoring
  - Laravel IDE Helper (barryvdh/laravel-ide-helper): For improved IDE support

## Types of Tests

### 1. Unit Tests

Unit tests verify that individual components work as expected in isolation.

**Location**: `tests/Unit/`

**When to use**: Test individual methods in models, services, or helper classes.

**Example**: Testing the `User::isAdmin()` method returns correct boolean values.

```php
public function test_is_admin_returns_true_for_admin_role()
{
    $user = User::factory()->create(['role' => 'admin']);
    $this->assertTrue($user->isAdmin());
}

public function test_is_admin_returns_false_for_staff_role()
{
    $user = User::factory()->create(['role' => 'staff']);
    $this->assertFalse($user->isAdmin());
}
```

### 2. Feature Tests

Feature tests verify that entire features or user flows work correctly, including database interactions, HTTP requests, and more.

**Location**: `tests/Feature/`

**When to use**: Test entire user flows, API endpoints, or controller actions.

**Example**: Testing that an admin user can create another user, but a staff user cannot.

```php
public function test_staff_cannot_access_user_management()
{
    $staff = User::factory()->create(['role' => 'staff']);
    
    $response = $this->actingAs($staff)->get(route('admin.users.index'));
    
    $response->assertStatus(403); // Forbidden
}
```

### 3. Integration Tests

Integration tests verify that multiple components work together correctly.

**Location**: `tests/Feature/` (Laravel doesn't strictly separate these from feature tests)

**When to use**: Test how different parts of the application work together.

**Example**: Testing that a maintenance request creates associated records in the database.

### 4. Browser Tests (Optional for Future)

Browser tests automate tests in a real browser.

**Location**: `tests/Browser/` (requires Laravel Dusk installation)

**When to use**: Test JavaScript interactions and complex UI behavior.

**Example**: Testing form submissions with validation errors.

### 5. Manual Tests

Manual tests involve human testing to verify functionality.

**When to use**: Complex user interactions or visual UI verification.

## Setting Up a Test Environment

1. Create a test database in MySQL:
   ```bash
   mysql -u root -p
   CREATE DATABASE ghodo_admin_test;
   GRANT ALL PRIVILEGES ON ghodo_admin_test.* TO 'your_user'@'localhost';
   ```

2. Configure `.env.testing`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ghodo_admin_test
   DB_USERNAME=your_user
   DB_PASSWORD=your_password
   ```

3. Run tests with:
   ```bash
   php artisan test
   # Or for specific tests:
   php artisan test --filter UserManagementTest
   ```

## Existing Test Coverage

The application already has the following tests:

1. `UserManagementTest` - Tests admin user management functionality including:
   - Admin ability to view user list
   - Staff restrictions from user management
   - Creating, editing, and deleting users
   - Authorization policies

## Test Conventions

1. **Naming**:
   - Unit test classes should be named after the class they test with "Test" suffix
   - Unit test methods should start with `test_method_name_scenario`
   - Feature test methods should start with `test_action_scenario_result`

2. **Assertions**:
   - Use specific assertions (`assertSee`, `assertStatus`) over generic ones
   - Test both positive cases and edge/failure cases

3. **Database**:
   - Use `RefreshDatabase` trait for tests that modify the database
   - Create dedicated factories for test data

## Test Plan for Pending Features

### Maintenance Request Tests

```php
class MaintenanceRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
        
        // Create some test maintenance requests
        $this->adminRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->admin->id,
            'status' => 'new'
        ]);
        
        $this->staffRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function admin_can_view_all_maintenance_requests()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.maintenance-requests.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('maintenanceRequests');
        $response->assertSee($this->adminRequest->title);
        $response->assertSee($this->staffRequest->title);
    }
    
    /** @test */
    public function staff_can_view_only_their_own_maintenance_requests()
    {
        $response = $this->actingAs($this->staff)
                         ->get(route('admin.maintenance-requests.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('maintenanceRequests');
        $response->assertDontSee($this->adminRequest->title);
        $response->assertSee($this->staffRequest->title);
    }
    
    /** @test */
    public function admin_can_update_request_status()
    {
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.maintenance-requests.update', $this->staffRequest), [
                             'title' => $this->staffRequest->title,
                             'description' => $this->staffRequest->description,
                             'location' => $this->staffRequest->location,
                             'status' => 'in_progress',
                             'priority' => $this->staffRequest->priority
                         ]);
        
        $response->assertRedirect(route('admin.maintenance-requests.index'));
        $this->assertEquals('in_progress', $this->staffRequest->fresh()->status);
    }
    
    /** @test */
    public function staff_cannot_update_completed_requests()
    {
        // Set the request to completed
        $this->staffRequest->update(['status' => 'completed']);
        
        $response = $this->actingAs($this->staff)
                         ->put(route('admin.maintenance-requests.update', $this->staffRequest), [
                             'title' => 'Updated Title',
                             'description' => $this->staffRequest->description,
                             'location' => $this->staffRequest->location,
                             'priority' => $this->staffRequest->priority
                         ]);
        
        $response->assertStatus(403); // Forbidden
        $this->assertNotEquals('Updated Title', $this->staffRequest->fresh()->title);
    }
}
```

### Material Request Tests

```php
class MaterialRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staff = User::factory()->create(['role' => 'staff']);
        
        // Create a maintenance request
        $this->maintenanceRequest = MaintenanceRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'status' => 'in_progress'
        ]);
        
        // Create some test material requests
        $this->adminRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->admin->id,
            'status' => 'pending'
        ]);
        
        $this->staffRequest = MaterialRequest::factory()->create([
            'requester_id' => $this->staff->id,
            'maintenance_request_id' => $this->maintenanceRequest->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function admin_can_view_all_material_requests()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.material-requests.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas('materialRequests');
        $response->assertSee($this->adminRequest->item_description);
        $response->assertSee($this->staffRequest->item_description);
    }
    
    /** @test */
    public function staff_can_create_material_request_linked_to_maintenance_request()
    {
        $requestData = [
            'maintenance_request_id' => $this->maintenanceRequest->id,
            'item_description' => 'Test Material',
            'quantity' => 5,
            'cost' => 100.50,
            'funding_source' => 'maintenance',
            'status' => 'pending'
        ];
        
        $response = $this->actingAs($this->staff)
                         ->post(route('admin.material-requests.store'), $requestData);
        
        $response->assertRedirect(route('admin.material-requests.index'));
        $this->assertDatabaseHas('material_requests', [
            'item_description' => 'Test Material',
            'maintenance_request_id' => $this->maintenanceRequest->id,
            'requester_id' => $this->staff->id
        ]);
    }
}
```

## Testing Database Configuration

The project is configured to use MySQL for testing. This is defined in `phpunit.xml`:

```xml
<env name="DB_CONNECTION" value="mysql"/>
<env name="DB_DATABASE" value="ghodo_admin_db"/>
<env name="DB_USERNAME" value="root"/>
<env name="DB_PASSWORD" value=""/>
```

## Running Tests

To run all tests:

```bash
php artisan test
```

To run a specific test:

```bash
php artisan test --filter=UserModelTest
```

To run tests in a specific directory:

```bash
php artisan test tests/Feature/
```

## Writing Tests

### Test Naming Conventions

- Test method names should start with `test_` and describe what is being tested
- Example: `test_admin_can_create_user()`

### Test Structure

- Each test should follow the Arrange-Act-Assert pattern
- Use the `RefreshDatabase` trait when testing database interactions
- Use factories to create test data

### Assertions

Common assertions:

- `$this->assertTrue($value)`
- `$this->assertEquals($expected, $actual)`
- `$this->assertDatabaseHas($table, $data)`
- `$response->assertStatus(200)`

### Testing Authorization

- Use `$this->actingAs($user)` to authenticate as a user
- Test both positive (authorized) and negative (unauthorized) cases

## Using Laravel Debugbar

Laravel Debugbar is a powerful tool for debugging during testing:

- Shows executed queries and their timing
- Displays request information
- Tracks memory usage

To enable/disable Debugbar:

```php
// Enable
\Debugbar::enable();

// Disable
\Debugbar::disable();
```

## Continuous Integration

For future implementation, consider setting up CI/CD pipeline with GitHub Actions or Jenkins to run tests automatically.

## Best Practices

1. **Isolation**: Tests should be independent of each other
2. **Database Reset**: Use the `RefreshDatabase` trait to reset the database between tests
3. **Factories**: Use factories to generate test data
4. **Real Database**: Test with the same database type as production (MySQL)
5. **Cover Edge Cases**: Test for both valid and invalid inputs
6. **Readable Tests**: Write clear, descriptive test methods and messages
7. **Keep Tests Fast**: Optimize tests to run quickly
8. **Test Critical Paths**: Focus on testing business-critical functionality

## Troubleshooting Common Test Issues

1. **Test database connection issues**: Verify credentials in `.env.testing`
2. **Slow tests**: Identify and optimize database-heavy tests
3. **Random failures**: Check for race conditions or dependency on external services
4. **SQLite vs MySQL issues**: When using different database for testing, be aware of syntax differences
   - For the Ghodo School Admin project, use MySQL for testing to avoid SQLite compatibility issues

## Required Test Coverage for Project

The following modules must have comprehensive test coverage:

1. **User Management**
   - ✅ Admin can view, create, edit and delete users
   - ✅ Staff cannot access user management functions
   - ✅ Authorization policies work correctly

2. **Maintenance Requests**
   - Admin can view and manage all requests
   - Staff can view and manage only their own requests
   - Status changes follow business rules

3. **Material Requests**
   - Admin can view and manage all requests
   - Staff can create and manage requests within permissions
   - Optional link to Maintenance Requests works correctly 