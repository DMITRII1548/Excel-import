<?php

namespace App\Imports;

use App\Models\ExcelFile;
use App\Models\ImportedTable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TableImport implements ToCollection
{
    private ExcelFile $excelFile;

    public function __construct(ExcelFile $excelFile)
    {
        $this->excelFile = $excelFile;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        $this->excelFile->importedTable()->firstOrCreate([
            'content' => json_encode($collection),
        ]);
    }
}
