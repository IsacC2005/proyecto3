<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Teacher;
use App\Models\User;

class UserProfessorRelationshipTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_professor_relationship(): void
    {
        $profesor = Teacher::create([
            'name' => 'John',
            'surname' => 'Doe',
            'phone' => '1234567890',
        ]);
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
        $profesor->user()->save($user);

        $this->assertDatabaseHas('users',[
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'userable_type' => Teacher::class,
            'userable_id' => $profesor->id,
        ]);

        $this->assertDatabaseHas('teachers', [
            'name' => 'John',
            'surname' => 'Doe',
            'phone' => '1234567890',
            'id' => $profesor->id
        ]);

        $retrivedUser = User::find($user->id);
        $this->assertInstanceOf(Teacher::class, $retrivedUser->userable);
    }
}
