<?php

namespace Database\Seeders;

use App\Models\Qualitie;
use App\Models\QualitieType;
use Illuminate\Database\Seeder;

class QualitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Social y Emocional',
            'Responsabilidad y Autonomía',
            'Actitud hacia el Aprendizaje',
        ];

        $idsTypes = [];

        foreach ($types as $typeName) {
            $type = QualitieType::firstOrCreate([
                'name' => $typeName
            ]);
            $idsTypes[$typeName] = $type->id;
        }

        $cualidades = [
            // CUALIDADES SOCIALES Y EMOCIONALES
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Amable'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Respetuoso/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Colaborador/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Solidario/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Empático/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Educado/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Social y Emocional'],
                'name' => 'Compañerista'
            ],

            // CUALIDADES DE RESPONSABILIDAD Y AUTONOMÍA
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Responsable'
            ],
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Organizado/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Autónomo/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Puntual'
            ],
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Perseverante'
            ],
            [
                'qualitie_type_id' => $idsTypes['Responsabilidad y Autonomía'],
                'name' => 'Diligente'
            ],

            // CUALIDADES DE ACTITUD HACIA EL APRENDIZAJE
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Curioso/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Interesado/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Participativo/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Reflexivo/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Creativo/a'
            ],
            [
                'qualitie_type_id' => $idsTypes['Actitud hacia el Aprendizaje'],
                'name' => 'Motivado/a'
            ],
        ];

        Qualitie::insert($cualidades);
    }
}
