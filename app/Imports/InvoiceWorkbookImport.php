<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InvoiceWorkbookImport implements WithMultipleSheets, WithChunkReading, ShouldQueue
{
    protected array $sheetNames;

    public function __construct(array $sheetNames)
    {
        $this->sheetNames = $sheetNames;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->sheetNames as $name) {
            $sheets[$name] = new InvoiceSheetImport();
        }

        return $sheets;
    }
}
