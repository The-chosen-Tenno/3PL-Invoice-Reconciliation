<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateCardVersion extends Model
{
    protected $table = 'rate_card_versions';

    protected $fillable = [
        'source_file_name',
        'file_name',
        'status',
        'effective_from',
        'effective_to'
    ];
    use HasFactory;
}
