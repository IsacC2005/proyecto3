<?php

namespace Tests\Feature;

use App\DTOs\Details\EnrollmentDetailDTO;
use App\DTOs\Summary\EnrollmentDTO;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Repositories\EnrollmentRepository;
use Database\Factories\EnrollmentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnrollmentRepositoryTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $enrollment = new EnrollmentRepository();

        $profesor = Teacher::create([
            'name' => 'John',
            'surname' => 'Doe',
            'phone' => '123458',
        ]);
        
        $matricula = Enrollment::factory()->create(
            [
                'teacher_id' => $profesor->id
            ]
        );


        Enrollment::factory()->count(10)->create(
            [
                'teacher_id' => $profesor->id
            ]
        );

        //$enrollment->create();

        $test = $matricula->teacher;

        $this->assertEquals($profesor->name, $test->name);

        $this->assertDatabaseCount('enrollments', 11);

        $detail = $enrollment->findAll();

        $this->assertInstanceOf(EnrollmentDetailDTO::class, $detail[0]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
