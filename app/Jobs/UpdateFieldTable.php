<?php

namespace App\Jobs;

use App\Models\ExcelFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class UpdateFieldTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $address;
    private string $valueField;
    private ExcelFile $file;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $address,
        string $valueField,
        ExcelFile $file
    ) {
        $this->address = $address;
        $this->valueField = $valueField;
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $spreadsheet = IOFactory::load(public_path('/storage/' . $this->file->path));
        $cell = $spreadsheet->getActiveSheet()->getCell($this->address);
        $cell->setValue($this->valueField);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(public_path('/storage/' . $this->file->path));
    }
}
