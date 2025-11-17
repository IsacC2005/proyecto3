<?php

namespace Database\Seeders;

use App\Models\TrainingArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainingAreas = [
            'LENGUAJE, COMUNICACIÓN Y LITERATURA',
            'MATEMÁTICA',
            'AMBIENTE, CIENCIA, TECNOLOGÍA Y PRODUCCIÓN',
            'CIENCIAS SOCIALES, ARTE Y PATRIMONIO',
        ];

        foreach ($trainingAreas as $title) {
            TrainingArea::create([
                'title' => $title
            ]);
        }
    }
}
