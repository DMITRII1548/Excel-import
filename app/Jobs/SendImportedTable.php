<?php

namespace App\Jobs;

use App\Events\TableImported;
use App\Http\Resources\File\ContentFileChunkResource;
use App\Http\Resources\File\ContentFileResource;
use App\Models\ExcelFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendImportedTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ExcelFile $file;

    /**
     * Create a new job instance.
     */
    public function __construct(ExcelFile $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        collect(ContentFileResource::make($this->file->importedTable)
            ->resolve()['content'])
        ->chunk(1)
            ->each(function ($chunk): void {
                $this->file->importedTable->content = $chunk;
                $data = ContentFileChunkResource::make($this->file->importedTable)->resolve();

                broadcast(new TableImported($this->file, $data));
            });
    }
}
