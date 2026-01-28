<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvoiceWorkbookImport;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InvoiceShipmentService
{
    public function uploadXlsx(Request $request)
    {
        $request->validate([
            'invoices_xlsx.*' => 'required|file|mimes:xlsx,xls|max:15360',
        ]);

        foreach ($request->file('invoices_xlsx') as $file) {
            $path = $file->store('invoice_xlsx');
            $fullPath = storage_path("app/{$path}");

            // ✅ THIS ALWAYS EXISTS
            $spreadsheet = IOFactory::load($fullPath);
            $sheetNames = $spreadsheet->getSheetNames();

            // free memory (IMPORTANT)
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            Excel::queueImport(
                new InvoiceWorkbookImport($sheetNames),
                $fullPath
            )->allOnQueue('imports');
        }

        return response()->json([
            'message' => 'Files queued for import'
        ]);
    }
}
