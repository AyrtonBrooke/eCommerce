<?php

namespace Tests\Unit;

use App\Models\Pizza;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PizzaTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_for_pizzas()
    {
        $names = ['Gimme the Meat', 'Original', 'Veggie Delight', 'Make Mine Hot'];

        foreach ($names as $name) {
            $this->assertDatabaseHas('pizzas', ['name' => $name]);
        }
    }

    public function testPizzaCreation()
    {
        $admin = User::where('is_admin', 1)->firstOrFail();

        $pizzaData = [
            'name' => 'Hawaiian',
            'description' => 'Ham and Pineapple',
            'small_pizza_price' => '10.50',
            'medium_pizza_price' => '12.00',
            'large_pizza_price' => '13.50',
            'category' => 'traditional',
            'image' => UploadedFile::fake()->image('pizza.jpg')
        ];

        $response = $this->actingAs($admin)->post('/admin/pizza/store', $pizzaData);

        $response->assertRedirect('/admin/pizza');
    }

    public function testPizzaDeletion()
    {
        $admin = User::where('is_admin', 1)->firstOrFail();

        $pizza = Pizza::findOrFail(25);

        // Send a delete request to the route that deletes the pizza
        $response = $this->actingAs($admin)->delete("/admin/pizza/{$pizza->id}/delete");

        // Check if the response indicates a successful deletion
        $response->assertRedirect('/admin/pizza');

        // Check if the pizza record is no longer in the database
        $this->assertDatabaseMissing('pizzas', ['id' => $pizza->id]);
    }

    public function testPizzaUpdate()
    {
        $admin = User::where('is_admin', 1)->firstOrFail();

        // Retrieve a pizza from the database by its ID
        $pizza = Pizza::findOrFail(27);

        // New data for updating the pizza
        $updatedData = [
            'name' => 'New Name',
            'description' => 'New Description',
            'small_pizza_price' => '11.50',
            'medium_pizza_price' => '13.00',
            'large_pizza_price' => '14.50',
            'category' => 'updated-category',
            'image' => UploadedFile::fake()->image('pizza.jpg')
        ];

        // Send a put request to the route that updates the pizza
        $response = $this->actingAs($admin)->put("/admin/pizza/{$pizza->id}/update", $updatedData);

        // Check if the response indicates a successful update
        $response->assertRedirect('/admin/pizza');
    }
}
