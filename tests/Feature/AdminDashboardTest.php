<?php

namespace Tests\Feature;

use App\Models\CarouselSlide;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper to create an admin user and organization.
     */
    private function createAdminEnvironment()
    {
        $org = Organization::create([
            'name' => 'AdminCorp',
            'slug' => 'admincorp',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Admin Boss',
            'email' => 'admin@admincorp.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'department' => 'Admin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        return [$org, $admin];
    }

    /**
     * Test admin can view admin dashboard with role breakdown and employee counts.
     */
    public function test_admin_can_view_dashboard_overview(): void
    {
        [$org, $admin] = $this->createAdminEnvironment();

        // Create secondary employee
        User::create([
            'name' => 'Jane Staff',
            'email' => 'jane@admincorp.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'department' => 'Engineering',
            'role' => 'Employee',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admin Control Center');
        $response->assertSee('AdminCorp');
        $response->assertSee('Jane Staff');
    }

    /**
     * Test admin can update organization name.
     */
    public function test_admin_can_update_organization_name(): void
    {
        [$org, $admin] = $this->createAdminEnvironment();

        $response = $this->actingAs($admin)->put('/admin/organization/name', [
            'name' => 'AdminCorp Global',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('organizations', [
            'id' => $org->id,
            'name' => 'AdminCorp Global',
        ]);
    }

    /**
     * Test admin can update user role and toggle active status.
     */
    public function test_admin_can_edit_user_role_and_toggle_status(): void
    {
        [$org, $admin] = $this->createAdminEnvironment();

        $member = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@admincorp.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'department' => 'HR',
            'role' => 'Employee',
            'is_active' => true,
        ]);

        // Change role to Manager
        $responseRole = $this->actingAs($admin)->put("/admin/users/{$member->id}/role", [
            'role' => 'Manager',
        ]);
        $responseRole->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $member->id,
            'role' => 'Manager',
        ]);

        // Toggle user status to inactive
        $responseStatus = $this->actingAs($admin)->put("/admin/users/{$member->id}/toggle-status");
        $responseStatus->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $member->id,
            'is_active' => false,
        ]);
    }

    /**
     * Test admin can manage homepage carousel slides.
     */
    public function test_admin_can_manage_carousel_slides(): void
    {
        [$org, $admin] = $this->createAdminEnvironment();

        // Create slide
        $responseCreate = $this->actingAs($admin)->post('/admin/carousel/slides', [
            'title' => 'New Slide Header',
            'subtitle' => '04 / INNOVATION',
            'description' => 'Innovative work environment for teams.',
        ]);
        $responseCreate->assertRedirect();
        $this->assertDatabaseHas('carousel_slides', [
            'organization_id' => $org->id,
            'title' => 'New Slide Header',
        ]);

        $slide = CarouselSlide::where('organization_id', $org->id)->where('title', 'New Slide Header')->first();

        // Update slide
        $responseUpdate = $this->actingAs($admin)->put("/admin/carousel/slides/{$slide->id}", [
            'title' => 'Updated Slide Header',
            'subtitle' => '04 / INNOVATION',
            'description' => 'Updated description content.',
        ]);
        $responseUpdate->assertRedirect();
        $this->assertDatabaseHas('carousel_slides', [
            'id' => $slide->id,
            'title' => 'Updated Slide Header',
        ]);

        // Delete slide
        $responseDelete = $this->actingAs($admin)->delete("/admin/carousel/slides/{$slide->id}");
        $responseDelete->assertRedirect();
        $this->assertDatabaseMissing('carousel_slides', [
            'id' => $slide->id,
        ]);
    }

    /**
     * Test admin can create Nest workspace.
     */
    public function test_admin_can_create_nest(): void
    {
        [$org, $admin] = $this->createAdminEnvironment();

        $response = $this->actingAs($admin)->post('/admin/nests', [
            'nest_name' => 'Q4 Growth Taskforce',
            'department' => 'Sales',
            'description' => 'Group channel for Q4 sales targets.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
    }
}
