<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateCardSheet extends Model
{
    protected $table = 'rate_card_sheets';

    protected $fillable = [
        'rate_card_version',
        'sheet_name',
        'data_json'
    ];
    
    protected $casts = [
        'data_json' => 'array'
    ];

    use HasFactory;
}
