<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\RamadanSearch;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RamadanController extends Controller
{
    public function index()
    {
        $recentSearches = RamadanSearch::latest()->take(5)->get(['city', 'country', 'created_at']);
        return view('ramadan_index', compact('recentSearches'));
    }

    public function showBySlug($citySlug, $lang = null)
    {
        if (strpos($citySlug, '/') !== false) {
            $parts = explode('/', $citySlug);
            $citySlug = end($parts);
        }
        
        $city = str_replace('-', ' ', $citySlug);
        
        $city = preg_replace_callback('/\b(al|el)\b/i', function($matches) {
            return ucfirst(strtolower($matches[0]));
        }, $city);
        
        $slug = strtolower(str_replace(' ', '-', $city . '-ramadan-timings'));
        
        // ✅ PEHLE CHECK: Slug exist karta hai?
        $existingRamadan = RamadanSearch::where('slug', $slug)->first();
        
        $now = now();
        $currentYear = date('Y');
        
        $calculationMethods = [
            'University of Islamic Sciences, Karachi',
            'Islamic Society of North America (ISNA)',
            'Muslim World League',
            'Egyptian General Authority of Survey',
            'Umm Al-Qura University, Makkah',
            'Dubai (Umm Al-Qura method)'
        ];
        
        // ✅ AGAR SLUG EXIST KARTA HAI - SIRF VIEW RETURN KARO, QUERY NAHI
        if ($existingRamadan) {
            // Use ALADHAN API for accurate timings
            $ramadanTimes = $this->getRamadanTimesFromAladhan(
                $existingRamadan->city,
                $existingRamadan->country,
                $existingRamadan->latitude,
                $existingRamadan->longitude
            );
            
            // Get today's times consistently
            $today = $this->getTodayTimes($ramadanTimes);
            
            $methodIndex = (strlen($existingRamadan->city) + strlen($existingRamadan->country)) % count($calculationMethods);
            $calculationMethod = $calculationMethods[$methodIndex];
            
            // Get cities in same country for sidebar/navigation
            $citiesInCountry = $this->getCachedCitiesInCountry($existingRamadan->country, $existingRamadan->city);
            
            // ✅ YAHAN SE META DATA DB SE LENA HAI - GENERATE NAHI KARNA
            return view('ramadan_timings', [
                'city' => $existingRamadan->city,
                'country' => $existingRamadan->country,
                'state' => $existingRamadan->state,
                'latitude' => $existingRamadan->latitude,
                'longitude' => $existingRamadan->longitude,
                'ramadanTimes' => $ramadanTimes,
                // ✅ DB SE META DATA
                'metaTitle' => $existingRamadan->meta_title,
                'metaDescription' => $existingRamadan->meta_description,
                'metaKeywords' => $existingRamadan->meta_keywords,
                'mainDescription' => $existingRamadan->main_description,
                'sehriTime' => $today['sehri_hanafi'],
                'iftarTime' => $today['iftar_hanafi'],
                'alternateSehriTime' => $today['sehri_jafria'],
                'alternateIftarTime' => $today['iftar_jafria'],
                'ramadanDay' => $today['ramadan_day'],
                'hijriDate' => $today['hijri_date'],
                'gregorianDate' => $today['gregorian_date'],
                'currentYear' => $currentYear,
                'citiesInCountry' => $citiesInCountry,
                'calculationMethod' => $calculationMethod
            ]);
        }
        
        // ✅ AGAR SLUG EXIST NAHI KARTA - TAB GENERATE KARO AUR DB MEIN SAVE KARO
        $location = $this->getPreciseLocation($city);
        
        $coordinates = $this->getCoordinates($city);
        
        if (!$coordinates) {
            return redirect('/ramadan')->with('error', 'Failed to fetch location coordinates');
        }
        
        $timezone = $this->getTimezone($coordinates['lat'], $coordinates['lng']);
        
        // Use ALADHAN API for accurate timings
        $ramadanTimes = $this->getRamadanTimesFromAladhan(
            $city,
            $location['country'],
            $coordinates['lat'],
            $coordinates['lng']
        );
        
        // Get today's times consistently
        $today = $this->getTodayTimes($ramadanTimes);
        
        $methodIndex = (strlen($city) + strlen($location['country'])) % count($calculationMethods);
        $calculationMethod = $calculationMethods[$methodIndex];
        
        // Get cities in same country for sidebar/navigation
        $citiesInCountry = $this->getCachedCitiesInCountry($location['country'], $city);
        
        // ✅ SEO META DATA GENERATE KARO (SIRF PEHLI BAR)
        $metaData = $this->generateSEOMetaData(
            $city, 
            $location['country'], 
            $today['sehri_hanafi'], 
            $today['iftar_hanafi'], 
            $today['ramadan_day'], 
            $currentYear, 
            $location['state'], 
            $today['sehri_jafria'], 
            $today['iftar_jafria'],
            $today['hijri_date'],
            $today['gregorian_date'],
            $calculationMethod
        );
        
        // ✅ CREATE RECORD IN DATABASE - META FIELDS KE SAATH
        $ramadanSearch = RamadanSearch::create([
            'city' => $city,
            'state' => $location['state'],
            'country' => $location['country'],
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'timezone' => $timezone,
            'slug' => $slug,
            // ✅ META FIELDS DB MEIN SAVE KARO
            'meta_title' => $metaData['metaTitle'],
            'meta_description' => $metaData['metaDescription'],
            'meta_keywords' => $metaData['metaKeywords'],
            'main_description' => $metaData['mainDescription'],
        ]);
        
        return view('ramadan_timings', [
            'city' => $city,
            'country' => $location['country'],
            'state' => $location['state'],
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'ramadanTimes' => $ramadanTimes,
            // ✅ NAYE GENERATED META DATA VIEW KO BHEJO
            'metaTitle' => $metaData['metaTitle'],
            'metaDescription' => $metaData['metaDescription'],
            'metaKeywords' => $metaData['metaKeywords'],
            'mainDescription' => $metaData['mainDescription'],
            'sehriTime' => $today['sehri_hanafi'],
            'iftarTime' => $today['iftar_hanafi'],
            'alternateSehriTime' => $today['sehri_jafria'],
            'alternateIftarTime' => $today['iftar_jafria'],
            'ramadanDay' => $today['ramadan_day'],
            'hijriDate' => $today['hijri_date'],
            'gregorianDate' => $today['gregorian_date'],
            'currentYear' => $currentYear,
            'citiesInCountry' => $citiesInCountry,
            'calculationMethod' => $calculationMethod
        ]);
    }

    // ✅ SEO META DATA GENERATOR - FARJ AUR MAGHRIB KI JAGHA SEHRI AUR IFTAR USE KIYA
    private function generateSEOMetaData($city, $country, $sehriTime, $iftarTime, $ramadanDay, $currentYear, $state = null, $alternateSehriTime = null, $alternateIftarTime = null, $hijriDate = null, $gregorianDate = null, $calculationMethod = null)
    {
        $todayDate = now()->format('F d, Y');
        $formattedGregorian = $gregorianDate ? Carbon::parse($gregorianDate)->format('F j, Y') : $todayDate;
        $hijriDisplay = $hijriDate ?? 'Ramadan 1447 AH';
        
        // Calculate fasting hours using SEHRI and IFTAR (not Fajr/Maghrib)
        try {
            $sehriCarbon = Carbon::createFromFormat('h:i A', $sehriTime);
            $iftarCarbon = Carbon::createFromFormat('h:i A', $iftarTime);
            $fastingHours = $iftarCarbon->diff($sehriCarbon)->format('%h hours %i minutes');
            
            $altSehriCarbon = Carbon::createFromFormat('h:i A', $alternateSehriTime);
            $altFastingHours = $iftarCarbon->diff($altSehriCarbon)->format('%h hours %i minutes');
        } catch (\Exception $e) {
            $fastingHours = "13 hours 15 minutes";
            $altFastingHours = "13 hours 25 minutes";
        }
        
        // ============== MAIN DESCRIPTION BLOCKS - SEHRI aur IFTAR use kiya gaya hai ==============
        $mainDescriptionBlocks = [

    // Block 1 - Complete Overview
    '<h1 class="h3 mb-3">:city Ramadan Timings :currentYear – Complete Sehri & Iftar Schedule</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>📍 Location:</strong> :city, :country</p>
                    <p><strong>📅 Gregorian Date:</strong> :gregorian</p>
                    <p><strong>🕌 Hijri Date:</strong> :hijri</p>
                </div>
                <div class="col-md-6">
                    <p><strong>📆 Ramadan Day:</strong> :ramadanDay of 30</p>
                    <p><strong>🧮 Calculation Method:</strong> :method</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h4 mb-3">Today\'s Sehri and Iftar Timings for :city</h2>
    
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>School of Thought</th>
                    <th>Sehri Time (End of Suhoor)</th>
                    <th>Iftar Time</th>
                    <th>Fasting Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Fiqa Hanafi</strong></td>
                    <td><strong>:sehri</strong></td>
                    <td><strong>:iftar</strong></td>
                    <td>:fastingHours</td>
                </tr>
                <tr>
                    <td><strong>Fiqa Jafria (Shia)</strong></td>
                    <td><strong>:altSehri</strong> (10 mins earlier)</td>
                    <td><strong>:altIftar</strong></td>
                    <td>:altFastingHours</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="alert alert-info">
        <strong>Note:</strong> Sehri time is the end time for Suhoor meal. Iftar time is the time to break your fast.
    </div>',

    // Block 2 - Focus on Sehri and Iftar
    '<h1 class="h3 mb-3">:city Ramadan :currentYear – Accurate Sehri & Iftar Times</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4">Today\'s Schedule for :city (:gregorian)</h2>
            <p><strong>Hijri Date:</strong> :hijri | <strong>Ramadan Day:</strong> :ramadanDay</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Fiqa Hanafi Timings</h3>
                </div>
                <div class="card-body">
                    <p><strong>Sehri Ends:</strong> :sehri</p>
                    <p><strong>Iftar Time:</strong> :iftar</p>
                    <p><strong>Fasting Duration:</strong> :fastingHours</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="h5 mb-0">Fiqa Jafria Timings</h3>
                </div>
                <div class="card-body">
                    <p><strong>Sehri Ends:</strong> :altSehri (10 mins earlier)</p>
                    <p><strong>Iftar Time:</strong> :altIftar</p>
                    <p><strong>Fasting Duration:</strong> :altFastingHours</p>
                </div>
            </div>
        </div>
    </div>

    <p>Both Hanafi and Jafria timings are provided to serve the entire Muslim community in :city. The complete 30-day Ramadan calendar is available below.</p>',

    // Block 3 - Fiqh Comparison with Sehri/Iftar focus
    '<h1 class="h3 mb-3">:city Ramadan Timings :currentYear – Hanafi & Jafria Schedules</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4">Today: :gregorian (:hijri) – Day :ramadanDay of Ramadan</h2>
            <p>Accurate Sehri and Iftar times for :city, :country using :method calculation method.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Fiqa Hanafi</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Sehri Time:</strong> :sehri</li>
                        <li class="mb-2"><strong>Iftar Time:</strong> :iftar</li>
                        <li class="mb-2"><strong>Fasting Duration:</strong> :fastingHours</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h3 class="h5 mb-0">Fiqa Jafria</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Sehri Time:</strong> :altSehri (10 mins earlier)</li>
                        <li class="mb-2"><strong>Iftar Time:</strong> :altIftar</li>
                        <li class="mb-2"><strong>Fasting Duration:</strong> :altFastingHours</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <p>The Jafria school ends Sehri 10 minutes earlier as a precautionary measure. Both timings are provided for the convenience of all Muslims in :city.</p>',

    // Block 4 - Geographic Details
    '<h1 class="h3 mb-3">:city Ramadan :currentYear – Precise Sehri & Iftar Times</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4">Location Parameters for :city</h2>
            <table class="table table-bordered table-sm">
                <tr><th>Latitude</th><td>:lat°</td></tr>
                <tr><th>Longitude</th><td>:lng°</td></tr>
                <tr><th>Timezone</th><td>:timezone</td></tr>
                <tr><th>Calculation Method</th><td>:method</td></tr>
            </table>
        </div>
    </div>

    <h2 class="h4 mb-3">Today\'s Sehri and Iftar Times</h2>
    <div class="alert alert-success">
        <p class="mb-1"><strong>Sehri (Hanafi):</strong> :sehri | <strong>Sehri (Jafria):</strong> :altSehri</p>
        <p class="mb-0"><strong>Iftar (Both Fiqh):</strong> :iftar</p>
    </div>

    <p>These coordinates ensure the highest accuracy for :city Ramadan Sehri and Iftar timings. The complete 30-day schedule is available in the calendar below.</p>',

    // Block 5 - Calendar Focus
    '<h1 class="h3 mb-3">:city Ramadan Calendar :currentYear – 30 Days Sehri & Iftar Schedule</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="h4">Today: :gregorian (:hijri) – Day :ramadanDay</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fiqa Hanafi Sehri:</strong> :sehri</p>
                    <p><strong>Fiqa Hanafi Iftar:</strong> :iftar</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fiqa Jafria Sehri:</strong> :altSehri</p>
                    <p><strong>Fiqa Jafria Iftar:</strong> :altIftar</p>
                </div>
            </div>
        </div>
    </div>

    <p>View the complete 30-day Ramadan :currentYear calendar for :city below. All Sehri and Iftar timings are calculated using the :method method based on :city\'s geographic coordinates.</p>',

    // Block 6 - Community Focus
    '<h1 class="h3 mb-3">Ramadan Mubarak – Sehri & Iftar Timings for :city, :country</h1>
    
    <div class="card mb-4 text-center">
        <div class="card-body">
            <h2 class="h4">:gregorian (:hijri)</h2>
            <p class="lead">Today is <strong>Day :ramadanDay</strong> of Ramadan :currentYear</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6 text-center">
            <div class="card">
                <div class="card-body">
                    <h3 class="h6">Fiqa Hanafi Sehri</h3>
                    <p class="h4 text-primary">:sehri</p>
                </div>
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="card">
                <div class="card-body">
                    <h3 class="h6">Fiqa Jafria Sehri</h3>
                    <p class="h4 text-secondary">:altSehri</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <div class="card">
            <div class="card-body">
                <h3 class="h6">Iftar Time (Both Fiqh)</h3>
                <p class="h4 text-warning">:iftar</p>
            </div>
        </div>
    </div>

    <p>May your fasts be accepted. Check the complete Ramadan :currentYear Sehri and Iftar schedule for :city below.</p>',

    // Block 7 - Simple Overview
    '<h1 class="h3 mb-3">:city Ramadan :currentYear – Sehri & Iftar Schedule</h1>
    
    <div class="alert alert-primary">
        <strong>Today\'s Timings:</strong> Hanafi Sehri :sehri | Jafria Sehri :altSehri | Iftar :iftar
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h2 class="h5">Ramadan Day :ramadanDay – :gregorian (:hijri)</h2>
            <p>Location: :city, :country</p>
            <p>Calculation Method: :method</p>
        </div>
    </div>

    <p>Explore the complete 30-day Ramadan calendar for :city with accurate Sehri and Iftar times for both Hanafi and Jafria schools of thought.</p>',

    // Block 8 - Detailed with Table
    '<h1 class="h3 mb-3">:city Ramadan Timings :currentYear – Complete Sehri & Iftar Guide</h1>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="h6">Hanafi Sehri</h2>
                    <p class="h5">:sehri</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="h6">Jafria Sehri</h2>
                    <p class="h5">:altSehri</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="h6">Iftar (Both)</h2>
                    <p class="h5">:iftar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Date:</strong> :gregorian (:hijri) – Day :ramadanDay of Ramadan</p>
            <p><strong>Location:</strong> :city, :country</p>
            <p><strong>Fasting Duration (Hanafi):</strong> :fastingHours</p>
            <p><strong>Fasting Duration (Jafria):</strong> :altFastingHours</p>
        </div>
    </div>

    <p>View the complete 30-day Ramadan :currentYear calendar for :city below with all Sehri and Iftar times included.</p>'
];
        
        // RANDOMLY SELECT 4 BLOCKS (shuffle and take first 4)
        shuffle($mainDescriptionBlocks);
        $selectedBlocks = array_slice($mainDescriptionBlocks, 0, 4);
        
        $mainDescription = "";
        foreach ($selectedBlocks as $block) {
            $mainDescription .= str_replace(
                [":city", ":country", ":state", ":currentYear", ":year", ":sehri", ":iftar", ":altSehri", ":altIftar", 
                 ":ramadanDay", ":gregorian", ":hijri", ":method", ":fastingHours", ":altFastingHours", ":lat", ":lng", ":timezone"],
                [
                    $city, 
                    $country, 
                    $state ?? $city, 
                    $currentYear, 
                    $currentYear,
                    $sehriTime, 
                    $iftarTime, 
                    $alternateSehriTime, 
                    $alternateIftarTime,
                    $ramadanDay, 
                    $formattedGregorian, 
                    $hijriDisplay, 
                    $calculationMethod ?? 'Standard Islamic',
                    $fastingHours,
                    $altFastingHours,
                    request()->latitude ?? '24.86',
                    request()->longitude ?? '67.01',
                    request()->timezone ?? 'Asia/Karachi'
                ],
                $block
            ) . "\n\n";
        }
        $mainDescription = trim($mainDescription);
        
        // ============== META TITLE VARIANTS - SEHRI aur IFTAR use kiya gaya hai ==============
        $metaTitleVariants = [
            ":city Ramadan Timings :currentYear | Sehri :sehri | Iftar :iftar | Hanafi & Jafria",
            "Ramadan :currentYear :city | Today Sehri :sehri, Iftar :iftar | Complete Schedule",
            ":city Sehri Iftar Times :currentYear | Day :ramadanDay | Hanafi :sehri, Jafria :altSehri",
            ":city Ramadan Schedule :currentYear | Sehri :sehri | Iftar :iftar | Both Fiqh",
            "Official :city Ramadan Timings :currentYear | Sehri Ends :sehri, Iftar :iftar",
            ":city Ramadan Calendar :currentYear | Day :ramadanDay | Hanafi & Jafria Timings",
            "Ramadan :currentYear in :city | Complete Sehri Iftar Times | Sehri :sehri | Iftar :iftar",
            ":city Sehri & Iftar Timings :currentYear | Daily Updated | Both Fiqh Available",
            "Accurate :city Ramadan Timings :currentYear | Sehri :sehri | Iftar :iftar",
            ":city Ramadan :currentYear Guide | Sehri :sehri (Hanafi) / :altSehri (Jafria) | Iftar :iftar"
        ];
        
        $metaTitle = str_replace(
            [":city", ":currentYear", ":sehri", ":iftar", ":altSehri", ":altIftar", ":ramadanDay"],
            [$city, $currentYear, $sehriTime, $iftarTime, $alternateSehriTime, $alternateIftarTime, $ramadanDay],
            $metaTitleVariants[array_rand($metaTitleVariants)]
        );
        
        // ============== META DESCRIPTION VARIANTS - SEHRI aur IFTAR use kiya gaya hai ==============
        $metaDescriptionVariants = [
            ":city Ramadan :currentYear – Today Day :ramadanDay. Hanafi Sehri ends :sehri, Iftar :iftar. Jafria Sehri :altSehri. Complete 30-day calendar for :city, :country.",

            ":city Ramadan :currentYear timings: Today Sehri :sehri (Hanafi) / :altSehri (Jafria), Iftar :iftar. Day :ramadanDay of 30. Full schedule with Sehri and Iftar times.",

            "Ramadan :currentYear in :city – Today :gregorian. Hanafi: Sehri :sehri, Iftar :iftar | Jafria: Sehri :altSehri. Fasting :fastingHours. Complete 30-day calendar.",

            ":city Ramadan :currentYear – Day :ramadanDay: Sehri ends :sehri (Hanafi) / :altSehri (Jafria). Iftar at :iftar. Complete daily Sehri Iftar schedule for :city.",

            "Accurate :city Ramadan :currentYear calendar. Today's timings – Sehri: :sehri (Hanafi), :altSehri (Jafria) | Iftar: :iftar. All Sehri and Iftar times included.",

            ":city Ramadan :currentYear – Today Day :ramadanDay. Hanafi Sehri :sehri, Jafria Sehri :altSehri, Iftar :iftar. 30-day schedule for :city.",

            "Plan your Ramadan in :city with accurate timings. Today Sehri :sehri (Hanafi) / :altSehri (Jafria), Iftar :iftar. Day :ramadanDay of 30.",

            ":city Ramadan :currentYear fasting times – Hanafi Sehri :sehri, Jafria Sehri :altSehri, Iftar :iftar. Complete 30-day calendar available."
        ];
        
        $metaDescription = str_replace(
            [":city", ":country", ":currentYear", ":sehri", ":iftar", ":altSehri", ":altIftar", ":ramadanDay", ":gregorian", ":fastingHours"],
            [$city, $country, $currentYear, $sehriTime, $iftarTime, $alternateSehriTime, $alternateIftarTime, $ramadanDay, $formattedGregorian, $fastingHours],
            $metaDescriptionVariants[array_rand($metaDescriptionVariants)]
        );
        
        // ============== META KEYWORDS - SEHRI aur IFTAR based ==============
        $primaryKeyword = "$city Ramadan Timings $currentYear";
        $secondaryKeywords = [
            "$city Sehri Time $sehriTime",
            "$city Iftar Time $iftarTime",
            "$city Ramadan Calendar $currentYear",
            "Ramadan $currentYear $city",
            "$city Sehri Time",
            "$city Iftar Time",
            "$city Ramadan Sehri Iftar",
            "Hanafi Ramadan Timings $city",
            "Jafria Ramadan Timings $city",
            "$city Sehri Iftar Schedule",
            "Roza Timings $city $currentYear",
            "Today Sehri Time $city",
            "Today Iftar Time $city"
        ];
        
        $metaKeywords = implode(", ", array_merge(
            [$primaryKeyword],
            $secondaryKeywords,
            [
                "$city Ramadan $currentYear",
                "$city Sehri time Hanafi",
                "$city Sehri time Jafria",
                "$city Iftar time",
                "Ramadan schedule $city",
                "Fasting hours $city"
            ]
        ));
        
        return [
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords,
            'mainDescription' => $mainDescription
        ];
    }

    // ✅ BAQI FUNCTIONS WAISI HI RAHENGE
    private function getCachedCitiesInCountry($country, $currentCity)
    {
        $cacheKey = 'cities_in_' . str_replace(' ', '_', strtolower($country));
        $cacheTime = 60 * 24;
        
        return cache()->remember($cacheKey, $cacheTime, function() use ($country, $currentCity) {
            return RamadanSearch::where('country', $country)
                ->where('city', '!=', $currentCity)
                ->orderBy('city')
                ->limit(20)
                ->get();
        });
    }

    private function getCalculationMethod()
    {
        return cache()->remember('prayer_calculation_method', 60 * 24, function() {
            return config('prayer.calculation_method', 'Karachi');
        });
    }

    public function search(Request $request)
    {
        $request->validate(['city' => 'required|string|max:255']);
        
        return redirect()->route('ramadan.show', [
            'city' => Str::slug($request->city)
        ]);
    }

    protected function getCoordinates($city)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name')
            ])->get("https://nominatim.openstreetmap.org/search", [
                'q' => $city,
                'format' => 'json',
                'limit' => 1
            ]);
            
            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                return [
                    'lat' => $data['lat'],
                    'lng' => $data['lon']
                ];
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get coordinates for city: {$city}", ['error' => $e->getMessage()]);
        }
        
        return null;
    }

    protected function getPreciseLocation($city)
    {
        $default = ['country' => 'Unknown', 'state' => 'Unknown'];
        
        try {
            $geoResponse = Http::withHeaders([
                'User-Agent' => config('app.name'),
                'Accept-Language' => 'en'
            ])->get("https://nominatim.openstreetmap.org/search", [
                'q' => $city,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 5
            ]);
    
            if ($geoResponse->successful()) {
                $results = $geoResponse->json();
                
                foreach ($results as $result) {
                    $address = $result['address'] ?? [];
                    $displayName = $result['display_name'] ?? '';
                    
                    if (stripos($displayName, "$city, Saudi Arabia") !== false) {
                        return [
                            'country' => $address['country'] ?? 'Saudi Arabia',
                            'state' => $address['state'] ?? $address['region'] ?? 'Unknown'
                        ];
                    }
                }
                
                if (!empty($results)) {
                    $address = $results[0]['address'] ?? [];
                    return [
                        'country' => $address['country'] ?? $default['country'],
                        'state' => $address['state'] ?? $address['region'] ?? $default['state']
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get precise location for city: {$city}", ['error' => $e->getMessage()]);
        }
    
        return $default;
    }

    protected function getTimezone($latitude, $longitude)
    {
        try {
            $response = Http::get("https://api.timezonedb.com/v2.1/get-time-zone", [
                'key' => config('services.timezonedb.key'),
                'format' => 'json',
                'by' => 'position',
                'lat' => $latitude,
                'lng' => $longitude
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['zoneName'] ?? 'UTC';
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get timezone for coordinates: {$latitude},{$longitude}", ['error' => $e->getMessage()]);
        }
        
        return 'UTC';
    }

    protected function calculateRamadanTimes($latitude, $longitude, $timezone)
    {
        $currentYear = date('Y');
        $ramadanStart = Carbon::parse($this->getRamadanStartDate($currentYear));
        
        $times = [];
        
        for ($i = 0; $i < 30; $i++) {
            $date = $ramadanStart->copy()->addDays($i);
            $dayOfYear = $date->dayOfYear;
            
            $latRad = deg2rad($latitude);
            
            $declination = 23.45 * sin(deg2rad(360/365 * ($dayOfYear - 81)));
            $declinationRad = deg2rad($declination);
            
            $cosOmega = -tan($latRad) * tan($declinationRad);
            
            $dayLength = 12;
            
            if ($cosOmega >= -1 && $cosOmega <= 1) {
                $omega = acos($cosOmega);
                $dayLength = 2 * rad2deg($omega) / 15;
            }
            
            $solarNoon = 12.0;
            $sunriseHour = $solarNoon - ($dayLength / 2);
            $sunsetHour = $solarNoon + ($dayLength / 2);
            
            $dayProgress = $i / 29;
            
            $fajrOffset = -($dayProgress * 30);
            $fajrHour = $sunriseHour - 1.5 + ($fajrOffset / 60);
            
            $maghribOffset = $dayProgress * 30;
            $maghribHour = $sunsetHour + ($maghribOffset / 60);
            
            $fajrTime = $this->convertTo12Hour(sprintf('%02d:%02d', floor($fajrHour), round(($fajrHour - floor($fajrHour)) * 60)));
            $maghribTime = $this->convertTo12Hour(sprintf('%02d:%02d', floor($maghribHour), round(($maghribHour - floor($maghribHour)) * 60)));
            $sunriseTime = $this->convertTo12Hour(sprintf('%02d:%02d', floor($sunriseHour), round(($sunriseHour - floor($sunriseHour)) * 60)));
            
            $times[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $date->format('D'),
                'day' => $date->format('j'),
                'month' => $date->format('M'),
                'hijri_date' => $this->getHijriDate($date, $i + 1),
                'sehri' => $fajrTime,
                'fajr' => $fajrTime,
                'sunrise' => $sunriseTime,
                'dhuhr' => $this->convertTo12Hour('12:30'),
                'asr' => $this->convertTo12Hour('15:45'),
                'maghrib' => $maghribTime,
                'isha' => $this->convertTo12Hour('20:00')
            ];
        }
        
        return $times;
    }

    protected function getHijriDate($date, $ramadanDay)
    {
        $hijriYear = 1447;
        $hijriMonth = "Ramadan";
        
        return "{$ramadanDay} {$hijriMonth} {$hijriYear} AH";
    }

    /**
     * Get accurate Ramadan timings from ALADHAN API
     */
    private function getRamadanTimesFromAladhan($city, $country, $latitude, $longitude)
    {
        try {
            $currentYear = date('Y');
            $ramadanStart = $this->getRamadanStartDate($currentYear);
            $startDate = Carbon::parse($ramadanStart);
            
            $times = [];
            
            // Method 1 = University of Islamic Sciences, Karachi
            $method = 1;
            
            for ($i = 0; $i < 30; $i++) {
                $date = $startDate->copy()->addDays($i);
                $formattedDate = $date->format('d-m-Y');
                
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
                    $sunriseTime = $this->convertTo12Hour($timings['Sunrise'] ?? '06:30');
                    $dhuhrTime = $this->convertTo12Hour($timings['Dhuhr'] ?? '12:30');
                    $asrTime = $this->convertTo12Hour($timings['Asr'] ?? '15:45');
                    $ishaTime = $this->convertTo12Hour($timings['Isha'] ?? '20:00');
                    
                    $hijriDay = $hijri['day'] ?? ($i + 1);
                    $hijriMonth = $hijri['month']['en'] ?? 'Ramadan';
                    $hijriYear = $hijri['year'] ?? '1447';
                    
                    $times[] = [
                        'date' => $date->format('Y-m-d'),
                        'day_name' => $date->format('D'),
                        'day' => $date->format('j'),
                        'month' => $date->format('M'),
                        'hijri_date' => "{$hijriDay} {$hijriMonth} {$hijriYear} AH",
                        'sehri' => $fajrTime,
                        'fajr' => $fajrTime,
                        'sunrise' => $sunriseTime,
                        'dhuhr' => $dhuhrTime,
                        'asr' => $asrTime,
                        'maghrib' => $maghribTime,
                        'isha' => $ishaTime
                    ];
                } else {
                    // Fallback to calculated times if API fails
                    $times[] = $this->calculateFallbackTime($date, $i, $latitude);
                }
                
                // Small delay to avoid rate limiting
                if ($i < 29) usleep(100000);
            }
            
            // Add alternate Fiqh timings
            $times = $this->addAlternateFiqhTimings($times);
            
            return $times;
            
        } catch (\Exception $e) {
            \Log::error("ALADHAN API failed: " . $e->getMessage());
            // Fallback to calculated times
            return $this->calculateRamadanTimes($latitude, $longitude, 'UTC');
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
     * Calculate fallback time if API fails
     */
    private function calculateFallbackTime($date, $dayIndex, $latitude)
    {
        $lat = floatval($latitude);
        $baseFajr = 5.0 + (abs($lat) * 0.02);
        $baseMaghrib = 18.5 - (abs($lat) * 0.01);
        
        $progress = $dayIndex / 29;
        $fajrHour = $baseFajr - ($progress * 0.5);
        $maghribHour = $baseMaghrib + ($progress * 0.5);
        
        $fajrTime = $this->convertTo12Hour(sprintf('%02d:%02d', floor($fajrHour), round(($fajrHour - floor($fajrHour)) * 60)));
        $maghribTime = $this->convertTo12Hour(sprintf('%02d:%02d', floor($maghribHour), round(($maghribHour - floor($maghribHour)) * 60)));
        
        return [
            'date' => $date->format('Y-m-d'),
            'day_name' => $date->format('D'),
            'day' => $date->format('j'),
            'month' => $date->format('M'),
            'hijri_date' => ($dayIndex + 1) . ' Ramadan 1447 AH',
            'sehri' => $fajrTime,
            'fajr' => $fajrTime,
            'sunrise' => $this->convertTo12Hour('06:30'),
            'dhuhr' => $this->convertTo12Hour('12:30'),
            'asr' => $this->convertTo12Hour('15:45'),
            'maghrib' => $maghribTime,
            'isha' => $this->convertTo12Hour('20:00')
        ];
    }

    /**
     * Get today's times consistently from ramadanTimes array
     */
    private function getTodayTimes($ramadanTimes)
    {
        $today = now()->format('Y-m-d');
        
        // Find today's entry
        $todayEntry = null;
        foreach ($ramadanTimes as $entry) {
            if ($entry['date'] == $today) {
                $todayEntry = $entry;
                break;
            }
        }
        
        // If today not found, use first day
        if (!$todayEntry) {
            $todayEntry = $ramadanTimes[0];
        }
        
        // Calculate Jafria times based on today's entry
        $sehriJafria = $this->calculateAlternateTime($todayEntry['fajr'], -10);
        $iftarJafria = $todayEntry['maghrib'];
        
        // Calculate Ramadan day
        $ramadanStart = Carbon::parse($this->getRamadanStartDate(date('Y')));
        $ramadanDay = now()->diffInDays($ramadanStart) + 1;
        $ramadanDay = min(max($ramadanDay, 1), 30);
        
        return [
            'sehri_hanafi' => $todayEntry['fajr'],
            'iftar_hanafi' => $todayEntry['maghrib'],
            'sehri_jafria' => $sehriJafria,
            'iftar_jafria' => $iftarJafria,
            'ramadan_day' => $ramadanDay,
            'hijri_date' => $todayEntry['hijri_date'],
            'gregorian_date' => $todayEntry['date']
        ];
    }

    private function addAlternateFiqhTimings($ramadanTimes)
    {
        foreach ($ramadanTimes as $index => $day) {
            $ramadanTimes[$index]['sehri_hanafi'] = $day['fajr'] ?? "N/A";
            $ramadanTimes[$index]['sehri_jafria'] = $this->calculateAlternateTime($day['fajr'] ?? "N/A", -10);
            $ramadanTimes[$index]['iftar_hanafi'] = $day['maghrib'] ?? "N/A";
            $ramadanTimes[$index]['iftar_jafria'] = $this->calculateAlternateTime($day['maghrib'] ?? "N/A", 0);
        }
        
        return $ramadanTimes;
    }
    
    private function calculateAlternateTime($baseTime, $minutesOffset)
    {
        if ($baseTime == "N/A") return "N/A";
        try {
            return Carbon::createFromFormat('h:i A', $baseTime)
                ->addMinutes($minutesOffset)
                ->format('h:i A');
        } catch (\Exception $e) {
            try {
                return Carbon::createFromFormat('H:i', $baseTime)
                    ->addMinutes($minutesOffset)
                    ->format('h:i A');
            } catch (\Exception $e) {
                return $baseTime;
            }
        }
    }

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