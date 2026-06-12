<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PrayerSearch;
use Illuminate\Support\Str;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Log;

class PrayerTimeController extends Controller
{
    /**
     * List of supported languages
     */
    protected $supportedLanguages = [
        "en", "ar", "zh", "hi", "es", "fr", "ru", "pt", "ur", "bn",
        "pa", "ta", "te", "mr", "gu", "kn", "ml", "si", "id", "ms",
        "th", "vi", "fil", "fa", "tr", "ku", "ps", "sd", "sw", "ha",
        "am", "yo", "ja", "ko", "de", "it", "nl", "ug", "az", "kk",
        "uz", "ky", "tg", "tk", "dv", "so", "ber",
    ];

    public function index()
    {
        $recentSearches = PrayerSearch::latest()
            ->take(5)
            ->get(["city", "country", "created_at"]);
        return view("index", compact("recentSearches"));
    }

    /**
     * Show prayer times by city slug
     */
    public function showBySlug($firstParameter, $secondParameter = null)
    {
        try {
            // Determine if we have language parameter or not
            if ($firstParameter && in_array($firstParameter, $this->supportedLanguages)) {
                $citySlug = $secondParameter;
                $lang = $firstParameter;
                
                if (!$citySlug) {
                    return redirect('/');
                }
            } else {
                $citySlug = $firstParameter;
                $lang = null;
            }

            // Process city name - remove any prefix and clean
            $citySlug = trim(str_replace("prayer-times-in-", "", $citySlug), '/');
            
            if (empty($citySlug)) {
                return redirect('/');
            }

            $city = str_replace("-", " ", $citySlug);
            $city = ucwords(strtolower($city));
            
            // Handle special cases like "Al Jazeera"
            $city = preg_replace_callback(
                "/\b(al|el)\b/i",
                function ($matches) {
                    return ucfirst(strtolower($matches[0]));
                },
                $city
            );

            // Generate slug for database lookup
            $slug = "prayer-times-in-" . strtolower(str_replace(" ", "-", $city));

            // Check if data already exists in database
            $existingData = PrayerSearch::where("slug", $slug)->first();

            if ($existingData) {
                // Check if meta description needs update (older than 30 days or missing prayer times)
                $timings = json_decode($existingData->timings ?? "{}", true);
                $needsUpdate = $this->checkIfMetaNeedsUpdate($existingData, $timings);
                
                $meta_title = $existingData->meta_title;
                $meta_description = $existingData->meta_description;
                $meta_keywords = $existingData->meta_keywords;
                
                if ($needsUpdate) {
                    // Regenerate meta data
                    $location = [
                        'country' => $existingData->country,
                        'state' => $existingData->state
                    ];
                    $method = $existingData->Cal_Method;
                    
                    $newMetaData = $this->generateMetaData(
                        $existingData->city, 
                        $location, 
                        $method, 
                        $timings
                    );
                    
                    // Update the record
                    $existingData->update([
                        'meta_title' => $newMetaData['meta_title'],
                        'meta_description' => $newMetaData['meta_description'],
                        'meta_keywords' => $newMetaData['meta_keywords'],
                        'updated_at' => now()
                    ]);
                    
                    $meta_title = $newMetaData['meta_title'];
                    $meta_description = $newMetaData['meta_description'];
                    $meta_keywords = $newMetaData['meta_keywords'];
                    
                    Log::info("Updated meta data for {$existingData->city}");
                }

                // Get other cities in same country
                $citiesInCountry = PrayerSearch::where("country", $existingData->country)
                    ->where("city", "!=", $existingData->city)
                    ->orderBy("city")
                    ->limit(20)
                    ->get();

                return view("city-prayer-times", [
                    "timings" => $timings,
                    "date" => $existingData->date ?? now()->format("d M Y"),
                    "city" => $existingData->city,
                    "description" => $existingData->description,
                    "meta_title" => $meta_title,
                    "meta_description" => $meta_description,
                    "meta_keywords" => $meta_keywords,
                    "state" => $existingData->state,
                    "country" => $existingData->country,
                    "method" => $existingData->Cal_Method,
                    'timezone' => $existingData->timezone,
                    "citiesInCountry" => $citiesInCountry,
                    "lang" => $lang,
                ]);
            }

            // If data doesn't exist, fetch from API
            return $this->fetchAndStorePrayerTimes($city, $slug, $lang);

        } catch (\Exception $e) {
            Log::error('PrayerTimeController error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Unable to fetch prayer times. Please try again.');
        }
    }

    /**
     * Check if meta data needs update
     */
    protected function checkIfMetaNeedsUpdate($record, $timings)
    {
        // Check if record is older than 30 days
        if ($record->updated_at < now()->subDays(30)) {
            return true;
        }
        
        // Check if meta description contains actual prayer times
        $oldMetaDesc = $record->meta_description ?? '';
        $fajrTime = $timings['Fajr'] ?? '';
        
        // If Fajr time exists but not in meta description, update it
        if (!empty($fajrTime) && !str_contains($oldMetaDesc, $fajrTime)) {
            return true;
        }
        
        // Check if meta description contains all prayer names
        $requiredPrayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        foreach ($requiredPrayers as $prayer) {
            if (!str_contains($oldMetaDesc, $prayer)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Fetch prayer times from API and store in database
     */
    protected function fetchAndStorePrayerTimes($city, $slug, $lang)
    {
        try {
            // Fetch from API with timeout
            $response = Http::timeout(10)->get(
                "http://api.aladhan.com/v1/timingsByCity",
                [
                    "city" => $city,
                    "country" => "",
                    "method" => 4,
                ]
            );

            if (!$response->successful()) {
                throw new \Exception("API request failed with status: " . $response->status());
            }

            $data = $response->json();
            
            if (!isset($data['data'])) {
                throw new \Exception("Invalid API response structure");
            }

            // Get location data
            $location = $this->getPreciseLocation($city);
            
            $method = $data["data"]["meta"]["method"]["name"] ?? "Muslim World League";
            $timezone = $data["data"]["meta"]["timezone"] ?? "UTC";
            $timings = $data["data"]["timings"];

            // Generate SEO description
            $description = $this->generateDescription($city, $location, $method, $timings);

            // Generate meta data
            $metaData = $this->generateMetaData($city, $location, $method, $timings);

            // Save to database
            PrayerSearch::updateOrCreate(
                ["slug" => $slug],
                [
                    "city" => $city,
                    "state" => $location["state"],
                    "country" => $location["country"],
                    "timezone" => $timezone,
                    "slug" => $slug,
                    "Cal_Method" => $method,
                    "description" => $description,
                    "meta_title" => $metaData['meta_title'],
                    "meta_description" => $metaData['meta_description'],
                    "meta_keywords" => $metaData['meta_keywords'],
                    "timings" => json_encode($timings),
                    "date" => $data["data"]["date"]["readable"],
                ]
            );

            // Get other cities in same country
            $citiesInCountry = PrayerSearch::where("country", $location["country"])
                ->where("city", "!=", $city)
                ->orderBy("city")
                ->limit(20)
                ->get();

            return view("city-prayer-times", [
                "timings" => $timings,
                "date" => $data["data"]["date"]["readable"],
                "city" => $city,
                "description" => $description,
                "meta_title" => $metaData['meta_title'],
                "meta_description" => $metaData['meta_description'],
                "meta_keywords" => $metaData['meta_keywords'],
                "state" => $location["state"],
                "country" => $location["country"],
                "method" => $method,
                'timezone' => $timezone,
                "citiesInCountry" => $citiesInCountry,
                "lang" => $lang,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch prayer times for ' . $city . ': ' . $e->getMessage());
            
            // Try to find fallback data
            $fallbackData = PrayerSearch::where("city", "LIKE", "%{$city}%")->first();
            
            if ($fallbackData) {
                // Check if fallback data needs update
                $timings = json_decode($fallbackData->timings ?? "{}", true);
                $needsUpdate = $this->checkIfMetaNeedsUpdate($fallbackData, $timings);
                
                $meta_title = $fallbackData->meta_title;
                $meta_description = $fallbackData->meta_description;
                $meta_keywords = $fallbackData->meta_keywords;
                
                if ($needsUpdate) {
                    $location = [
                        'country' => $fallbackData->country,
                        'state' => $fallbackData->state
                    ];
                    
                    $newMetaData = $this->generateMetaData(
                        $fallbackData->city,
                        $location,
                        $fallbackData->Cal_Method,
                        $timings
                    );
                    
                    $fallbackData->update([
                        'meta_title' => $newMetaData['meta_title'],
                        'meta_description' => $newMetaData['meta_description'],
                        'meta_keywords' => $newMetaData['meta_keywords'],
                        'updated_at' => now()
                    ]);
                    
                    $meta_title = $newMetaData['meta_title'];
                    $meta_description = $newMetaData['meta_description'];
                    $meta_keywords = $newMetaData['meta_keywords'];
                }
                
                return view("city-prayer-times", [
                    "timings" => $timings,
                    "date" => $fallbackData->date ?? now()->format("d M Y"),
                    "city" => $fallbackData->city,
                    "description" => $fallbackData->description,
                    "meta_title" => $meta_title,
                    "meta_description" => $meta_description,
                    "meta_keywords" => $meta_keywords,
                    "state" => $fallbackData->state,
                    "country" => $fallbackData->country,
                    "method" => $fallbackData->Cal_Method,
                    'timezone' => $fallbackData->timezone,
                    "citiesInCountry" => [],
                    "lang" => $lang,
                ]);
            }
            
            return redirect('/')->with('error', 'Could not find prayer times for ' . $city);
        }
    }

    /**
     * Generate SEO-friendly description
     */
    protected function generateDescription($city, $location, $method, $timings)
    {
        $blocks = [
            // Block 1 - Complete prayer schedule with H2
            "<h2>Today's Prayer Schedule in <span style=\"color: var(--primary-color);\">:city</span>, <span style=\"color: var(--primary-color);\">:country</span></h2>
            <p>For Muslims in <strong>:city</strong>, the five daily prayers follow a precise schedule. Today's timings are <strong>Fajr :fajr</strong>, <strong>Dhuhr :dhuhr</strong>, <strong>Asr :asr</strong>, <strong>Maghrib :maghrib</strong>, and <strong>Isha :isha</strong>. These accurate timings help you maintain your daily prayers consistently throughout the year.</p>
            <h6>Finding your direction</h6>
            <p>Before praying, ensure you're facing the right direction. Check the <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction for :city</a> to know exactly where to face during your Salah.</p>",
            
            // Block 2 - Calculation method with H2 and H3
            "<h2>Prayer Time Calculation Method for <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Muslims in <strong>:city</strong> follow the <strong><em>:method</em></strong> calculation method to ensure prayers are offered at the scientifically correct times based on the sun's position. This method is trusted by Islamic scholars worldwide and provides accurate Salah timings for :city residents.</p>
            <h3>About prayer direction in :city</h3>
            <p>Knowing the correct prayer times is essential, but so is facing the right direction. The <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction for :city</a> helps you align with the Holy Kaaba in Mecca for every prayer.</p>",
            
            // Block 3 - Daily updates with H2 and H3
            "<h2>Daily Updated Prayer Timings for <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Daily prayer timings are updated automatically for <strong>:city</strong>, allowing easy reference for each Salah without manual calculations. Whether you need Fajr time or Isha time, our system provides real-time accuracy based on your location.</p>
            <h3>Prayer times and direction together</h3>
            <p>Complete your prayer preparation by checking both timings and direction. Visit our <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla guide for :city</a> to ensure you're always facing the Kaaba during Salah.</p>",
            
            // Block 4 - Seasonal variations with H2 and H3
            "<h2>How Seasons Affect Prayer Times in <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Seasonal variations in <strong>:city</strong> naturally affect prayer times, particularly during long summer days or short winter daylight periods. Fajr arrives earlier in summer, while Maghrib shifts significantly with sunset changes throughout the year.</p>
            <h3>Qibla remains constant throughout the year</h3>
            <p>Unlike prayer times, the <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction for :city</a> stays the same year-round at approximately :qibla_degrees degrees. This consistency helps you permanently mark the prayer direction in your home.</p>",
            
            // Block 5 - Spiritual benefits with H2 and H3
            "<h2>Spiritual Benefits of Regular Salah in <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Maintaining regular Salah in <strong>:city</strong> strengthens your connection with Allah and provides a structured, purposeful day. Each of the five prayers offers a unique opportunity for reflection and spiritual growth.</p>
            <h3>Salah times for :city</h3>
            <ul>
                <li><strong>Fajr :fajr</strong> – Start your day with divine remembrance before dawn</li>
                <li><strong>Dhuhr :dhuhr</strong> – Midday spiritual refreshment during work hours</li>
                <li><strong>Asr :asr</strong> – Afternoon moment of peace and reflection</li>
                <li><strong>Maghrib :maghrib</strong> – Gratitude for the day's blessings at sunset</li>
                <li><strong>Isha :isha</strong> – Peaceful conclusion to the day in :city</li>
            </ul>
            <p>Make sure you're facing the right way by checking the <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction for :city</a> before each prayer.</p>",
            
            // Block 6 - Local mosques with H2 and H3
            "<h2>Mosques and Prayer Communities in <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p><strong>:city</strong> is home to several mosques where the Muslim community gathers for daily prayers. These Islamic centers follow the <strong>:method</strong> calculation for congregational prayers, ensuring unity in worship times across the city.</p>
            <h3>Find your direction at local mosques</h3>
            <p>All mosques in :city are built facing the Kaaba. You can verify your <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction</a> by observing the prayer lines (sutrah) at your local mosque.</p>",
            
            // Block 7 - Technology with H2 and H3
            "<h2>Using Technology for Accurate Prayer Times in <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Modern technology makes it easier than ever to track prayer times in <strong>:city</strong>. Our website uses GPS coordinates and the <strong>:method</strong> calculation to provide real-time accuracy for all five daily prayers.</p>
            <h3>Digital Qibla finder for :city</h3>
            <p>Beyond prayer times, our <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction tool</a> helps you find the exact angle to face during Salah using your device's compass. Perfect for home, work, or travel.</p>",
            
            // Block 8 - Family with H2 and H3
            "<h2>Teaching Children About Prayer in <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>For families in <strong>:city</strong>, instilling prayer habits in children is essential. Our easy-to-read prayer times help parents teach kids the importance of each Salah and when to pray throughout the day.</p>
            <h3>Teaching Qibla direction to children</h3>
            <p>Help your children learn the <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">correct direction for :city</a> using simple landmarks or our online compass. Making prayer a family activity strengthens faith and creates lasting memories.</p>",
            
            // Block 9 - Travel with H2 and H3
            "<h2>Prayer Times for Travelers Visiting <span style=\"color: var(--primary-color);\">:city</span></h2>
            <p>Whether you're visiting <strong>:city</strong> for business or leisure, maintaining your prayers is easy with our accurate local timings. Travelers can rely on our updated prayer schedule to stay connected with their faith.</p>
            <h3>Qibla for travelers in :city</h3>
            <p>When in a new place, finding the right direction can be challenging. Our <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla finder for :city</a> works instantly on any device, helping you pray correctly wherever you are.</p>",
            
            // Block 10 - Prayer times overview with H2 and H3
            "<h2>Salah Times for <span style=\"color: var(--primary-color);\">:city</span> Residents</h2>
            <p>Knowing your daily prayer times is fundamental for every Muslim in <strong>:city</strong>. Today's schedule includes <strong>Fajr :fajr</strong>, <strong>Dhuhr :dhuhr</strong>, <strong>Asr :asr</strong>, <strong>Maghrib :maghrib</strong>, and <strong>Isha :isha</strong>.</p>
            <h3>Complete your prayer with correct Qibla</h3>
            <p>Having the right time is only half the preparation. Make sure you're also facing the Holy Kaaba by checking the <a href=\"/:city-qibla-direction\" style=\"color: var(--primary-color); text-decoration: none; font-weight: 500;\">Qibla direction for :city</a> before you begin your Salah.</p>"
        ];

        // Randomly select blocks and combine
        shuffle($blocks);
        
        $description = "";
        foreach (array_slice($blocks, 0, 3) as $block) {
            $description .= str_replace(
                [":city", ":country", ":method", ":fajr", ":dhuhr", ":asr", ":maghrib", ":isha"],
                [
                    $city,
                    $location["country"] ?? $location["country"],
                    $method,
                    $timings['Fajr'] ?? '--:--',
                    $timings['Dhuhr'] ?? '--:--',
                    $timings['Asr'] ?? '--:--',
                    $timings['Maghrib'] ?? '--:--',
                    $timings['Isha'] ?? '--:--'
                ],
                $block
            ) . " ";
        }
        
        return trim($description);
    }

    /**
     * Generate meta data with dynamic variations - ALL include prayer times
     */
    protected function generateMetaData($city, $location, $method, $timings)
    {
        $country = $location["country"] ?? "Unknown";
        $state = $location["state"] ?? "Unknown";
        $today = now()->format('l');
        $date = now()->format('d M Y');
        
        // Domain name for mentions
        $domain = "nextprayertime";
        $domains = [$domain, "nextprayertime", "nextprayertime", "nextprayertime"];
        $currentDomain = $domains[array_rand($domains)];
        
        // Get prayer times for inclusion - ALWAYS INCLUDED IN EVERY VARIANT
        $fajr = $timings['Fajr'] ?? '--:--';
        $dhuhr = $timings['Dhuhr'] ?? '--:--';
        $asr = $timings['Asr'] ?? '--:--';
        $maghrib = $timings['Maghrib'] ?? '--:--';
        $isha = $timings['Isha'] ?? '--:--';
        
        $prayerTimesString = "Fajr $fajr, Dhuhr $dhuhr, Asr $asr, Maghrib $maghrib, Isha $isha";
        
        // Meta Title Variants
        $meta_title_variants = [
            "Prayer Times in $city Today | $today Namaz Schedule $date",
            "$city Prayer Times Today – Fajr to Isha Timings",
            "Today Prayer Times in $city | Islamic Salah Schedule",
            "Prayer Times in $city ($country) – Daily Namaz Timings",
            "$city Azan Times Today | Complete Prayer Schedule",
            "When to Pray in $city? | Today's Complete Prayer Guide",
            "$city Islamic Prayer Times | $country",
            "Daily Salah Schedule for $city | $today $date",
            "$city Prayer Timings | Fajr, Dhuhr, Asr, Maghrib, Isha",
            "Accurate Prayer Times in $city | $method Method",
            "$city Namaz Times Today | Updated Daily",
            "Islamic Prayer Times for $city, $country",
            "$city Salah Times | $today's Complete Schedule",
            "Prayer Times $city | Fajr to Isha Timings",
            "Today's Namaz Time in $city | $date"
        ];
        
        // Meta Description Variants - EVERY SINGLE ONE includes prayer times
        $meta_description_variants = [
            // Variant 1
            "Check Prayer Times in $city on $currentDomain. Today's schedule: $prayerTimesString. Updated daily using $method calculation.",
            
            // Variant 2
            "Looking for accurate $city prayer times? Today's complete schedule: $prayerTimesString. Precise timings for all five daily prayers. Updated automatically.",
            
            // Variant 3
            "Today's prayer times in $city: $prayerTimesString. Accurate Islamic timings based on $method calculation.",
            
            // Variant 4
            "Find precise $city prayer times with automatic daily updates. Today's schedule: $prayerTimesString. Never miss your Salah with accurate Fajr to Isha timings.",
            
            // Variant 5
            "Muslims in $city, $country can now get accurate daily prayer times. Today's schedule: $prayerTimesString. Calculated using $method method.",
            
            // Variant 6
            "Plan your $today worship in $city with accurate prayer times. Complete schedule: $prayerTimesString.",
            
            // Variant 7
            "$city prayer times on $currentDomain – your trusted source. Today: $prayerTimesString. Updated daily.",
            
            // Variant 8
            "Complete prayer schedule for $city, $state, $country. Today's accurate Namaz timings: $prayerTimesString. Perfect for daily worship planning.",
            
            // Variant 9
            "Accurate $city prayer times using $method calculation. Today's schedule: $prayerTimesString.",
            
            // Variant 10
            "$city prayer times for $today: $prayerTimesString. Never miss your prayers with $currentDomain.",
            
            // Variant 11
            "Find today's accurate prayer times in $city on $currentDomain. Today's schedule: $prayerTimesString. Using $method method.",
            
            // Variant 12
            "$city Namaz Times – Today's complete schedule: $prayerTimesString. Updated daily!",
            
            // Variant 13
            "Trusted prayer times for $city, $country. Today's accurate Islamic timings: $prayerTimesString. Updated automatically every day.",
            
            // Variant 14
            "Check today's complete prayer schedule in $city. Accurate timings: $prayerTimesString. Plan your day around Salah.",
            
            // Variant 15
            "Leading source for $city, $country prayer times. Today's accurate timings: $prayerTimesString. Using $method calculation.",
            
            // Variant 16
            (in_array(now()->dayOfWeek, [5,6]) ? "Weekend" : "Weekday") . " prayer times for $city: $prayerTimesString. Plan your worship accordingly.",
            
            // Variant 17
            "Complete guide to daily prayers in $city. Today's timings: $prayerTimesString. Updated using $method method.",
            
            // Variant 18
            "$city prayer times for today: $prayerTimesString. Accurate Fajr, Dhuhr, Asr, Maghrib and Isha timings. Updated daily.",
            
            // Variant 19
            "Prayer times in $city for $date: $prayerTimesString. Reliable Islamic timings.",
            
            // Variant 20
            "$currentDomain presents accurate prayer times for $city. Today's schedule: $prayerTimesString."
        ];
        
        // Create dynamic keywords with location variations
        $keyword_base = [
            "prayer times in $city",
            "$city namaz time",
            "$city salah schedule",
            "today prayer $city",
            "fajr time $city $fajr",
            "dhuhr time $city $dhuhr",
            "asr time $city $asr", 
            "maghrib time $city $maghrib",
            "isha time $city $isha",
            "islamic prayer $city",
            "$city azan time",
            "$city $country prayer",
            "$state prayer times",
            "daily prayer $city",
            "$city salat time",
            "Fajr $fajr $city",
            "Dhuhr $dhuhr $city",
            "Asr $asr $city",
            "Maghrib $maghrib $city",
            "Isha $isha $city"
        ];
        
        // Shuffle and select random keywords
        shuffle($keyword_base);
        $selected_keywords = array_slice($keyword_base, 0, 12);
        $meta_keywords = implode(", ", $selected_keywords);
        
        return [
            'meta_title' => $meta_title_variants[array_rand($meta_title_variants)],
            'meta_description' => $meta_description_variants[array_rand($meta_description_variants)],
            'meta_keywords' => $meta_keywords
        ];
    }

    /**
     * Get precise location from Nominatim API
     */
    protected function getPreciseLocation($city)
    {
        $default = ["country" => "Unknown", "state" => "Unknown"];

        try {
            $geoResponse = Http::timeout(5)
                ->withHeaders([
                    "User-Agent" => "PrayerTimeApp/1.0",
                    "Accept-Language" => "en",
                ])
                ->get("https://nominatim.openstreetmap.org/search", [
                    "q" => $city,
                    "format" => "json",
                    "addressdetails" => 1,
                    "limit" => 5,
                ]);

            if ($geoResponse->successful()) {
                $results = $geoResponse->json();

                // Prioritize Saudi Arabia cities
                foreach ($results as $result) {
                    $address = $result["address"] ?? [];
                    $displayName = $result["display_name"] ?? "";

                    if (stripos($displayName, "$city, Saudi Arabia") !== false) {
                        return [
                            "country" => $address["country"] ?? "Saudi Arabia",
                            "state" => $address["state"] ?? ($address["region"] ?? "Unknown"),
                        ];
                    }
                }

                // Return first valid result
                if (!empty($results)) {
                    $address = $results[0]["address"] ?? [];
                    return [
                        "country" => $address["country"] ?? $default["country"],
                        "state" => $address["state"] ?? ($address["region"] ?? $default["state"]),
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error('Location API error: ' . $e->getMessage());
        }

        return $default;
    }

    /**
     * Search for city and redirect
     */
    public function search(Request $request)
    {
        $request->validate([
            "city" => "required|string|max:255"
        ]);

        $citySlug = Str::slug($request->city);
        
        return redirect()->route('prayer-times.show', [
            'firstParameter' => 'prayer-times-in-' . $citySlug
        ]);
    }

    /**
     * Add minutes to time string
     */
    protected function addMinutesToTime($time, $minutesToAdd)
    {
        try {
            $date = new DateTime($time);
            $date->add(new DateInterval("PT" . $minutesToAdd . "M"));
            return $date->format("h:i A");
        } catch (\Exception $e) {
            return $time;
        }
    }

    /**
     * BULK UPDATE METHOD - Run this command to update all meta descriptions
     * 
     * HOW TO RUN:
     * Method 1: Via Tinker (Recommended)
     * php artisan tinker
     * >>> $controller = app()->make('App\Http\Controllers\PrayerTimeController');
     * >>> $controller->bulkUpdateMetaDescriptions();
     * 
     * Method 2: Via Route (Temporary)
     * Add this route in web.php:
     * Route::get('/update-meta', function() {
     *     $controller = new App\Http\Controllers\PrayerTimeController();
     *     return $controller->bulkUpdateMetaDescriptions();
     * });
     * 
     * Method 3: Via Command (If you want to create an Artisan command)
     */
    /**
 * BULK UPDATE METHOD - Run this command to update all meta descriptions
 */
public function bulkUpdateMetaDescriptions()
{
    $startTime = microtime(true);
    $records = PrayerSearch::all();
    $total = $records->count();
    $updated = 0;
    $skipped = 0;
    $errors = 0;
    
    $output = [];
    $output[] = "Starting bulk update of meta descriptions...";
    $output[] = "Total records found: $total";
    $output[] = str_repeat('-', 50);
    
    foreach ($records as $index => $record) {
        try {
            // Try to get timings from database first
            $timings = json_decode($record->timings ?? '{}', true);
            
            // If timings are empty or invalid, fetch fresh from API
            if (empty($timings) || !isset($timings['Fajr'])) {
                $output[] = "[INFO] {$record->city}: Fetching fresh timings from API...";
                
                // Fetch fresh data from API
                $response = Http::timeout(10)->get(
                    "http://api.aladhan.com/v1/timingsByCity",
                    [
                        "city" => $record->city,
                        "country" => $record->country ?? "",
                        "method" => 4,
                    ]
                );
                
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['data']['timings'])) {
                        $timings = $data['data']['timings'];
                        
                        // Update the record with fresh timings
                        $record->update([
                            'timings' => json_encode($timings),
                            'date' => $data['data']['date']['readable'] ?? now()->format('d M Y'),
                        ]);
                        
                        $output[] = "[INFO] {$record->city}: Fetched fresh timings successfully";
                    } else {
                        throw new \Exception("Invalid API response");
                    }
                } else {
                    throw new \Exception("API request failed");
                }
            }
            
            // Skip if still no timings
            if (empty($timings)) {
                $skipped++;
                $output[] = "[SKIP] {$record->city}: No timings data available";
                continue;
            }
            
            // Prepare location data
            $location = [
                'country' => $record->country ?? 'Unknown',
                'state' => $record->state ?? 'Unknown'
            ];
            
            // Get method from record or use default
            $method = $record->Cal_Method ?? 'Muslim World League';
            
            // Generate new meta data (random each time)
            $newMetaData = $this->generateMetaData(
                $record->city,
                $location,
                $method,
                $timings
            );
            
            // Store old values for logging
            $oldDesc = $record->meta_description;
            $newDesc = $newMetaData['meta_description'];
            
            // Update the record
            $record->update([
                'meta_title' => $newMetaData['meta_title'],
                'meta_description' => $newMetaData['meta_description'],
                'meta_keywords' => $newMetaData['meta_keywords'],
                'updated_at' => now()
            ]);
            
            $updated++;
            
            // Show update details
            $output[] = "[UPDATE] {$record->city}: Meta description updated";
            $output[] = "   Old: " . substr($oldDesc ?? 'N/A', 0, 50) . "...";
            $output[] = "   New: " . substr($newDesc, 0, 50) . "...";
            
        } catch (\Exception $e) {
            $errors++;
            $output[] = "[ERROR] {$record->city}: " . $e->getMessage();
        }
    }
    
    $endTime = microtime(true);
    $executionTime = round($endTime - $startTime, 2);
    
    $output[] = str_repeat('-', 50);
    $output[] = "BULK UPDATE COMPLETED!";
    $output[] = "Total records: $total";
    $output[] = "Updated: $updated";
    $output[] = "Skipped: $skipped";
    $output[] = "Errors: $errors";
    $output[] = "Execution time: {$executionTime} seconds";
    
    // Log the results
    Log::info('Bulk meta update completed', [
        'total' => $total,
        'updated' => $updated,
        'skipped' => $skipped,
        'errors' => $errors,
        'time' => $executionTime
    ]);
    
    // Return as string if called via command line
    if (app()->runningInConsole()) {
        return implode("\n", $output);
    }
    
    // Return as HTML if called via browser
    return response()->make(
        '<pre>' . implode("\n", $output) . '</pre>',
        200,
        ['Content-Type' => 'text/html']
    );
}

    /**
     * Selective update - Update only records older than X days
     */
    public function updateOldMetaDescriptions($days = 30)
    {
        $records = PrayerSearch::where('updated_at', '<', now()->subDays($days))->get();
        $count = $records->count();
        
        echo "Updating $count records older than $days days...\n\n";
        
        foreach ($records as $record) {
            $timings = json_decode($record->timings ?? '{}', true);
            
            if (empty($timings)) continue;
            
            $location = [
                'country' => $record->country ?? 'Unknown',
                'state' => $record->state ?? 'Unknown'
            ];
            
            $newMetaData = $this->generateMetaData(
                $record->city,
                $location,
                $record->Cal_Method ?? 'Muslim World League',
                $timings
            );
            
            $record->update([
                'meta_title' => $newMetaData['meta_title'],
                'meta_description' => $newMetaData['meta_description'],
                'meta_keywords' => $newMetaData['meta_keywords'],
                'updated_at' => now()
            ]);
            
            echo "Updated: {$record->city}\n";
        }
        
        echo "\nCompleted! Updated $count records.\n";
    }
    
    public function Prayer_index (){
        return view('Prayer_index');
    }
}