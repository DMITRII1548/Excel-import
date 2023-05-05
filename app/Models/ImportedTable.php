<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ImportedTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'excel_file_id',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(ExcelFile::class);
    }
}
