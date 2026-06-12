<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RamadanSearch;
use App\Http\Controllers\RamadanController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateRamadanMainDescription extends Command
{
    protected $signature = 'ramadan:update-main-desc 
                            {--chunk=50 : Number of records to process at once}
                            {--force : Force update all records}
                            {--city= : Update specific city only}';

    protected $description = 'Update Ramadan main descriptions with accurate daily timings from ALADHAN API';

    public function handle()
    {
        $this->info('Starting Ramadan main descriptions update using ALADHAN API...');
        $this->newLine();

        $chunkSize = $this->option('chunk');
        $force = $this->option('force');
        $specificCity = $this->option('city');
        
        $query = RamadanSearch::query();
        
        if ($specificCity) {
            $query->where('city', 'LIKE', "%{$specificCity}%");
            $this->info("Filtering for city: {$specificCity}");
        } elseif (!$force) {
            $query->where('updated_at', '<=', Carbon::now()->subDays(7));
        }
        
        $totalRecords = $query->count();
        
        if ($totalRecords === 0) {
            $this->warn('No records found to update.');
            return 0;
        }
        
        $this->info("Found {$totalRecords} records to update main descriptions.");
        
        if (!$this->confirm('Do you want to continue?', true)) {
            $this->info('Command cancelled.');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($totalRecords);
        $bar->start();
        
        $updatedCount = 0;
        $errorCount = 0;
        
        $controller = app()->make(RamadanController::class);
        
        $query->chunk($chunkSize, function ($records) use ($controller, $bar, &$updatedCount, &$errorCount) {
            foreach ($records as $record) {
                try {
                    $currentYear = date('Y');
                    
                    // Use ALADHAN API for accurate timings (same as controller)
                    $today = $this->getTodayTimesFromAladhan(
                        $record->latitude, 
                        $record->longitude, 
                        $currentYear
                    );
                    
                    $sehriTime = $today['sehri_hanafi'];
                    $iftarTime = $today['iftar_hanafi'];
                    $alternateSehriTime = $today['sehri_jafria'];
                    $alternateIftarTime = $today['iftar_jafria'];
                    $ramadanDay = $today['ramadan_day'];
                    $hijriDate = $today['hijri_date'];
                    $gregorianDate = $today['gregorian_date'];
                    $calculationMethod = $record->calculation_method ?? 'University of Islamic Sciences, Karachi';
                    
                    // Use reflection to access private method
                    $reflectionMethod = new \ReflectionMethod($controller, 'generateSEOMetaData');
                    $reflectionMethod->setAccessible(true);
                    
                    $metaData = $reflectionMethod->invoke(
                        $controller,
                        $record->city,
                        $record->country,
                        $sehriTime,
                        $iftarTime,
                        $ramadanDay,
                        $currentYear,
                        $record->state,
                        $alternateSehriTime,
                        $alternateIftarTime,
                        $hijriDate,
                        $gregorianDate,
                        $calculationMethod
                    );
                    
                    // Update ONLY main description
                    $record->update([
                        'main_description' => $metaData['mainDescription'],
                        'updated_at' => Carbon::now()
                    ]);
                    
                    $updatedCount++;
                    
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error("Failed to update main description for ID {$record->id}: " . $e->getMessage());
                    $this->error("Error on ID {$record->id}: " . $e->getMessage());
                }
                
                $bar->advance();
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Main descriptions update completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Updated', $updatedCount],
                ['Errors', $errorCount],
                ['Total', $totalRecords],
            ]
        );
        
        return 0;
    }
    
    /**
     * Get today's times from ALADHAN API (same as controller and meta command)
     */
    private function getTodayTimesFromAladhan($latitude, $longitude, $year)
    {
        try {
            $ramadanStart = $this->getRamadanStartDate($year);
            $startDate = Carbon::parse($ramadanStart);
            $today = now();
            
            // Calculate which day of Ramadan it is
            $dayNumber = $today->diffInDays($startDate) + 1;
            $dayNumber = min(max($dayNumber, 1), 30);
            
            // Get today's date in format required by API
            $formattedDate = $today->format('d-m-Y');
            
            // Method 1 = University of Islamic Sciences, Karachi
            $method = 1;
            
            $response = Http::get("http://api.aladhan.com/v1/timings/{$formattedDate}", [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'method' => $method
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $timings = $data['data']['timings'] ?? [];
                $dateInfo = $data['data']['date'] ?? [];
                $hijri = $dateInfo['hijri'] ?? [];
                
                // Convert to 12-hour format
                $fajrTime = $this->convertTo12Hour($timings['Fajr'] ?? '05:30');
                $maghribTime = $this->convertTo12Hour($timings['Maghrib'] ?? '18:45');
                
                // Calculate Jafria times (10 minutes earlier for Sehri)
                $sehriJafria = $this->calculateAlternateTime12Hour($fajrTime, -10);
                
                // Get Hijri date
                $hijriDay = $hijri['day'] ?? $dayNumber;
                $hijriMonth = $hijri['month']['en'] ?? 'Ramadan';
                $hijriYear = $hijri['year'] ?? '1447';
                $hijriDate = "{$hijriDay} {$hijriMonth} {$hijriYear} AH";
                
                return [
                    'sehri_hanafi' => $fajrTime,
                    'iftar_hanafi' => $maghribTime,
                    'sehri_jafria' => $sehriJafria,
                    'iftar_jafria' => $maghribTime,
                    'ramadan_day' => $dayNumber,
                    'hijri_date' => $hijriDate,
                    'gregorian_date' => $today->format('F d, Y')
                ];
            } else {
                // Fallback to calculated times if API fails
                return $this->getFallbackTimes($latitude, $dayNumber);
            }
            
        } catch (\Exception $e) {
            Log::error("ALADHAN API failed in main description command: " . $e->getMessage());
            // Fallback to calculated times
            return $this->getFallbackTimes($latitude, $dayNumber);
        }
    }
    
    /**
     * Convert time to 12-hour format
     */
    private function convertTo12Hour($time)
    {
        if (empty($time) || $time == 'N/A') return 'N/A';
        
        try {
            // Remove timezone info if present
            $time = preg_replace('/\s*\([^)]+\)/', '', $time);
            $time = trim($time);
            
            return Carbon::createFromFormat('H:i', $time)->format('h:i A');
        } catch (\Exception $e) {
            try {
                return Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
            } catch (\Exception $e) {
                return $time;
            }
        }
    }
    
    /**
     * Calculate alternate time with offset (12-hour format)
     */
    private function calculateAlternateTime12Hour($baseTime, $minutesOffset)
    {
        if ($baseTime == "N/A") return "N/A";
        try {
            return Carbon::createFromFormat('h:i A', $baseTime)
                ->addMinutes($minutesOffset)
                ->format('h:i A');
        } catch (\Exception $e) {
            return $baseTime;
        }
    }
    
    /**
     * Fallback calculation if API fails
     */
    private function getFallbackTimes($latitude, $dayNumber)
    {
        $lat = floatval($latitude);
        $baseFajr = 5.0 + (abs($lat) * 0.02);
        $baseMaghrib = 18.5 - (abs($lat) * 0.01);
        
        $progress = ($dayNumber - 1) / 29;
        $fajrHour = $baseFajr - ($progress * 0.5);
        $maghribHour = $baseMaghrib + ($progress * 0.5);
        
        $fajrHourInt = floor($fajrHour);
        $fajrMin = round(($fajrHour - $fajrHourInt) * 60);
        $maghribHourInt = floor($maghribHour);
        $maghribMin = round(($maghribHour - $maghribHourInt) * 60);
        
        $sehriTime = sprintf('%02d:%02d', $fajrHourInt, min(59, $fajrMin));
        $iftarTime = sprintf('%02d:%02d', $maghribHourInt, min(59, $maghribMin));
        
        // Convert to 12-hour format
        $sehri12 = $this->convertTo12Hour($sehriTime);
        $iftar12 = $this->convertTo12Hour($iftarTime);
        $sehriJafria12 = $this->calculateAlternateTime12Hour($sehri12, -10);
        
        return [
            'sehri_hanafi' => $sehri12,
            'iftar_hanafi' => $iftar12,
            'sehri_jafria' => $sehriJafria12,
            'iftar_jafria' => $iftar12,
            'ramadan_day' => $dayNumber,
            'hijri_date' => "{$dayNumber} Ramadan 1447 AH",
            'gregorian_date' => now()->format('F d, Y')
        ];
    }
    
    /**
     * Get Ramadan start date for the given year
     */
    private function getRamadanStartDate($year)
    {
        $ramadanDates = [
            '2023' => '2023-03-23',
            '2024' => '2024-03-11',
            '2025' => '2025-03-01',
            '2026' => '2026-02-18',
            '2027' => '2027-02-08',
        ];
        
        return $ramadanDates[$year] ?? $ramadanDates['2026'];
    }
}