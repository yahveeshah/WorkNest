<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkNestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Admin registers a new organization successfully.
     * When organization name does NOT exist, user gets role=admin and is redirected to /admin/dashboard.
     */
    public function test_admin_can_register_organization_and_user_account(): void
    {
        $response = $this->post('/register', [
            'organization_name' => 'Acme Corporation',
            'name' => 'John Admin',
            'email' => 'john@acme.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // No role or department submitted — org is new so they are auto-assigned admin
        ]);

        $response->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('organizations', [
            'name' => 'Acme Corporation',
            'slug' => 'acme-corporation',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Admin',
            'email' => 'john@acme.com',
            'department' => 'Admin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test that a user cannot join a non-existent organization.
     * When org exists and role/department are submitted, but org doesn't exist → validation error on organization_name.
     */
    public function test_non_admin_cannot_register_if_organization_does_not_exist(): void
    {
        // Org doesn't exist, but user submits role+department thinking it does
        $response = $this->post('/register', [
            'organization_name' => 'Non Existent Corp',
            'name' => 'Jane HR',
            'email' => 'jane@acme.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'department' => 'HR',
            'role' => 'HR',
        ]);

        // Since the org doesn't actually exist, RegisterController will return error on organization_name
        $response->assertSessionHasErrors(['organization_name']);
        $this->assertDatabaseCount('organizations', 0);
        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    /**
     * Test Non-Admin can join an existing organization with a valid role/department.
     */
    public function test_non_admin_can_join_existing_organization(): void
    {
        // Pre-create organization
        $org = Organization::create([
            'name' => 'Acme Corporation',
            'slug' => 'acme-corporation',
            'is_active' => true,
        ]);

        $response = $this->post('/register', [
            'organization_name' => 'Acme Corporation',
            'name' => 'Jane HR',
            'email' => 'jane@acme.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'department' => 'HR',
            'role' => 'HR',
        ]);

        $response->assertRedirect('/hr/dashboard');

        $this->assertDatabaseHas('users', [
            'name' => 'Jane HR',
            'email' => 'jane@acme.com',
            'organization_id' => $org->id,
            'department' => 'HR',
            'role' => 'HR',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test role middleware redirects unauthorized users to their correct dashboard.
     */
    public function test_role_middleware_redirects_unauthorized_users(): void
    {
        $org = Organization::create([
            'name' => 'Acme Corporation',
            'slug' => 'acme-corporation',
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Jane HR',
            'email' => 'jane@acme.com',
            'password' => bcrypt('password123'),
            'organization_id' => $org->id,
            'department' => 'HR',
            'role' => 'hr',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        // Try to access admin dashboard — should redirect to hr dashboard
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/hr/dashboard');
    }

    /**
     * Test Admin can delete organization, which soft deletes all users and organization itself.
     */
    public function test_admin_can_delete_organization_and_deactivate_users(): void
    {
        $org = Organization::create([
            'name' => 'Acme Corporation',
            'slug' => 'acme-corporation',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'John Admin',
            'email' => 'john@acme.com',
            'password' => bcrypt('password123'),
            'organization_id' => $org->id,
            'department' => 'Admin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $employee = User::create([
            'name' => 'Jane HR',
            'email' => 'jane@acme.com',
            'password' => bcrypt('password123'),
            'organization_id' => $org->id,
            'department' => 'HR',
            'role' => 'hr',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->post('/admin/organization/delete');

        $response->assertRedirect('/');
        $this->assertGuest();

        // Verify organization is soft deleted and is_active is false
        $this->assertSoftDeleted('organizations', [
            'id' => $org->id,
        ]);
        $this->assertDatabaseHas('organizations', [
            'id' => $org->id,
            'is_active' => false,
        ]);

        // Verify users are soft deleted and is_active is false
        $this->assertSoftDeleted('users', [
            'id' => $admin->id,
        ]);
        $this->assertSoftDeleted('users', [
            'id' => $employee->id,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'is_active' => false,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'is_active' => false,
        ]);
    }
}
