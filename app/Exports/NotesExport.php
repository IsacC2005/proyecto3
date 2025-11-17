<?php

namespace App\Exports;

use App\Repositories\Interfaces\LearningProjectInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotesExport implements FromView, WithColumnWidths, WithStyles
{
    public function __construct(private $data) {}

    public function view(): View
    {

        return view('test', [
            'data' => $this->data
        ]);
    }


    public function columnWidths(): array
    {
        $widths = [
            'A' => 30,
        ];

        $currentColIndex = 1;

        foreach ($this->data['classes'] as $referent) {
            foreach ($referent['indicators'] as $indicator) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($currentColIndex + 1);

                $widths[$colLetter] = 10;
                $currentColIndex++;
            }
        }

        return $widths;
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Aplicar estilo a la fila de los indicadores (asumimos que es la fila 2)
        $styleArray = [
            'alignment' => [
                // Horizontal: Alinear al centro
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                // Vertical: Alinear al centro
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                // Ajustar texto si es necesario (wrap text)
                'wrapText' => true,
            ],
            'font' => [
                'bold' => true,
            ],
        ];

        // Rango: La fila 2 completa.
        $sheet->getStyle('2')->applyFromArray($styleArray);

        // 2. Aplicar alineación a las celdas de NOTAS (cuerpo de la tabla)
        // Esto asume que el reporte tiene hasta 100 filas, ajusta el rango si es necesario.
        $sheet->getStyle('B3:ZZ100') // Desde la columna B, fila 3 hasta ZZ100
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Puedes agregar más estilos aquí si lo necesitas.
    }
}
