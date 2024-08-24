<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_frontpage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage()
    {
        $response = $this->get('/home');

        $response->assertStatus(200);
    }

    public function test_cart()
    {
        $response = $this->get('/user/order');

        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'Artin',
            'email' => 'artin@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();
        $user = User::first();

        if($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name' => 'Artin',
            'email' => 'artin@gmail.com',
            'password' => 'artin12345',
            'password_confirmation' => 'artin12345',
        ]);

        $response->assertRedirect('/home');
    }

    public function test_database()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'Artin'
        ]);
    }
}
