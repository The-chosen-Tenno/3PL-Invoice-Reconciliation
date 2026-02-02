<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RateCardService;

class RateCardController extends Controller
{
    protected $RateCardService;

    public function __construct(RateCardService $RateCardService)
    {
        $this->RateCardService = $RateCardService;
    }

    public function upload(Request $request)
    {
        return $this->RateCardService->uploadRateCard($request);
    }
}
