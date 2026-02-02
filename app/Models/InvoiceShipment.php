<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceShipment extends Model
{
    protected $table = 'invoice_shipments';

    protected $fillable = [
        'tracking_number',
        'carrier',
        'shipping_method',
        'warehouse',
        'country',
        'state',
        'zip',
        'weight_lb',
        'length_in',
        'width_in',
        'height_in',
        'carrier_fee',
        'expected_fee',
        'fee_diff',
        'carrier_fee_status',
        'raw_data',
    ];

    protected $casts = [
        'weight_lb' => 'decimal:3',
        'length_in' => 'decimal:2',
        'width_in' => 'decimal:2',
        'height_in' => 'decimal:2',
        'carrier_fee' => 'decimal:2',
        'expected_fee' => 'decimal:2',
        'fee_diff' => 'decimal:2',
    ];
}
