<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test real-time organization availability check endpoint.
     */
    public function test_check_organization_api(): void
    {
        $orgName = 'TestOrg_' . rand(1000, 9999);

        // Non-existent organization check
        $response = $this->get('/api/check-organization?name=' . urlencode($orgName));
        $response->assertStatus(200);
        $response->assertJson(['exists' => false]);

        // Create organization
        Organization::create(['name' => $orgName, 'slug' => strtolower($orgName), 'is_active' => true]);

        // Existing organization check (case-insensitive)
        $response2 = $this->get('/api/check-organization?name=' . urlencode(strtolower($orgName)));
        $response2->assertStatus(200);
        $response2->assertJson(['exists' => true]);
    }

    /**
     * Test founder registration for brand new organization.
     */
    public function test_founder_registration_creates_org_and_assigns_admin_role(): void
    {
        $orgName = 'FounderOrg_' . rand(1000, 9999);
        $email = 'founder_' . rand(1000, 9999) . '@test.com';

        $response = $this->post('/register', [
            'organization_name' => $orgName,
            'name' => 'Founder User',
            'email' => $email,
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $this->assertDatabaseHas('organizations', [
            'name' => $orgName,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'admin',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test member registration joining existing organization.
     */
    public function test_member_registration_joins_existing_org_with_role_and_department(): void
    {
        $org = Organization::create([
            'name' => 'ExistingCorp_' . rand(1000, 9999),
            'slug' => 'existingcorp-' . rand(1000, 9999),
            'is_active' => true,
        ]);

        $email = 'member_' . rand(1000, 9999) . '@test.com';

        $response = $this->post('/register', [
            'organization_name' => $org->name,
            'name' => 'Member User',
            'email' => $email,
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'Manager',
            'department' => 'Engineering',
        ]);

        $response->assertRedirect('/manager/dashboard');

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'organization_id' => $org->id,
            'role' => 'Manager',
            'department' => 'Engineering',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test login with valid organization name, email, and password.
     */
    public function test_login_with_valid_organization_and_credentials(): void
    {
        $org = Organization::create([
            'name' => 'LoginOrg_' . rand(1000, 9999),
            'slug' => 'loginorg-' . rand(1000, 9999),
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'HR User',
            'email' => 'hr_' . rand(1000, 9999) . '@test.com',
            'password' => bcrypt('Password123!'),
            'organization_id' => $org->id,
            'department' => 'HR',
            'role' => 'HR',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'organization_name' => $org->name,
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/hr/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login fails when organization name does not match user's account.
     */
    public function test_login_fails_with_mismatched_organization_name(): void
    {
        $org = Organization::create([
            'name' => 'CorrectOrg_' . rand(1000, 9999),
            'slug' => 'correctorg-' . rand(1000, 9999),
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Employee User',
            'email' => 'employee_' . rand(1000, 9999) . '@test.com',
            'password' => bcrypt('Password123!'),
            'organization_id' => $org->id,
            'department' => 'Sales',
            'role' => 'Employee',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'organization_name' => 'WrongOrgName',
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('organization_name');
        $this->assertGuest();
    }

    /**
     * Test middleware role protection redirects unauthorized access back to user's dashboard.
     */
    public function test_middleware_redirects_unauthorized_dashboard_access(): void
    {
        $org = Organization::create([
            'name' => 'RoleOrg_' . rand(1000, 9999),
            'slug' => 'roleorg-' . rand(1000, 9999),
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Employee User',
            'email' => 'emp_' . rand(1000, 9999) . '@test.com',
            'password' => bcrypt('Password123!'),
            'organization_id' => $org->id,
            'department' => 'Operations',
            'role' => 'Employee',
            'is_active' => true,
        ]);

        // Attempting to visit /admin/dashboard as Employee
        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Should be intercepted by CheckRole middleware and redirected to /employee/dashboard
        $response->assertRedirect('/employee/dashboard');
    }
}
