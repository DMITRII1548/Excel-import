<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class TableExport implements FromCollection
{
    private Collection $table;

    public function __construct(Collection $table)
    {
        $this->table = $table;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->table;
    }
}
