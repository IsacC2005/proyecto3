<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\VerticalJc;
use PhpOffice\PhpWord\Style\Table; // Necesario para definir estilos de tabla complejos
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentGeneratorController extends Controller
{
    /**
     * Genera el "Boletín Informativo de los Aprendizajes" basado en la imagen proporcionada.
     * Utiliza tablas para replicar la estructura de la cuadrícula.
     * * NOTA: Este método está diseñado para ser un controlador de prueba con datos fijos.
     * * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateDocx(Request $request)
    {
        // 1. Instanciar PHPWord
        $phpWord = new PhpWord();

        $templatePath = storage_path('app/templates/template.docx');

        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found at: ' . $templatePath], 500);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        try {
            // 2. Instanciar el TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);

            // --- DATOS FIJOS PARA PRUEBA (Estos vendrían de tu DB) ---
            $data = [
                'teacherName' => 'YURAIMA PEREZ',
                'studentName' => 'SANCHEZ CAMPOS ABEL ISAI',
                'section' => '3 B',
                'schoolId' => '11617081892',
                'schoolYear' => '2024-2025',
                'projectTitle' => 'Hola aqui va el nombre del proyecto ',
                'schoolMoment' => 'TERCERO',
                'assistance' => '37',
                'absence' => '13',
                'average' => 'C',
                // Texto largo de los logros.
                'content' => 'Es un estudiante participativo, amistoso y educado. Lee fluido de forma comprensiva, escribe legible y con pulcritud, clasifica las palabras según el número de sílabas, realiza cuento utilizando recursos literarios. Resuelve ejercicios de adición, sustracción con números naturales y decimales, representa gráficamente fracciones. Dibuja las etapas de reproducción de las plantas, clasifica materiales naturales y artificiales, elabora proyecto de vida...',
                'suggestions' => 'Te animo a que practiques la tabla de multiplicar, operaciones básicas matemáticas de multiplicación y división con números naturales y decimales.',

            ];
            // -------------------------------------------------------------

            foreach ($data as $key => $value) {
                // Aseguramos que los valores sean cadenas. PHPWord requiere cadenas.
                $templateProcessor->setValue($key, (string) $value);
            }

            // NOTA IMPORTANTE: Si la plantilla usa tablas, también puedes clonar filas
            // con TemplateProcessor::cloneRow('marco_tabla', $count), pero para el boletín
            // con estructura fija, los marcadores de posición simples son suficientes.

            // 4. Guardar el documento generado en una ubicación temporal
            $fileName = 'boletin_procesado_' . time() . '.docx';
            $tempPath = tempnam(sys_get_temp_dir(), 'phpword_template');

            $templateProcessor->saveAs($tempPath);

            // 5. Preparar la respuesta de descarga
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ];

            // 6. Forzar la descarga del archivo
            return Response::download($tempPath, $fileName, $headers)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Manejo de excepciones (por ejemplo, si la plantilla está corrupta o no se puede escribir)
            return response()->json(['error' => 'Error al generar el documento: ' . $e->getMessage()], 500);
        }
    }
}
