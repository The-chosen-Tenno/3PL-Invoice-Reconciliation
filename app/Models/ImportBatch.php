<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportBatch extends Model
{
    protected $fillable = [
        'files_total',
        'files_done',
        'rows_inserted',
        'status',
        'error',
    ];
}
