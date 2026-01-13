<?php

namespace App\Http\Services;

use Smalot\PdfParser\Parser;
use App\Models\Invoice;

class InvoiceService
{
    public function uploadInvoice($request)
    {
        $request->validate(['invoices_pdf.*' => 'required|file|mimes:pdf|max:10240',]);
        $results = [];
        $parser = new Parser();
        foreach ($request->file('invoices_pdf') as $pdf) {
            try {
                $text = $parser->parseFile($pdf->getPathname())->getText();
                Invoice::create(['invoice_name' => $pdf->getClientOriginalName(), 'content' => $text, 'status' => 'parsed']);
                $results[] = ['file' => $pdf->getClientOriginalName(), 'status' => 'success'];
            } catch (\Exception $e) {
                $results[] = ['file' => $pdf->getClientOriginalName(), 'status' => 'failed', 'error' => $e->getMessage()];
            }
        }
        return response()->json($results);
    }
}
