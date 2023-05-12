<?php

namespace App\Imports;

use App\Events\TableImported;
use App\Http\Resources\File\ContentFileChunkResource;
use App\Http\Resources\File\ContentFileResource;
use App\Jobs\SendImportedTable;
use App\Models\ExcelFile;
use App\Models\ImportedTable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use PhpParser\Error;
use PhpParser\ErrorHandler;

class StoredTableImport implements WithEvents, ToCollection, WithChunkReading, ShouldQueue
{
    private ExcelFile $excelFile;

    public function __construct(ExcelFile $excelFile)
    {
        $this->excelFile = $excelFile;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterImport::class => function (AfterImport $event) {
                $this->excelFile = ExcelFile::where('id', $this->excelFile->id)->first();
                SendImportedTable::dispatch($this->excelFile);
            },
        ];
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
