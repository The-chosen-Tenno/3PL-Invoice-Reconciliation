<?php

namespace App\Http\Services;

use App\Models\Invoice;
use App\Models\Order;
use Smalot\PdfParser\Parser;

class InvoiceService
{
    public function uploadInvoice($request)
    {
        if (!$request->hasFile('invoices_pdf')) {
            return response()->json(['error' => 'No files uploaded'], 422);
        }

        $files = $request->file('invoices_pdf');
        $results = [];
        $parser = new Parser();

        foreach ($files as $pdf) {
            if ($pdf->getClientMimeType() !== 'application/pdf' || $pdf->getSize() > 10 * 1024 * 1024) {
                $results[] = ['file' => $pdf->getClientOriginalName(), 'status' => 'skipped', 'reason' => 'Invalid PDF'];
                continue;
            }

            try {
                $text = $parser->parseFile($pdf->getPathname())->getText();

                // Fixed structure parser
                $parsed = $this->parseInvoice($text);

                // Save invoice
                $invoice = Invoice::create([
                    'invoice_name' => $pdf->getClientOriginalName(),
                    'content'      => $text,
                    'status'       => $parsed['order_id'] ? 'parsed' : 'parsed_raw',
                    'invoice_id'   => $parsed['invoice_id'],
                    'order_id'     => $parsed['order_id'],
                    'final_price'  => $parsed['final_price'],
                ]);

                // Optional: compare immediately
                if ($parsed['order_id']) {
                    $this->compareWithOrders($invoice);
                }

                $results[] = ['file' => $pdf->getClientOriginalName(), 'status' => 'success'];
            } catch (\Throwable $e) {
                Invoice::create([
                    'invoice_name' => $pdf->getClientOriginalName(),
                    'content'      => null,
                    'status'       => 'failed',
                ]);

                $results[] = ['file' => $pdf->getClientOriginalName(), 'status' => 'failed', 'error' => 'Parsing failed'];
            }
        }

        return response()->json(['total_files' => count($files), 'results' => $results]);
    }

    private function parseInvoice($text)
    {
        // Fixed structure parsing
        preg_match('/Invoice ID:\s*(\S+)/', $text, $invoiceId);
        preg_match('/Order ID:\s*(\S+)/', $text, $orderId);
        preg_match('/Final Price:\s*(\d+(\.\d+)?)/', $text, $price);

        return [
            'invoice_id'  => $invoiceId[1] ?? null,
            'order_id'    => $orderId[1] ?? null,
            'final_price' => isset($price[1]) ? floatval($price[1]) : null,
        ];
    }

    public function compareWithOrders(Invoice $invoice)
    {
        if (!$invoice->order_id) return ['matched' => false];

        $order = Order::where('order_id', $invoice->order_id)->first();
        if (!$order) return ['matched' => false];

        $difference = $invoice->final_price - $order->expected_price;
        $invoice->status = abs($difference) > 2 ? 'discrepancy' : 'matched';
        $invoice->save();

        return ['matched' => true, 'difference' => $difference];
    }
}
