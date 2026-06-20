<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;
    protected Admin $manager;
    protected Admin $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        $this->admin = Admin::factory()->create(['role' => 'admin']);
        $this->manager = Admin::factory()->create(['role' => 'manager']);
        $this->viewer = Admin::factory()->create(['role' => 'viewer']);
    }

    public function test_admin_can_create_category()
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->post(route('category.store'), [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'status' => 1,
        ]);

        $response->assertRedirect(route('category.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics',
            'slug' => 'electronics',
        ]);
    }

    public function test_manager_cannot_create_category()
    {
        $this->actingAs($this->manager, 'admin');

        $response = $this->post(route('category.store'), [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'status' => 1,
        ]);

        $response->assertForbidden(); // Policy should prevent this
    }

    public function test_viewer_cannot_create_category()
    {
        $this->actingAs($this->viewer, 'admin');

        $response = $this->post(route('category.store'), [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'status' => 1,
        ]);

        $response->assertForbidden(); // Policy should prevent this
    }

    public function test_admin_can_update_category()
    {
        $this->actingAs($this->admin, 'admin');
        $category = Category::factory()->create();

        $response = $this->put(route('category.update', $category->id), [
            'name' => 'Updated Name',
            'slug' => 'updated-slug',
            'status' => 1,  
            'parent_id' => null,
            'description' => 'Updated description',
            'is_featured' => 0,
        ]);

        $response->assertRedirect(route('category.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_manager_can_update_category()
    {
        $this->actingAs($this->manager, 'admin');
        $category = Category::factory()->create();

        $response = $this->put(route('category.update', $category->id), [
            'name' => 'Updated Name',
            'slug' => 'updated-slug',
            'status' => 1,  
            'parent_id' => null,
            'description' => 'Updated description',
            'is_featured' => 0,
        ]);

        $response->assertRedirect(route('category.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_viewer_cannot_update_category()
    {
        $this->actingAs($this->viewer, 'admin');
        $category = Category::factory()->create();

        $response = $this->put(route('category.update', $category->id), [
            'name' => 'Updated Name',
            'slug' => 'updated-slug',
            'status' => 1,  
            'parent_id' => null,
            'description' => 'Updated description',
            'is_featured' => 0,
        ]);

        $response->assertForbidden();
    }

    public function test_admin_can_delete_category()
    {
        $this->actingAs($this->admin, 'admin');
        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_manager_cannot_delete_category()
    {
        $this->actingAs($this->manager, 'admin');
        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category->id));
        $response->assertForbidden();
    }

    public function test_viewer_cannot_delete_category()
    {
        $this->actingAs($this->viewer, 'admin');
        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category->id));
        $response->assertForbidden();
    }

    public function test_admin_can_bulk_delete_categories()
    {
        $this->actingAs($this->admin, 'admin');

        $categories = Category::factory()->count(3)->create();
        $ids = $categories->pluck('id')->implode(',');

        $response = $this->post(route('category.bulk-delete'), [
            'category_ids' => $ids,
        ]);

        $response->assertRedirect();
        foreach ($categories as $category) {
            $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        }
    }

    public function test_admin_can_import_categories()
    {
        $this->actingAs($this->admin, 'admin');

        Storage::fake('public');

        $file = UploadedFile::fake()->create('categories.xlsx');

        $response = $this->post(route('categories.import'), [
            'categories_file' => $file,
        ]);

        $response->assertRedirect();
    }
}
