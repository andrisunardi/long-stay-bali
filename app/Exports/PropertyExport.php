<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PropertyExport implements FromView, ShouldAutoSize, WithDrawings
{
    use Exportable;

    public object $properties;

    public function __construct(object $properties)
    {
        $this->properties = $properties;
    }

    public function drawings(): array
    {
        $drawings = [];

        foreach ($this->properties as $index => $property) {
            if (! $property->image?->image_url) {
                continue;
            }

            $drawing = new Drawing;
            $drawing->setName($property->name);
            $drawing->setDescription($property->name);
            $drawing->setPath($property->image->image_url);
            $drawing->setWidth(100);
            $drawing->setHeight(70);
            $drawing->setCoordinates('G'.($index + 6));

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function view(): View
    {
        return view('excel.property', [
            'properties' => $this->properties,
        ]);
    }
}
