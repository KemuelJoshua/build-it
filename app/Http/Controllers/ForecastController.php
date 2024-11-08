<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{

    public function predict()
    {
        try {
            // Get the start date (5 years ago)
            $startDate = Carbon::now()->subYears(10);
            $budget = 8000000;
            $sqm = 250;
            
            $lowerLimit = $budget - ($budget * 0.20); 
            $upperLimit = $budget + ($budget * 0.20);

            $lowerLimiSqm = $sqm - ($sqm * 0.20);
            $upperLimiSqm = $sqm + ($sqm * 0.20);

            $data = DB::table('breakdowns')
                ->where('created_at', '>=', $startDate)
                ->whereBetween('budget', [$lowerLimit, $upperLimit])
                ->whereBetween('sqm', [$lowerLimiSqm, $upperLimiSqm])
                ->selectRaw('YEAR(created_at) as year, AVG(sqm) as sqm') 
                ->groupBy(DB::raw('YEAR(created_at)')) 
                ->orderBy('year', 'desc')
                ->get();
    
            $data = $data->map(function($item) {
                return [
                    'sqm' => $item->sqm, 
                    'date' => $item->year, 
                ];
            })->toArray();
    
            $numbers = array_column($data, 'sqm');
            
            $arguments = implode(' ', $numbers);
            
            $output = shell_exec('python "' . public_path('app/arima_forecast.py') . '" ' . $arguments . ' 2>&1');
            
            if ($output === null) {
                return response()->json([
                    'error' => 'There was an issue executing the Python script.',
                ], 500);
            }

            $forecastString = preg_replace('/[^0-9,.-]/', '', $output);
    
            $forecastArray = array_map(function($value) {
                return round(floatval($value), 2);
            }, explode(',', $forecastString));
            
            return response()->json([
                'original_data' => $data,
                'forecast' => $forecastArray,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing the forecast.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    
}