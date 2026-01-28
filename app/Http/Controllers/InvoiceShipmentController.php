<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\InvoiceShipmentService;

class InvoiceShipmentController extends Controller
{
    protected $InvoiceShipmentService;

    public function __construct(InvoiceShipmentService $InvoiceShipmentService)
    {
        $this->InvoiceShipmentService = $InvoiceShipmentService;
    }

    public function upload(Request $request)
    {
        return $this->InvoiceShipmentService->uploadXlsx($request);
    }
}