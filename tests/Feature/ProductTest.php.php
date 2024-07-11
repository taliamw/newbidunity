<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\NewProduct;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_product()
    {
        $this->actingAs(User::factory()->create()); // Authenticate as a user

        $response = $this->post('/products', [
            'name' => 'Test Product',
            'description' => 'Description of test product',
            'price' => 100,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'duration_value' => 1,
            'duration_unit' => 'hours',
            'documents' => [], // Add any required fields
        ]);

        $response->assertRedirect('/products'); // Verify redirection after successful store
        $this->assertDatabaseHas('new_products', ['name' => 'Test Product']);
    }

    // Add more test methods for other controller actions as needed
}
