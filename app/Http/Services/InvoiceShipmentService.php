<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvoiceWorkbookImport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ImportBatch;

class InvoiceShipmentService
{
    public function uploadXlsx(Request $request)
    {
        $request->validate([
            'invoices_xlsx.*' => 'required|file|mimes:xlsx,xls|max:15360',
        ]);

        $files = $request->file('invoices_xlsx');

        $batch = ImportBatch::create([
            'files_total'   => count($files),
            'files_done'    => 0,
            'rows_inserted' => 0,
            'status'        => 'queued',
        ]);

        foreach ($files as $file) {
            $path = $file->store('invoice_xlsx');
            $fullPath = storage_path("app/{$path}");
            $spreadsheet = IOFactory::load($fullPath);
            $sheetNames  = $spreadsheet->getSheetNames();
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            Excel::queueImport(
                new InvoiceWorkbookImport($sheetNames, $batch->id),
                $fullPath
            )->allOnQueue('imports');
        }

        return response()->json([
            'message'  => 'Files queued for import',
            'batch_id' => $batch->id,
        ]);
    }
}
