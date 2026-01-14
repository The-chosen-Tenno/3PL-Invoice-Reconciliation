<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
        'invoice_name',   // PDF filename
        'content',        // raw extracted text
        'status',         // raw | empty | failed | skipped | matched | discrepancy
        'invoice_id',     // structured
        'order_id',       // structured
        'final_price',    // structured
    ];

    protected $casts = [
        'parsed_data' => 'array', // so JSON auto-converts to array
    ];

    use HasFactory;
}
