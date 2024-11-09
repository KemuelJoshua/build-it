<?php

namespace App\Http\Controllers;

use App\Models\BreakDown;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class ForecastController extends Controller
{

    public function predict(Request $request)
    {
        try {
            // Get the start date (5 years ago)
            $startDate = Carbon::now()->subYears(10);

            $validator = Validator::make($request->all(), [
                'budget' => 'required|numeric|min:0',
                'sqm' => 'required|numeric|min:50|max:300',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Get validated data
            $budget = $request->input('budget');
            $sqm = $request->input('sqm');

            $lowerLimiSqm = $sqm - ($sqm * 0.30);
            $upperLimiSqm = $sqm + ($sqm * 0.30);

            $data = DB::table('breakdowns')
                ->where('created_at', '>=', $startDate)
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
            
            $output = shell_exec('python3 "' . public_path('app/arima_forecast.py') . '" ' . $arguments . ' 2>&1');
            
            if ($output === null) {
                return response()->json([
                    'error' => 'There was an issue executing the Python script.',
                ], 500);
            }

            $forecastString = preg_replace('/[^0-9,.-]/', '', $output);
    
            $forecastArray = array_map(function($value) {
                return round(floatval($value), 2);
            }, explode(',', $forecastString));
            
            $currentYear = Carbon::now()->year;

            $years = [];
            for ($i = 1; $i <= 10; $i++) {
                $years[] = $currentYear + $i;
            }

            $breakdown = BreakDown::create([
                'sqm' => $sqm,
                'budget' => $budget
             ]);

            return response()->json([
                'original_data' => $breakdown,
                'years' => $years,
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
