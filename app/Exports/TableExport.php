<?php

namespace App\Exports;

use App\Imports\StoredTableImport;
use App\Imports\UpdatedTableImport;
use App\Models\ExcelFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Facades\Excel;

class TableExport implements FromCollection, ShouldQueue
{
    private Collection $table;
    private ExcelFile $file;

    public function __construct(Collection $table, ExcelFile $file)
    {
        $this->table = $table;
        $this->file = $file;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->table;
    }
}
