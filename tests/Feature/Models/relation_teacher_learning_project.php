<?php

namespace Tests\Feature\Models;

use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class relation_teacher_learning_project extends TestCase
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

        $learningProject = \App\Models\LearningProject::factory()->create(
            [
                'enrollment_id' => $enrollment->id,
                'teacher_id' => $teacher->id
            ]
        );

        $teacher2 = \app\Models\Teacher::factory()->create();

        $enrollment->teacher()->associate($teacher2)->save();

        $this->assertEquals($teacher2->id, $enrollment->teacher->id);

        $this->assertEquals($teacher->id, $learningProject->teacher->id);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
