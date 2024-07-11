<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase; // Resets the database after each test

    public function test_can_register_user()
    {
        $this->withoutExceptionHandling();

        // Define the user data you want to register
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user', // Assuming you have a role field in your registration form
        ];

        // Simulate a POST request to your registration endpoint
        $response = $this->post('/register', $userData);

        // Assert that the user was created and redirected to the viewusers route
        $response->assertStatus(302); // Assuming a redirect after successful registration
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'role' => 'user',
        ]);
    }
}
