<?php

namespace Tests\Feature;

use App\DTOs\UserDTO;
use App\services\UserServices as ServicesUserServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class userServices extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        ServicesUserServices::createUser(new UserDTO(
            id: 0,
            name: 'i',
            email: 'i',
            password: 'i'
        ));

        $this->assertDatabaseHas('users',[
            'name' => 'i',
            'email' => 'i',
            'password' => Hash::make('i')
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
