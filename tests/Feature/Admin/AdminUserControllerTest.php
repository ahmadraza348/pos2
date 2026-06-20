<?php
namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Authenticate an admin for the tests
     */
    private function authenticateAdmin()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        return $admin;
    }

    /**
     * Test admin user show page works
     */
    public function test_admin_user_show(): void
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.user.show'));
        $response->assertStatus(200);
    }

    /**
     * Test add admin user page works
     */
    public function test_add_admin_user_page_working(): void
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.user.add'));
        $response->assertStatus(200);
    }

   

}
