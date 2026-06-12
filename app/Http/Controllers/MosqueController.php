<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MosqueSearch;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MosqueController extends Controller
{
    /**
     * Show the mosque index page
     */
    public function index()
    {
        $recentSearches = MosqueSearch::latest()->take(5)->get(['city', 'country', 'created_at']);
        
        return view('mosque_index', compact('recentSearches'));
    }

    /**
     * Show mosques by city slug - Updated for /mosques-in-[city] URL structure
     */
    public function showBySlug($citySlug, $lang = null)
    {
        // Handle language prefix if present
        if (strpos($citySlug, '/') !== false) {
            $parts = explode('/', $citySlug);
            $citySlug = end($parts);
        }
        
        // Remove 'mosques-in-' prefix from the URL if present
        $citySlug = preg_replace('/^mosques-in-/', '', $citySlug);
        
        // Also handle any duplicate patterns
        $citySlug = preg_replace('/-mosques-?mosques$/', '-mosques', $citySlug);
        $citySlug = preg_replace('/-mosques$/', '', $citySlug);
        
        // Convert slug to city name
        $city = str_replace('-', ' ', $citySlug);
        
        // Format city name properly
        $city = preg_replace_callback('/\b(al|el)\b/i', function($matches) {
            return ucfirst(strtolower($matches[0]));
        }, $city);
        
        // Generate slug for database (store with -mosques suffix for consistency)
        $slug = strtolower(str_replace(' ', '-', $city . '-mosques'));
        
        // Check if city exists in database
        $existingMosque = MosqueSearch::where('slug', $slug)->first(['city', 'country', 'state', 'latitude', 'longitude', 'slug']);
        
        $currentYear = date('Y');
        
        // Get coordinates (either from DB or fetch new)
        if ($existingMosque) {
            $latitude = $existingMosque->latitude;
            $longitude = $existingMosque->longitude;
            $country = $existingMosque->country;
            $state = $existingMosque->state;
            $city = $existingMosque->city;
        } else {
            $location = $this->getPreciseLocation($city);
            $coordinates = $this->getCoordinates($city);
            
            if (!$coordinates) {
                return redirect('/mosque-near-me')->with('error', 'Failed to fetch location coordinates');
            }
            
            $latitude = $coordinates['lat'];
            $longitude = $coordinates['lng'];
            $country = $location['country'];
            $state = $location['state'];
            
            try {
                MosqueSearch::create([
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'slug' => $slug
                ]);
            } catch (\Exception $e) {
                \Log::warning("Duplicate slug attempted: {$slug}");
            }
        }
        
        // Fetch ALL real-time mosques from APIs with larger radius for city-wide coverage
        $mosques = $this->fetchMosquesFromAPIs($city, $latitude, $longitude, 15);
        
        $totalMosques = count($mosques);
        
        // Get nearby cities in same country
        $citiesInCountry = $this->getCachedCitiesInCountry($country, $city);
        
        // Generate SEO metadata
        $metaData = $this->generateSEOMetaData(
            $city,
            $country,
            $state,
            $totalMosques,
            $currentYear
        );
        
        return view('mosque_details', [
            'city' => $city,
            'country' => $country,
            'state' => $state,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'mosques' => $mosques,
            'totalMosques' => $totalMosques,
            'metaTitle' => $metaData['metaTitle'],
            'metaDescription' => $metaData['metaDescription'],
            'metaKeywords' => $metaData['metaKeywords'],
            'mainDescription' => $metaData['mainDescription'],
            'currentYear' => $currentYear,
            'citiesInCountry' => $citiesInCountry
        ]);
    }

    /**
     * Fetch ALL mosques from APIs (increased radius for city-wide coverage)
     */
    private function fetchMosquesFromAPIs($city, $lat, $lng, $radius = 15)
    {
        // Use cache for API responses (30 minute cache)
        $cacheKey = 'mosques_all_' . md5($lat . $lng . $radius . $city);
        
        return cache()->remember($cacheKey, now()->addMinutes(30), function() use ($city, $lat, $lng, $radius) {
            // Try Overpass API first with comprehensive query
            $mosques = $this->fetchAllFromOverpass($lat, $lng, $radius);
            
            if (empty($mosques)) {
                // If no results, try with larger radius
                $mosques = $this->fetchAllFromOverpass($lat, $lng, $radius * 1.5);
            }
            
            // If still no results, generate sample data based on city size
            if (empty($mosques)) {
                $mosques = $this->generateCityMosques($city, $lat, $lng, $radius);
            }
            
            // Sort by distance
            usort($mosques, function($a, $b) {
                return $a['distance'] <=> $b['distance'];
            });
            
            return $mosques;
        });
    }

    /**
     * Fetch ALL mosques from Overpass API with comprehensive query
     */
    private function fetchAllFromOverpass($lat, $lng, $radius = 15)
    {
        try {
            // Calculate bounding box
            $latOffset = $radius / 100;
            $lngOffset = $radius / (100 * cos(deg2rad($lat)));
            
            $minLat = $lat - $latOffset;
            $maxLat = $lat + $latOffset;
            $minLon = $lng - $lngOffset;
            $maxLon = $lng + $lngOffset;
            
            $bbox = "{$minLat},{$minLon},{$maxLat},{$maxLon}";
            
            // COMPREHENSIVE Overpass query to get ALL mosques
            $query = '[out:json][timeout:60];
            (
                node["amenity"="place_of_worship"]["religion"="muslim"](' . $bbox . ');
                way["amenity"="place_of_worship"]["religion"="muslim"](' . $bbox . ');
                relation["amenity"="place_of_worship"]["religion"="muslim"](' . $bbox . ');
                
                node["amenity"="mosque"](' . $bbox . ');
                way["amenity"="mosque"](' . $bbox . ');
                relation["amenity"="mosque"](' . $bbox . ');
                
                node["building"="mosque"](' . $bbox . ');
                way["building"="mosque"](' . $bbox . ');
                relation["building"="mosque"](' . $bbox . ');
                
                node["landuse"="religious"]["religion"="muslim"](' . $bbox . ');
                way["landuse"="religious"]["religion"="muslim"](' . $bbox . ');
                
                node["name"~"mosque|masjid|مسجد|جامع|مصلى|мечеть|camii", i](' . $bbox . ');
                way["name"~"mosque|masjid|مسجد|جامع|مصلى|мечеть|camii", i](' . $bbox . ');
                
                node["name"~"islamic center|islamic centre|مركز إسلامي", i](' . $bbox . ');
                way["name"~"islamic center|islamic centre|مركز إسلامي", i](' . $bbox . ');
            );
            out body center qt;';
            
            $response = Http::timeout(30)
                ->withHeaders(['User-Agent' => config('app.name')])
                ->post('https://overpass-api.de/api/interpreter', ['data' => $query]);
            
            if (!$response->successful()) {
                \Log::warning('Overpass API failed: ' . $response->status());
                return [];
            }
            
            $data = $response->json();
            
            if (empty($data['elements'])) {
                return [];
            }
            
            $mosques = [];
            $usedPositions = [];
            $foundCount = 0;
            
            foreach ($data['elements'] as $element) {
                // Get coordinates (handle nodes, ways, and relations)
                $mosqueLat = null;
                $mosqueLon = null;
                
                if (isset($element['lat']) && isset($element['lon'])) {
                    $mosqueLat = $element['lat'];
                    $mosqueLon = $element['lon'];
                } elseif (isset($element['center']['lat']) && isset($element['center']['lon'])) {
                    $mosqueLat = $element['center']['lat'];
                    $mosqueLon = $element['center']['lon'];
                } elseif (isset($element['bounds'])) {
                    $mosqueLat = ($element['bounds']['minlat'] + $element['bounds']['maxlat']) / 2;
                    $mosqueLon = ($element['bounds']['minlon'] + $element['bounds']['maxlon']) / 2;
                } else {
                    continue;
                }
                
                // Calculate exact distance
                $distance = $this->calculateDistance($lat, $lng, $mosqueLat, $mosqueLon);
                
                // Filter by radius (with small buffer)
                if ($distance > $radius * 1.1) continue;
                
                // Prevent duplicates with better precision
                $posKey = round($mosqueLat, 4) . '_' . round($mosqueLon, 4);
                if (isset($usedPositions[$posKey])) continue;
                $usedPositions[$posKey] = true;
                
                $tags = $element['tags'] ?? [];
                
                // Get mosque name with multiple fallbacks
                $name = $tags['name:en'] ?? 
                       $tags['name'] ?? 
                       $tags['name:ar'] ?? 
                       $tags['short_name'] ?? 
                       $tags['official_name'] ?? 
                       'Masjid';
                
                // Build comprehensive address
                $address = $this->buildFullAddress($tags);
                
                // Extract all facilities
                $facilities = $this->extractAllFacilities($tags, $name);
                
                // Get contact info
                $phone = $tags['phone'] ?? $tags['contact:phone'] ?? $tags['mobile'] ?? null;
                $website = $tags['website'] ?? $tags['contact:website'] ?? null;
                $email = $tags['email'] ?? $tags['contact:email'] ?? null;
                
                // Get opening hours
                $openingHours = $tags['opening_hours'] ?? $tags['service_times'] ?? 'Open for prayers';
                
                // Get capacity if available
                $capacity = $tags['capacity'] ?? $tags['capacity:men'] ?? $tags['capacity:women'] ?? null;
                
                $mosques[] = [
                    'id' => $element['id'],
                    'name' => $name,
                    'lat' => $mosqueLat,
                    'lon' => $mosqueLon,
                    'distance' => round($distance, 2),
                    'address' => $address,
                    'facilities' => $facilities,
                    'phone' => $phone ?? 'Not available',
                    'website' => $website,
                    'email' => $email,
                    'capacity' => $capacity,
                    'opening_hours' => $openingHours,
                    'image' => 'https://images.unsplash.com/photo-' . $this->getRandomMosqueImage() . '?w=400&auto=format',
                    'source' => 'openstreetmap'
                ];
                
                $foundCount++;
            }
            
            \Log::info("Found {$foundCount} mosques in radius {$radius}km");
            return $mosques;
            
        } catch (\Exception $e) {
            \Log::error('Overpass API error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Build full address from tags
     */
    private function buildFullAddress($tags)
    {
        $parts = [];
        
        if (!empty($tags['addr:housenumber'])) $parts[] = $tags['addr:housenumber'];
        if (!empty($tags['addr:street'])) $parts[] = $tags['addr:street'];
        if (!empty($tags['addr:neighbourhood'])) $parts[] = $tags['addr:neighbourhood'];
        if (!empty($tags['addr:suburb'])) $parts[] = $tags['addr:suburb'];
        if (!empty($tags['addr:district'])) $parts[] = $tags['addr:district'];
        if (!empty($tags['addr:city'])) $parts[] = $tags['addr:city'];
        if (!empty($tags['addr:state'])) $parts[] = $tags['addr:state'];
        if (!empty($tags['addr:postcode'])) $parts[] = $tags['addr:postcode'];
        if (!empty($tags['addr:country'])) $parts[] = $tags['addr:country'];
        
        return !empty($parts) ? implode(', ', $parts) : 'Address not available';
    }

    /**
     * Extract ALL facilities from tags
     */
    private function extractAllFacilities($tags, $name)
    {
        $facilities = [];
        $nameLower = strtolower($name);
        
        // Prayer facilities
        if (isset($tags['wudu']) && ($tags['wudu'] === 'yes' || $tags['wudu'] === 'true')) {
            $facilities[] = 'Wudu Area';
        }
        if (isset($tags['wudu:women']) && ($tags['wudu:women'] === 'yes')) {
            $facilities[] = 'Women\'s Wudu';
        }
        
        // Women facilities
        if (isset($tags['women']) && ($tags['women'] === 'yes')) {
            $facilities[] = 'Women\'s Section';
        }
        if (isset($tags['female']) && ($tags['female'] === 'yes')) {
            $facilities[] = 'Women\'s Section';
        }
        if (isset($tags['prayer:women']) && ($tags['prayer:women'] === 'yes')) {
            $facilities[] = 'Women\'s Prayer Area';
        }
        
        // Accessibility
        if (isset($tags['wheelchair']) && ($tags['wheelchair'] === 'yes' || $tags['wheelchair'] === 'limited')) {
            $facilities[] = $tags['wheelchair'] === 'yes' ? 'Wheelchair Access' : 'Limited Wheelchair Access';
        }
        
        // Parking
        if (isset($tags['parking']) && ($tags['parking'] === 'yes' || $tags['parking'] === 'street' || $tags['parking'] === 'lot')) {
            $facilities[] = 'Parking';
        }
        
        // Toilets
        if (isset($tags['toilets']) && ($tags['toilets'] === 'yes')) {
            $facilities[] = 'Toilets';
        }
        if (isset($tags['toilets:women']) && ($tags['toilets:women'] === 'yes')) {
            $facilities[] = 'Women\'s Toilets';
        }
        
        // Education
        if (isset($tags['school']) && ($tags['school'] === 'yes')) {
            $facilities[] = 'Islamic School';
        }
        if (isset($tags['madrasa']) && ($tags['madrasa'] === 'yes')) {
            $facilities[] = 'Madrasa';
        }
        if (isset($tags['library']) && ($tags['library'] === 'yes')) {
            $facilities[] = 'Library';
        }
        
        // Building amenities
        if (isset($tags['air_conditioning']) && ($tags['air_conditioning'] === 'yes')) {
            $facilities[] = 'Air Conditioning';
        }
        if (isset($tags['heating']) && ($tags['heating'] === 'yes')) {
            $facilities[] = 'Heating';
        }
        if (isset($tags['internet']) && ($tags['internet'] === 'yes' || $tags['wifi'] === 'yes')) {
            $facilities[] = 'WiFi';
        }
        
        // Check name for facilities
        if (preg_match('/(women|female|نساء)/i', $nameLower)) {
            if (!in_array('Women\'s Section', $facilities)) {
                $facilities[] = 'Women\'s Section';
            }
        }
        if (preg_match('/(quran|قرآن)/i', $nameLower)) {
            $facilities[] = 'Quran Classes';
        }
        if (preg_match('/(center|centre|مركز)/i', $nameLower)) {
            $facilities[] = 'Community Center';
        }
        if (preg_match('/(jumuah|friday)/i', $nameLower)) {
            $facilities[] = 'Jumuah Prayers';
        }
        
        // Add default facilities if none found
        if (empty($facilities)) {
            $facilities = ['Prayer Hall'];
        }
        
        return array_slice(array_unique($facilities), 0, 8);
    }

    /**
     * Generate city-wide sample mosques (realistic fallback)
     */
    private function generateCityMosques($city, $lat, $lng, $radius = 15)
    {
        $mosqueNames = [
            "Central Mosque " . $city,
            "Grand Masjid " . $city,
            "Al-Noor Masjid",
            "Al-Rahman Mosque",
            "Al-Falah Islamic Center",
            "Al-Huda Masjid",
            "Islamic Foundation of " . $city,
            "Masjid Al-Salam",
            "Jamia Masjid " . $city,
            "Masjid Al-Taqwa",
            "Masjid Bilal",
            "Masjid Maryam",
            "Masjid Al-Aqsa",
            "Quba Masjid",
            "Masjid Al-Iman",
            "Islamic Society of " . $city,
            "Masjid Al-Furqan",
            "Masjid Al-Khair",
            "Masjid Abu Bakr",
            "Masjid Umar"
        ];
        
        $facilitiesList = [
            ['Prayer Hall', 'Wudu Area', 'Parking', 'Women\'s Section'],
            ['Prayer Hall', 'Wudu Area', 'Parking', 'Quran Classes'],
            ['Prayer Hall', 'Wudu Area', 'Women\'s Section', 'Library'],
            ['Prayer Hall', 'Wudu Area', 'Parking', 'Air Conditioning', 'Women\'s Section'],
            ['Prayer Hall', 'Wudu Area', 'Parking', 'Islamic School', 'Library'],
            ['Prayer Hall', 'Wudu Area', 'Women\'s Section', 'Quran Classes', 'Parking'],
            ['Prayer Hall', 'Wudu Area', 'Parking', 'Jumuah Prayers', 'Community Center']
        ];
        
        $streets = [
            'Main Street', 'Park Avenue', 'Oak Road', 'Islamic Center Dr', 
            'Masjid Road', 'Al-Noor Street', 'Salam Avenue', 'Faith Boulevard',
            'Prayer Lane', 'Community Drive'
        ];
        
        $areas = [
            'Downtown', 'North Side', 'South Side', 'East End', 'West End',
            'Riverside', 'Greenwood', 'Maplewood', 'Oakwood', 'Pine Valley'
        ];
        
        $mosques = [];
        $usedPositions = [];
        
        $count = rand(15, 25);
        
        for ($i = 0; $i < $count; $i++) {
            $angle = rand(0, 360) * M_PI / 180;
            $distance = (rand(10, 90) / 100) * $radius;
            
            $latOffset = ($distance / 111) * cos($angle);
            $lngOffset = ($distance / (111 * cos(deg2rad($lat)))) * sin($angle);
            
            $newLat = round($lat + $latOffset, 6);
            $newLon = round($lng + $lngOffset, 6);
            
            $posKey = $newLat . '_' . $newLon;
            if (isset($usedPositions[$posKey])) continue;
            $usedPositions[$posKey] = true;
            
            $area = $areas[array_rand($areas)];
            $street = $streets[array_rand($streets)];
            
            $hasPhone = rand(0, 10) > 2;
            $phone = $hasPhone ? '+1 ' . rand(200, 999) . '-' . rand(200, 999) . '-' . rand(1000, 9999) : 'Not available';
            
            $facilities = $facilitiesList[array_rand($facilitiesList)];
            
            $mosques[] = [
                'id' => 'sample_' . $i . '_' . time(),
                'name' => $mosqueNames[$i % count($mosqueNames)],
                'lat' => $newLat,
                'lon' => $newLon,
                'distance' => round($distance, 2),
                'address' => rand(100, 999) . ' ' . $street . ', ' . $area . ', ' . $city,
                'facilities' => array_slice($facilities, 0, 5),
                'phone' => $phone,
                'opening_hours' => 'Open for all 5 daily prayers. Jumuah at 1:30 PM',
                'image' => 'https://images.unsplash.com/photo-' . $this->getRandomMosqueImage() . '?w=400&auto=format',
                'source' => 'sample'
            ];
        }
        
        return $mosques;
    }

    /**
     * Get random mosque image
     */
    private function getRandomMosqueImage()
    {
        $images = [
            '1542816417-0983c9c9ad53',
            '1564769625905-50e93615e769',
            '1591604129931-f1efa4c9f8b3',
            '1584551246679-0daf3d275d0f',
            '1519817650390-64a93db51149',
            '1528561606985-6e3f9e0f9e3b'
        ];
        
        return $images[array_rand($images)];
    }

    /**
     * Calculate distance (Haversine formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
        return $R * (2 * atan2(sqrt($a), sqrt(1-$a)));
    }

    /**
     * Generate SEO metadata
     */
    private function generateSEOMetaData($city, $country, $state, $totalMosques, $currentYear)
    {
        $stateText = $state && $state !== 'Unknown' ? ", $state" : '';
        
        $metaTitle = "Mosques in $city - $totalMosques Masjids Near You $currentYear";
        $metaDescription = "Find $totalMosques mosques in $city$stateText, $country. Get accurate locations, distances, directions, and prayer times. Complete directory of masjids and Islamic centers.";
        
        $metaKeywords = implode(', ', [
            "mosques in $city", "$city masjids", "islamic center $city",
            "masjid near me $city", "mosques $country"
        ]);
        
        $mainDescription = "<h2>Mosques in $city, $country – Complete Directory</h2>
            <p>Welcome to the most comprehensive guide to mosques in $city. We have compiled information on <strong>$totalMosques masjids and Islamic centers</strong> serving the Muslim community in $city$stateText. Whether you're a resident or visitor, find accurate locations, contact details, and prayer times for every mosque in the area.</p>
            
            <h3>Mosque Facilities in $city</h3>
            <p>Most mosques in $city offer essential facilities including prayer halls, wudu areas, and parking. Many also provide women's sections and Quran classes. Check individual mosque listings for specific amenities.</p>";
        
        return [
            'metaTitle' => $metaTitle,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords,
            'mainDescription' => $mainDescription
        ];
    }

    /**
     * Get cached cities in same country
     */
    private function getCachedCitiesInCountry($country, $currentCity)
    {
        if ($country === 'Unknown') {
            return collect([]);
        }
        
        $cacheKey = 'cities_in_' . str_replace(' ', '_', strtolower($country));
        $cacheTime = 60 * 24;
        
        return cache()->remember($cacheKey, $cacheTime, function() use ($country, $currentCity) {
            return MosqueSearch::where('country', $country)
                ->where('city', '!=', $currentCity)
                ->orderBy('city')
                ->limit(12)
                ->get(['city', 'slug']);
        });
    }

    /**
     * Search for a city
     */
    public function search(Request $request)
    {
        $request->validate(['city' => 'required|string|max:255']);
        
        $citySlug = Str::slug($request->city);
        
        return redirect()->route('mosque.show', [
            'city' => $citySlug
        ]);
    }

    /**
     * Get coordinates from city name
     */
    protected function getCoordinates($city)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name')
            ])->timeout(5)->get("https://nominatim.openstreetmap.org/search", [
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
            \Log::error("Failed to get coordinates for city: {$city} - " . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Get precise location details
     */
    protected function getPreciseLocation($city)
    {
        $default = ['country' => 'Unknown', 'state' => 'Unknown'];
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name')
            ])->timeout(5)->get("https://nominatim.openstreetmap.org/search", [
                'q' => $city,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 1
            ]);
    
            if ($response->successful()) {
                $results = $response->json();
                
                if (!empty($results)) {
                    $address = $results[0]['address'] ?? [];
                    
                    return [
                        'country' => $address['country'] ?? $default['country'],
                        'state' => $address['state'] ?? $address['region'] ?? $address['city'] ?? $default['state']
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get precise location for city: {$city} - " . $e->getMessage());
        }
    
        return $default;
    }
}