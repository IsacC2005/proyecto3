<?php

namespace Tests\Feature\Models;

use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class relation_teacher_enrollment extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $teacher = \App\Models\Teacher::factory()->create();

        $enrollment = \App\Models\Enrollment::factory()->create(
            [
                'teacher_id' => $teacher->id
            ]
        );

        $enrollment->teacher()->associate($teacher)->save();


        $response = $this->get("/");

        $response->assertStatus(200);


    }
}
