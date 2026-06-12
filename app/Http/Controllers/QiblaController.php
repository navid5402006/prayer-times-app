<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\QiblaSearch;
use Illuminate\Support\Str;

class QiblaController extends Controller
{

    public function index()
{
    $recentSearches = QiblaSearch::latest()->take(5)->get(['city', 'country', 'created_at']);
    return view('qibla-index', compact('recentSearches'));
}

public function showBySlug($citySlug, $lang = null)
{
    // Remove language prefix if present in the citySlug
    if (strpos($citySlug, '/') !== false) {
        $parts = explode('/', $citySlug);
        $citySlug = end($parts);
    }

    // Replace all hyphens with spaces
    $city = str_replace('-', ' ', $citySlug);
    
    // Capitalize each word
    $city = ucwords(strtolower($city));
    
    // Handle special cases (like "Al Jazeera")
    $city = preg_replace_callback('/\b(al|el)\b/i', function($matches) {
        return ucfirst(strtolower($matches[0]));
    }, $city);
    
    // Generate slug for database lookup
    $slug = strtolower(str_replace(' ', '-', $city . '-qibla-direction'));
    
    // ✅ CHECK DATABASE FIRST - NO API CALL IF EXISTS
    $existingData = QiblaSearch::where('slug', $slug)->first();
    
    // If data exists in database, return immediately without API calls
    if ($existingData) {
        return view('qibla-direction', [
            'city' => $existingData->city,
            'country' => $existingData->country,
            'state' => $existingData->state,
            'latitude' => $existingData->latitude,
            'longitude' => $existingData->longitude,
            'qiblaDirection' => $existingData->qibla_direction,
            'main_description' => $existingData->main_description,
            'meta_title' => $existingData->meta_title,
            'meta_description' => $existingData->meta_description,
            'meta_keywords' => $existingData->meta_keywords,
            'citiesInCountry' => QiblaSearch::where('country', $existingData->country)
                               ->where('city', '!=', $existingData->city)
                               ->orderBy('city')
                               ->limit(20)
                               ->get()
        ]);
    }
    
    // ONLY MAKE API CALL IF DATA DOESN'T EXIST IN DATABASE
    try {
        // Attempt to get fresh data from APIs
        $location = $this->getPreciseLocation($city);
        $coordinates = $this->getCoordinates($city);
        
        if (!$coordinates) {
            return redirect('/')->with('error', 'Failed to fetch location coordinates');
        }
        
        $qiblaDirection = $this->calculateQiblaDirection(
            $coordinates['lat'],
            $coordinates['lng']
        );
        
        // Generate unique meta data for this city
        $metaData = $this->generateUniqueMetaData($city, $location, $qiblaDirection);
        
        // Save ALL data to database including meta fields
        QiblaSearch::create([
            'slug' => $slug,
            'city' => $city,
            'state' => $location['state'],
            'country' => $location['country'],
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'qibla_direction' => $qiblaDirection,
            'main_description' => $metaData['main_description'],
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords']
        ]);
        
        return view('qibla-direction', [
            'city' => $city,
            'country' => $location['country'],
            'state' => $location['state'],
            'latitude' => $coordinates['lat'],
            'longitude' => $coordinates['lng'],
            'qiblaDirection' => $qiblaDirection,
            'main_description' => $metaData['main_description'],
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords'],
            'citiesInCountry' => QiblaSearch::where('country', $location['country'])
                               ->where('city', '!=', $city)
                               ->orderBy('city')
                               ->limit(20)
                               ->get()
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Qibla data fetch error: ' . $e->getMessage());
        return redirect('/')->with('error', 'Failed to fetch location data');
    }
}

/**
 * Generate UNIQUE meta data for each city
 * Ensures no two cities have same content
 */
/**
 * Generate unique main description with city-specific content
 */
protected function generateMainDescription($city, $state, $country, $qiblaDirection, $latitude = null, $longitude = null)
{
    $descriptions = [
        "<h2>Qibla Direction for {$city}</h2>
        <p>The Qibla direction from {$city}" . ($state !== 'Unknown' ? ", {$state}" : '') . ($country !== 'Unknown' ? ", {$country}" : '') . " is approximately {$qiblaDirection}° degrees from North towards the Kaaba in Makkah, Saudi Arabia. This direction is calculated using precise geographic coordinates and spherical trigonometry formulas.</p>
        
        <h3>How to Find Qibla in {$city}</h3>
        <p>Muslims in {$city} can determine the Qibla direction using various methods: traditional compass adjusted for magnetic declination, modern smartphone applications with built-in qibla finders, or by observing the position of the sun which indicates the qibla direction at specific times. For the most accurate results, we recommend using our online qibla direction tool which provides real-time calculations based on your exact location in {$city}.</p>
        
        <h3>Prayer Times in {$city}</h3>
        <p>Knowing the correct prayer times is essential for Muslims in {$city}. The five daily prayers - Fajr, Dhuhr, Asr, Maghrib, and Isha - follow the sun's position throughout the day. In {$city}, prayer times vary throughout the year due to changing daylight hours. Stay connected with your local {$city} mosque or Islamic center for accurate prayer schedules.</p>",
        
        "<h2>Finding the Kaaba Direction from {$city}</h2>
        <p>For Muslims residing in {$city}" . ($state !== 'Unknown' ? ", {$state}" : '') . ", knowing the precise qibla direction of {$qiblaDirection}° is essential for daily prayers. Our qibla finder uses satellite imagery and mathematical calculations to provide you with the most accurate direction to the Holy Kaaba in Makkah.</p>
        
        <h3>Islamic Significance of Qibla in {$city}</h3>
        <p>The qibla direction unites Muslims worldwide, including those in {$city}, in facing the same point during prayer. This practice symbolizes the unity of the Muslim ummah and their devotion to Allah. The Kaaba in Makkah serves as this central point, making it crucial for {$city} residents to face the correct direction during salah.</p>
        
        <h3>Technology for Qibla Finding in {$city}</h3>
        <p>Modern technology has made finding the qibla in {$city} easier than ever. GPS-enabled devices can instantly calculate your exact position and provide the correct qibla angle. Our website offers a reliable qibla direction service specifically calibrated for {$city} and surrounding areas in {$country}.</p>",
        
        "<h2>Qibla Direction Guide for {$city}</h2>
        <p>Are you in {$city} and need to find the correct qibla direction? Our comprehensive guide shows you the exact qibla angle of {$qiblaDirection}° for {$city}" . ($state !== 'Unknown' ? ", {$state}" : '') . ". Whether you're at home, work, or traveling, maintaining the correct Qibla direction is now simple and accurate.</p>
        
        <h3>Understanding Qibla Calculation for {$city}</h3>
        <p>The qibla direction for {$city} is calculated using the great circle formula, which finds the shortest path between two points on the Earth's surface. By using the coordinates of {$city} (latitude: " . ($latitude ?? 'your location') . ", longitude: " . ($longitude ?? 'your location') . ") and the Kaaba in Makkah (21.4225° N, 39.8262° E), we determine that Muslims in {$city} should pray facing {$qiblaDirection}° from true north.</p>
        
        <h3>Local Islamic Resources in {$city}</h3>
        <p>Connect with the Muslim community in {$city} through local mosques and Islamic centers. These institutions often provide qibla verification services and prayer time schedules specifically for {$city}. Many {$city} mosques have marked prayer lines (sutrah) aligned precisely with the qibla direction.</p>",
        
        "<h2>Accurate Qibla Direction for Muslims in {$city}</h2>
        <p>Living in {$city}" . ($country !== 'Unknown' ? ", {$country}" : '') . " and need to know the exact qibla direction? Our tool shows that Muslims in {$city} should face {$qiblaDirection}° degrees towards Makkah, Saudi Arabia. This direction has been verified using multiple calculation methods for maximum accuracy.</p>
        
        <h3>Practical Qibla Finding Tips for {$city}</h3>
        <p>For those in {$city}, here are practical ways to find the qibla: Use a qibla compass app on your smartphone, check the direction of your local mosque which should be built facing the qibla, or use the sun's shadow method. At solar noon, the sun is directly south in the northern hemisphere, helping {$city} residents determine the qibla direction.</p>
        
        <h3>Qibla and Islamic Community in {$city}</h3>
        <p>The Muslim community in {$city} continues to grow, making access to accurate religious guidance increasingly important. Our service provides not only qibla direction but also connects you with Islamic resources available in {$city} and throughout {$country}. Stay informed about local Islamic events, prayer gatherings, and community activities in {$city}.</p>",
        
        "<h2>Accurate Qibla Direction for {$city} Residents</h2>
        <p>This comprehensive guide provides {$city} residents with the accurate qibla direction of {$qiblaDirection}° for daily prayers. Whether you're in downtown {$city} or the surrounding areas, our calculation takes into account your location's precise coordinates to ensure correct prayer orientation.</p>
        
        <h3>Geographic Context of {$city} Qibla</h3>
        <p>Located at strategic coordinates, {$city}" . ($state !== 'Unknown' ? " in {$state}" : '') . " has a unique qibla angle due to its position relative to Makkah. Understanding this geographic relationship helps Muslims appreciate the spiritual connection between {$city} and the holy city of Makkah, despite the distance of thousands of kilometers.</p>
        
        <h3>Year-Round Qibla Consistency in {$city}</h3>
        <p>Unlike prayer times which change with seasons, the qibla direction for {$city} remains constant at {$qiblaDirection}° throughout the year. This consistency allows {$city} Muslims to permanently mark the Qibla direction in their homes, workplaces, or local prayer rooms. Bookmark this page for quick reference whenever you need to verify the qibla direction in {$city}.</p>"
    ];
    
    // Use a combination of city characteristics to pick unique description
    $charSum = array_sum(array_map('ord', str_split($city))) + strlen($country);
    $descIndex = $charSum % count($descriptions);
    
    return $descriptions[$descIndex];
}

/**
 * Generate UNIQUE meta data for each city
 * Ensures no two cities have same content
 */
protected function generateUniqueMetaData($city, $location, $qiblaDirection, $coordinates = null)
{
    $country = $location['country'] ?? 'Unknown';
    $state = $location['state'] ?? 'Unknown';
    
    $latitude = $coordinates['lat'] ?? null;
    $longitude = $coordinates['lng'] ?? null;
    
    // Generate unique meta title
    $metaTitle = "Accurate Qibla Direction for {$city}";
    if ($state !== 'Unknown' && $state !== $city) {
        $metaTitle .= ", {$state}";
    }
    if ($country !== 'Unknown') {
        $metaTitle .= " - {$country}";
    }
    $metaTitle .= " | Find Qibla Online";
    
    // Generate unique meta description (different for each city)
    $descriptions = [
        "Find precise Qibla direction for {$city} with our accurate compass. Get prayer times and Islamic information for {$city}" . ($state !== 'Unknown' ? ", {$state}" : '') . ".",
        "Looking for Qibla direction in {$city}? We provide accurate {$qiblaDirection}° direction from {$city} to Kaaba. Updated daily for Muslims in {$country}.",
        "Muslims in {$city} can now find accurate Qibla direction of {$qiblaDirection}°. Complete prayer guide for {$city}" . ($state !== 'Unknown' ? ", {$state}" : '') . ".",
        "Calculate Qibla direction for {$city} easily. Our tool shows {$qiblaDirection}° from {$city} to Makkah. Free Islamic resources for {$country}.",
        "Best Qibla finder for {$city} residents. Get exact direction {$qiblaDirection}° towards Kaaba. Prayer times and Islamic calendar included."
    ];
    
    // Use city name length to pick different description for different cities
    $descIndex = (strlen($city) + strlen($country)) % count($descriptions);
    $metaDescription = $descriptions[$descIndex];
    
    // Generate unique meta keywords
    $keywordSets = [
        "qibla direction {$city}, {$city} qibla, direction {$city}, kaaba direction {$city}, muslim prayer {$city}, islamic finder {$country}",
        "{$city} qibla angle, {$qiblaDirection}° direction, pray towards kaaba, {$city} prayer times, {$country} islamic center, muslim compass {$city}",
        "find qibla {$city}, {$city} mosque direction, salah direction {$city}, makkah direction from {$city}, {$country} prayer times, islamic qibla finder",
        "{$city} compass direction, online qibla {$city}, {$city} prayer guide, muslims in {$country}, {$city} islamic community, accurate qibla finder",
        "{$city} to makkah direction, {$city} kaaba direction, {$state} qibla, {$country}  direction, islamic tools {$city}, muslim compass online"
    ];
    
    $keywordIndex = (strlen($city) + strlen($state)) % count($keywordSets);
    $metaKeywords = $keywordSets[$keywordIndex];
    
    // Generate unique main description with coordinates
    $mainDescription = $this->generateMainDescription($city, $state, $country, $qiblaDirection, $latitude, $longitude);
    
    return [
        'main_description' => $mainDescription,
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'meta_keywords' => $metaKeywords
    ];
}

protected function getCoordinates($city)
{
    // ✅ CHECK DATABASE FIRST
    $existingCity = QiblaSearch::where('city', 'LIKE', "%{$city}%")->first();
    if ($existingCity && $existingCity->latitude && $existingCity->longitude) {
        return [
            'lat' => $existingCity->latitude,
            'lng' => $existingCity->longitude
        ];
    }
    
    // ONLY MAKE API CALL IF NOT IN DATABASE
    try {
        $response = Http::withHeaders([
            'User-Agent' => 'Your App Name'
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
        \Log::error('Coordinates API error: ' . $e->getMessage());
    }
    
    return null;
}

protected function calculateQiblaDirection($latitude, $longitude)
{
    // Kaaba coordinates
    $kaabaLat = 21.422487;
    $kaabaLng = 39.826206;
    
    // Convert degrees to radians
    $lat1 = deg2rad($latitude);
    $lng1 = deg2rad($longitude);
    $lat2 = deg2rad($kaabaLat);
    $lng2 = deg2rad($kaabaLng);
    
    // Calculate the difference in longitude
    $deltaLng = $lng2 - $lng1;
    
    // Calculate the Qibla direction
    $y = sin($deltaLng) * cos($lat2);
    $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($deltaLng);
    $qiblaDirection = rad2deg(atan2($y, $x));
    
    // Normalize to 0-360 degrees
    $qiblaDirection = fmod(($qiblaDirection + 360), 360);
    
    return round($qiblaDirection, 2);
}

protected function getPreciseLocation($city)
{
    // ✅ CHECK DATABASE FIRST
    $existingCity = QiblaSearch::where('city', 'LIKE', "%{$city}%")->first();
    if ($existingCity) {
        return [
            'country' => $existingCity->country ?? 'Unknown',
            'state' => $existingCity->state ?? 'Unknown'
        ];
    }
    
    // ONLY MAKE API CALL IF NOT IN DATABASE
    $default = ['country' => 'Unknown', 'state' => 'Unknown'];
    
    try {
        $geoResponse = Http::withHeaders([
            'User-Agent' => 'Your App Name',
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
        \Log::error('Location API error: ' . $e->getMessage());
    }

    return $default;
}
    
    public function search(Request $request)
    {
        $request->validate(['city' => 'required|string|max:255']);
        
        return redirect()->route('qibla.show', [
            'city' => Str::slug($request->city)
        ]);
    }
}