<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExcelFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'user_id',
    ];


    public function importedTable(): HasOne
    {
        return $this->hasOne(ImportedTable::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
