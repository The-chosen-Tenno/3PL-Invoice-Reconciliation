<?php

namespace App\Http\Controllers;

use App\Models\ImportBatch;

class ImportBatchController extends Controller
{
    public function progress(ImportBatch $batch)
    {
        return response()->json([
            'files_total'   => $batch->files_total,
            'files_done'    => $batch->files_done,
            'rows_inserted' => $batch->rows_inserted,
            'status'        => $batch->status,
            'error'         => $batch->error,
        ]);
    }
}
