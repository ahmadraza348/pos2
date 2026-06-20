<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;


class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }
 public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        // Create an admin with hashed password
        $admin = Admin::factory()->create([
            'username' => 'testadmin',
            'password' => Hash::make('password'), // Ensure the password is hashed
            'status' => '1',
        ]);

        // Attempt to login
        $response = $this->post(route('admin.login.submit'), [
            'email_username' => 'testadmin', 
            'password' => 'password', // Plain password
        ]);

        // Use the correct guard for the assertion
        $this->assertAuthenticatedAs($admin, 'admin'); // Ensure correct guard is used
        $response->assertRedirect(route('admin.dashboard'));
} 
    public function test_admin_can_not_authenticate_with_invalid_password(){
$admin = Admin::factory()->create();
$this->post(route('admin.login.submit'), [
    'username'=> 'testuser',
    'password'=> 'wrong-password'
]);
  $this->assertGuest();
}  

 
    public function test_admin_can_logout(): void
    {
        // Create an admin user
        $admin = Admin::factory()->create();

        // Act as the admin using the 'admin' guard and post to the logout route
        $response = $this->actingAs($admin, 'admin')->post(route('admin.logout'));

        // Assert that the user is logged out and is a guest on the 'admin' guard
        $this->assertGuest('admin');

        // Assert the user is redirected to the admin login page
        $response->assertRedirect(route('admin.login'));
    }
}

