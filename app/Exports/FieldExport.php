<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class FieldExport implements WithMapping
{
    public function map($row): array
    {
        return [];
    }
}
