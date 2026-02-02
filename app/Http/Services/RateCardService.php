<?php

namespace App\Http\Services;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\RateCardVersion;
use App\Models\RateCardSheet;

class RateCardService
{
    public function uploadRateCard($request)
    {
        $request->validate([
            'rate_card_xlsx' => 'required|file|mimes:xls,xlsx'
        ]);

        $file = $request->file('rate_card_xlsx');
        $originalName = $file->getClientOriginalName();

        $path = $file->store('rate_card_xlsx');
        $newRateCard = RateCardVersion::create([
            'file_name' => $path,
            'source_file_name' => $originalName,
        ]);

        $fullPath = storage_path("app/{$path}");
        $spreadSheet = IOFactory::load($fullPath);
        $sheetNames = $spreadSheet->getSheetNames();

        foreach ($sheetNames as $sheetName) {

            $worksheet = $spreadSheet->getSheetByName($sheetName);
            $sheetData = $worksheet->toArray(null, true, true, true);
            $cleanData = [];
            foreach ($sheetData as $row) {
                $filteredRow = array_filter($row, function ($value) {
                    return $value !== null && $value !== '';
                });

                if (!empty($filteredRow)) {
                    $cleanData[] = $filteredRow;
                }
            }

            RateCardSheet::create([
                'rate_card_version' => $newRateCard->id,
                'sheet_name' => $sheetName,
                'data_json' => json_encode($cleanData, JSON_UNESCAPED_UNICODE),
            ]);
        }

        $spreadSheet->disconnectWorksheets();
        unset($spreadSheet);
        try {
            RateCardVersion::where('status', 'active')
                ->update([
                    'status' => 'archived',
                    'effective_to' => Carbon::today()
                ]);

            $newRateCard->update([
                'status' => 'active',
                'effective_from' => Carbon::today()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rate card uploaded with ' . count($sheetNames) . ' sheets',
                'version_id' => $newRateCard->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Uploaded but not activated: ' . $e->getMessage(),
                'version_id' => $newRateCard->id,
                'status' => 'draft'
            ]);
        }
    }
}