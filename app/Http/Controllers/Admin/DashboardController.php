<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerSearch;
use App\Models\QiblaSearch;
use App\Models\RamadanSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index(Request $request)
{
    // Get prayer times statistics
    $totalPrayerSearches = PrayerSearch::count();
    $todayPrayerSearches = PrayerSearch::whereDate('created_at', today())->count();
    $recentPrayerSearches = PrayerSearch::latest()->take(5)->get();

    // Get Qibla search statistics
    $totalQiblaSearches = QiblaSearch::count();
    $todayQiblaSearches = QiblaSearch::whereDate('created_at', today())->count();
    $recentQiblaSearches = QiblaSearch::latest()->take(5)->get();

    // Get Ramadan search statistics
    $totalRamadanSearches = RamadanSearch::count();
    $todayRamadanSearches = RamadanSearch::whereDate('created_at', today())->count();
    $recentRamadanSearches = RamadanSearch::latest()->take(5)->get();

    // Get unique countries from all tables
    $prayerCountries = PrayerSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('country', 'asc')
        ->pluck('country')
        ->toArray();

    $qiblaCountries = QiblaSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('country', 'asc')
        ->pluck('country')
        ->toArray();

    $ramadanCountries = RamadanSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('country', 'asc')
        ->pluck('country')
        ->toArray();

    // Merge and get unique countries
    $allCountries = array_unique(array_merge($prayerCountries, $qiblaCountries, $ramadanCountries));
    sort($allCountries);

    // Get selected country from request
    $selectedCountry = $request->get('country', 'all');

    // Get cities based on selected country
    $cities = [];

    if ($selectedCountry == 'all') {
        // Get all cities from all tables
        $prayerCities = PrayerSearch::select('city', 'state', 'country', DB::raw('"prayer" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $qiblaCities = QiblaSearch::select('city', 'state', 'country', DB::raw('"qibla" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $ramadanCities = RamadanSearch::select('city', 'state', 'country', DB::raw('"ramadan" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $cities = collect()
            ->merge($prayerCities)
            ->merge($qiblaCities)
            ->merge($ramadanCities)
            ->groupBy(function($item) {
                return $item->city . '|' . $item->country;
            })
            ->map(function($group) {
                $first = $group->first();
                $sources = $group->pluck('source')->unique()->values()->toArray();
                
                return (object)[
                    'city' => $first->city,
                    'state' => $first->state,
                    'country' => $first->country,
                    'sources' => $sources,
                    'has_prayer' => in_array('prayer', $sources),
                    'has_qibla' => in_array('qibla', $sources),
                    'has_ramadan' => in_array('ramadan', $sources),
                    'total_sources' => count($sources)
                ];
            })
            ->values()
            ->toArray();
    } else {
        // Get cities for specific country from all tables
        $prayerCities = PrayerSearch::where('country', $selectedCountry)
            ->select('city', 'state', 'country', DB::raw('"prayer" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $qiblaCities = QiblaSearch::where('country', $selectedCountry)
            ->select('city', 'state', 'country', DB::raw('"qibla" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $ramadanCities = RamadanSearch::where('country', $selectedCountry)
            ->select('city', 'state', 'country', DB::raw('"ramadan" as source'))
            ->orderBy('created_at', 'desc')
            ->get();

        $cities = collect()
            ->merge($prayerCities)
            ->merge($qiblaCities)
            ->merge($ramadanCities)
            ->groupBy(function($item) {
                return $item->city;
            })
            ->map(function($group) use ($selectedCountry) {
                $first = $group->first();
                $sources = $group->pluck('source')->unique()->values()->toArray();
                
                return (object)[
                    'city' => $first->city,
                    'state' => $first->state,
                    'country' => $selectedCountry,
                    'sources' => $sources,
                    'has_prayer' => in_array('prayer', $sources),
                    'has_qibla' => in_array('qibla', $sources),
                    'has_ramadan' => in_array('ramadan', $sources),
                    'total_sources' => count($sources)
                ];
            })
            ->values()
            ->toArray();
    }

    // Get statistics for selected country
    $selectedCountryStats = null;
    if ($selectedCountry != 'all') {
        $selectedCountryStats = [
            'prayer_count' => PrayerSearch::where('country', $selectedCountry)->count(),
            'qibla_count' => QiblaSearch::where('country', $selectedCountry)->count(),
            'ramadan_count' => RamadanSearch::where('country', $selectedCountry)->count(),
            'cities_count' => count($cities)
        ];
    }

    // Country statistics from all tables (for summary)
    $prayerCountries = PrayerSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('total', 'desc')
        ->get();

    $qiblaCountries = QiblaSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('total', 'desc')
        ->get();

    $ramadanCountries = RamadanSearch::select('country', DB::raw('COUNT(*) as total'))
        ->groupBy('country')
        ->orderBy('total', 'desc')
        ->get();

    // Get unique countries and their statistics
    $countryStats = [];
    
    // Process Prayer Searches for countries
    $prayerCountryStats = PrayerSearch::select('country', 
            DB::raw('COUNT(*) as prayer_count'),
            DB::raw('MAX(created_at) as last_prayer_search'),
            DB::raw('COUNT(DISTINCT city) as cities_count')
        )
        ->groupBy('country')
        ->orderBy('prayer_count', 'desc')
        ->get();

    // Process Qibla Searches for countries
    $qiblaCountryStats = QiblaSearch::select('country', 
            DB::raw('COUNT(*) as qibla_count'),
            DB::raw('MAX(created_at) as last_qibla_search'),
            DB::raw('COUNT(DISTINCT city) as cities_count')
        )
        ->groupBy('country')
        ->orderBy('qibla_count', 'desc')
        ->get();

    // Process Ramadan Searches for countries
    $ramadanCountryStats = RamadanSearch::select('country', 
            DB::raw('COUNT(*) as ramadan_count'),
            DB::raw('MAX(created_at) as last_ramadan_search'),
            DB::raw('COUNT(DISTINCT city) as cities_count')
        )
        ->groupBy('country')
        ->orderBy('ramadan_count', 'desc')
        ->get();

    // Merge all country statistics
    $countryStats = [];
    
    foreach ($prayerCountryStats as $stat) {
        $countryStats[$stat->country] = [
            'country' => $stat->country,
            'prayer_count' => $stat->prayer_count,
            'qibla_count' => 0,
            'ramadan_count' => 0,
            'total_searches' => $stat->prayer_count,
            'cities_count' => $stat->cities_count,
            'last_activity' => $stat->last_prayer_search,
            'last_city' => $this->getLastCityForCountry('prayer', $stat->country)
        ];
    }

    foreach ($qiblaCountryStats as $stat) {
        if (isset($countryStats[$stat->country])) {
            $countryStats[$stat->country]['qibla_count'] = $stat->qibla_count;
            $countryStats[$stat->country]['total_searches'] += $stat->qibla_count;
            $countryStats[$stat->country]['cities_count'] += $stat->cities_count;
            if ($stat->last_qibla_search > $countryStats[$stat->country]['last_activity']) {
                $countryStats[$stat->country]['last_activity'] = $stat->last_qibla_search;
                $countryStats[$stat->country]['last_city'] = $this->getLastCityForCountry('qibla', $stat->country);
            }
        } else {
            $countryStats[$stat->country] = [
                'country' => $stat->country,
                'prayer_count' => 0,
                'qibla_count' => $stat->qibla_count,
                'ramadan_count' => 0,
                'total_searches' => $stat->qibla_count,
                'cities_count' => $stat->cities_count,
                'last_activity' => $stat->last_qibla_search,
                'last_city' => $this->getLastCityForCountry('qibla', $stat->country)
            ];
        }
    }

    foreach ($ramadanCountryStats as $stat) {
        if (isset($countryStats[$stat->country])) {
            $countryStats[$stat->country]['ramadan_count'] = $stat->ramadan_count;
            $countryStats[$stat->country]['total_searches'] += $stat->ramadan_count;
            $countryStats[$stat->country]['cities_count'] += $stat->cities_count;
            if ($stat->last_ramadan_search > $countryStats[$stat->country]['last_activity']) {
                $countryStats[$stat->country]['last_activity'] = $stat->last_ramadan_search;
                $countryStats[$stat->country]['last_city'] = $this->getLastCityForCountry('ramadan', $stat->country);
            }
        } else {
            $countryStats[$stat->country] = [
                'country' => $stat->country,
                'prayer_count' => 0,
                'qibla_count' => 0,
                'ramadan_count' => $stat->ramadan_count,
                'total_searches' => $stat->ramadan_count,
                'cities_count' => $stat->cities_count,
                'last_activity' => $stat->last_ramadan_search,
                'last_city' => $this->getLastCityForCountry('ramadan', $stat->country)
            ];
        }
    }

    // Sort by total searches
    usort($countryStats, function($a, $b) {
        return $b['total_searches'] - $a['total_searches'];
    });

    // Total cities count
    $totalCities = PrayerSearch::distinct('city')->count('city') + 
                  QiblaSearch::distinct('city')->count('city') + 
                  RamadanSearch::distinct('city')->count('city');

       // Countries Cards Data - Cities count ke hisab se ascending order mein
    $countryCards = [];
    
    foreach ($countryStats as $country) {
        // Check if country has data in each table
        $hasPrayer = PrayerSearch::where('country', $country['country'])->exists();
        $hasQibla = QiblaSearch::where('country', $country['country'])->exists();
        $hasRamadan = RamadanSearch::where('country', $country['country'])->exists();
        
        // Get last added city for this country
        $lastAddedCity = null;
        $lastActivity = null;
        
        $lastPrayer = PrayerSearch::where('country', $country['country'])
            ->latest()
            ->first();
        $lastQibla = QiblaSearch::where('country', $country['country'])
            ->latest()
            ->first();
        $lastRamadan = RamadanSearch::where('country', $country['country'])
            ->latest()
            ->first();
        
        // Find the most recent activity
        $activities = [];
        if ($lastPrayer) {
            $activities[] = ['city' => $lastPrayer->city, 'time' => $lastPrayer->created_at];
        }
        if ($lastQibla) {
            $activities[] = ['city' => $lastQibla->city, 'time' => $lastQibla->created_at];
        }
        if ($lastRamadan) {
            $activities[] = ['city' => $lastRamadan->city, 'time' => $lastRamadan->created_at];
        }
        
        if (!empty($activities)) {
            usort($activities, function($a, $b) {
                return $b['time'] <=> $a['time'];
            });
            $lastAddedCity = $activities[0]['city'];
            $lastActivity = $activities[0]['time'];
        }
        
        $countryCards[] = [
            'country' => $country['country'],
            'cities_count' => $country['cities_count'],
            'total_searches' => $country['total_searches'],
            'has_prayer' => $hasPrayer,
            'has_qibla' => $hasQibla,
            'has_ramadan' => $hasRamadan,
            'last_added_city' => $lastAddedCity,
            'last_activity' => $lastActivity
        ];
    }
    
    // Sort by cities_count (ascending - kam cities wale pehle)
    usort($countryCards, function($a, $b) {
        if ($a['cities_count'] == $b['cities_count']) {
            // Agar cities count equal hai to last activity ke hisab se sort karo
            if ($a['last_activity'] && $b['last_activity']) {
                return $b['last_activity'] <=> $a['last_activity'];
            }
            return 0;
        }
        return $a['cities_count'] - $b['cities_count']; // Ascending order
    });
    
    // ... aapka existing return statement ...
    
    return view('admin.dashboard', compact(
        'totalPrayerSearches',
        'todayPrayerSearches',
        'recentPrayerSearches',
        'totalQiblaSearches',
        'todayQiblaSearches',
        'recentQiblaSearches',
        'totalRamadanSearches',
        'todayRamadanSearches',
        'recentRamadanSearches',
        'countryStats',
        'totalCities',
        'allCountries',
        'selectedCountry',
        'cities',
        'selectedCountryStats',
        'countryCards' // Yeh naya variable add kiya
    ));
}


// Helper function to get last city for country
private function getLastCityForCountry($type, $country)
{
    switch($type) {
        case 'prayer':
            $search = PrayerSearch::where('country', $country)
                ->latest()
                ->first();
            break;
        case 'qibla':
            $search = QiblaSearch::where('country', $country)
                ->latest()
                ->first();
            break;
        case 'ramadan':
            $search = RamadanSearch::where('country', $country)
                ->latest()
                ->first();
            break;
        default:
            return 'N/A';
    }
    
    return $search ? $search->city : 'N/A';
}

    
}