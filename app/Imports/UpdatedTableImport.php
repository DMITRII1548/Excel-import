<?php

namespace App\Imports;

use App\Models\ExcelFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;

class UpdatedTableImport implements ToCollection, WithChunkReading, ShouldQueue
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
        // If data already imported
        if ($this->excelFile->importedTable) {
            $contentCollection = json_decode($this->excelFile->importedTable->content);

            $collection = collect($contentCollection)->merge($collection);
            $this->excelFile
                ->importedTable()
                ->update([
                    'content' => $collection,
                ]);
        }

        // If data did't import
        $this->excelFile
            ->importedTable()
            ->firstOrCreate([
                'content' => json_encode($collection),
            ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

