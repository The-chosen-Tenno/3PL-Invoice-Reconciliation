<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InvoiceService;

class InvoiceController extends Controller
{
    protected $InvoiceService;
    public function __construct(InvoiceService $InvoiceService)
    {
        $this->InvoiceService = $InvoiceService;
    }
    public function upload(Request $request)
    {
        return $this->InvoiceService->uploadInvoice($request);
    }
}
