<?php

namespace Database\Seeders;

use App\Models\Representative;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::factory()->count(100)->create();
        // for($i = 0; $i <= 10; $i++ ){
        //     $representative = Representative::factory()->create();
        //     for($ix = 0; $ix <= 2; $ix++){
        //         $student = Student::factory()->create([
        //             'representative_id' => $representative->id
        //         ]);
        //     }
        // }
    }
}
