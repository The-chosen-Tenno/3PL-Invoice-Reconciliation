<?php

namespace App\Imports;

use App\Models\InvoiceShipment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InvoiceSheetImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function chunkSize(): int
    {
        return 1000;
    }

    public function collection(Collection $rows)
    {
        $insert = [];

        foreach ($rows as $row) {
            $insert[] = [
                'tracking_number' => $row['tracking_number'] ?? null,
                'carrier' => $row['carrier'] ?? 'UNKNOWN',
                'shipping_method' => $row['shipping_method'] ?? null,
                'warehouse' => $row['warehouse'] ?? null,
                'country' => $row['country'] ?? null,
                'state' => $row['state'] ?? null,
                'zip' => $row['zip'] ?? null,
                'weight_lb' => $row['weight_lb'] ?? null,
                'length_in' => $row['length_in'] ?? null,
                'width_in' => $row['width_in'] ?? null,
                'height_in' => $row['height_in'] ?? null,
                'carrier_fee' => $row['carrier_fee'] ?? null,
                'expected_fee' => null,
                'fee_diff' => null,
                'carrier_fee_status' => 'unchecked',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($insert) {
            InvoiceShipment::insert($insert);
        }
    }
}
