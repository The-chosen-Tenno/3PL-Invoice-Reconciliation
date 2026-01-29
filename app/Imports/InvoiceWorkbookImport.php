<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use App\Models\ImportBatch;

class InvoiceWorkbookImport implements WithMultipleSheets, WithChunkReading, WithEvents, ShouldQueue
{
    protected array $sheetNames;
    protected int $batchId;

    public function __construct(array $sheetNames, int $batchId)
    {
        $this->sheetNames = $sheetNames;
        $this->batchId = $batchId;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->sheetNames as $name) {
            $sheets[$name] = new InvoiceSheetImport($this->batchId);
        }

        return $sheets;
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function () {
                ImportBatch::where('id', $this->batchId)->increment('files_done');

                ImportBatch::where('id', $this->batchId)
                    ->whereColumn('files_done', '>=', 'files_total')
                    ->update(['status' => 'done']);
            },
        ];
    }
}
