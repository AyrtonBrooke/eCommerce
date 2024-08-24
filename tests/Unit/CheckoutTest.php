<?php

namespace Tests\Unit;

use App\Models\Order;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function testCheckout()
    {
        // Create a sample order
        $order = Order::create([
            'user_id' => 1,
            'pizza_id' => 1,
            'pizza_price' => 10.99,
            'pizza_size' => 'medium',
            'body' => 'Sample order',
        ]);

        // Mock the request data
        $requestData = [
            'phone' => '1234567890',
            'total' => 10.99,
            'delivery_choice' => 'collection',
        ];

        // Perform the checkout
        $response = $this->post('/checkout', $requestData);

        // Assert that the response has a successful redirection
        $response->assertRedirect();

        // Assert that the order has been cleared
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);

        // Assert that the checkout record has been created
        $this->assertDatabaseHas('checkout', [
            'user_id' => $order->user_id,
            'pizza_id' => $order->pizza_id,
            'pizza_price' => $order->pizza_price,
            'pizza_size' => $order->pizza_size,
            'body' => $order->body,
            'phone' => $requestData['phone'],
            'total' => $requestData['total'],
            'delivery_choice' => $requestData['delivery_choice'],
        ]);
    }

    public function test_database()
    {
        $this->assertDatabaseHas('checkout', [
            'phone' => '07766949606'
        ]);
    }


}
