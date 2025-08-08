<?php

namespace Tests\Feature;

use App\Constants\RoleConstants;
use App\DTOs\Summary\UserDTO;
use App\Repositories\UserRepository;
use App\services\UserServices as ServicesUserServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class userServices extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $service = new ServicesUserServices(new UserRepository());

        $role = Role::create([
            'name' => 'l'
        ]);


        $service->createUser(new UserDTO(
            id: 0,
            name: 'i',
            email: 'i',
            password: 'i',
            rol_id: $role->id
        ));

        



        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
