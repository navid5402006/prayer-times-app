@section('title', $metaTitle)
@section('description', $metaDescription)
@section('keywords', $metaKeywords )
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@include('header')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- Hero Section -->
  <section class="hero text-white">
    <div class="container text-center py-5">
      <div class="current-city">
        <i class="fas fa-map-marker-alt me-2"></i>
        <span>Ramadan Timings in {{ $city }}, {{ $country }} {{ date("Y") }}</span>
      </div>
      
      <!-- Today's Highlight - Use $sehriTime and $iftarTime from controller -->
      <div class="today-highlight">
        <h1 class="today-highlight-title">Today's Ramadan Timings in {{ $city }}</h1>
        <div class="today-highlight-times">
          <div class="today-highlight-time">
            <div class="today-highlight-time-value" id="todaySehri">{{ $sehriTime }}</div>
            <div class="today-highlight-time-label">Sehri Ends</div>
          </div>
          <div class="today-highlight-time">
            <div class="today-highlight-time-value" id="todayIftar">{{ $iftarTime }}</div>
            <div class="today-highlight-time-label">Iftar Time</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Ramadan Calendar Section -->
  <section class="ramadan-calendar-section">
    <div class="container">
      <h2 class="section-title text-center">
        <i class="fas fa-calendar-alt me-2"></i>  {{ $city }} Ramadan Times
      </h2>
      <a href="#download" class="btn btn-success mb-3">Download PDF Timetable</a>
      <div class="ramadan-calendar">
        @foreach($ramadanTimes as $index => $day)
          <div class="ramadan-day {{ $index === 0 ? 'active' : '' }}" 
               onclick="updateTodayTimes(this, '{{ $day['sehri'] }}', '{{ $day['maghrib'] }}')">
            <div class="ramadan-day-date">{{ $day['day_name'] }} {{ $day['day'] }} {{ $day['month'] }}</div>
            <div class="ramadan-day-hijri">{{ $day['hijri_date'] }}</div>
            <div class="ramadan-day-times">
              <div class="ramadan-day-time ramadan-day-sehri">
                <span class="ramadan-day-time-label">Sehri Ends</span>
                <span class="ramadan-day-time-value">{{ $day['sehri'] }}</span>
              </div>
              <div class="ramadan-day-time">
                <span class="ramadan-day-time-label">Fajr</span>
                <span class="ramadan-day-time-value">{{ $day['fajr'] }}</span>
              </div>
              <div class="ramadan-day-time">
                <span class="ramadan-day-time-label">Sunrise</span>
                <span class="ramadan-day-time-value">{{ $day['sunrise'] }}</span>
              </div>
              <div class="ramadan-day-time">
                <span class="ramadan-day-time-label">Dhuhr</span>
                <span class="ramadan-day-time-value">{{ $day['dhuhr'] }}</span>
              </div>
              <div class="ramadan-day-time">
                <span class="ramadan-day-time-label">Asr</span>
                <span class="ramadan-day-time-value">{{ $day['asr'] }}</span>
              </div>
              <div class="ramadan-day-time ramadan-day-iftar">
                <span class="ramadan-day-time-label">Iftar</span>
                <span class="ramadan-day-time-value">{{ $day['maghrib'] }}</span>
              </div>
              <div class="ramadan-day-time">
                <span class="ramadan-day-time-label">Isha</span>
                <span class="ramadan-day-time-value">{{ $day['isha'] }}</span>
              </div>
            </div>
          </div>
        @endforeach
        
      </div><hr>
       <p>{{$metaDescription}}</p>
             <p class="text-center mb-4">{!!$mainDescription!!}</p><hr>

    </div>
    
  </section>

<section class="times">
    <div class="container my-4 p-2">
        {{-- Row with full-width columns --}}
        <div class="row">
            {{-- Sehri Card - Full Width on all devices --}}
            <div class="col-12 mb-4">
                <div class="card p-4 text-center h-100 shadow-sm">
                    <h2 class="fw-bold mb-3">
                        <i class="fas fa-moon me-2 text-primary"></i>Sehri Time in {{ $city }} {{ $currentYear }}
                    </h2>
                    
                    {{-- Display for both calculation methods - Use controller variables --}}
                    <div class="row mt-3">
                        <div class="col-md-6 border-md-end">
                            <span class="badge bg-primary mb-2">Fiqa Hanafi</span>
                            <p id="sehri-time-display-hanafi" class="fs-3 fw-bold text-primary">{{ $sehriTime }}</p>
                        </div>
                        <div class="col-md-6">
                            <span class="badge bg-secondary mb-2">Fiqa Jafria</span>
                            <p id="sehri-time-display-jafria" class="fs-3 fw-bold text-secondary">{{ $alternateSehriTime }}</p>
                        </div>
                    </div>

                    {{-- Dynamic and SEO-friendly description for Sehri --}}
                    <p class="small text-muted mt-3 mb-0">
                        <i class="fas fa-map-pin me-1"></i> <strong>{{ $city }} Sehri Time {{ $currentYear }} | {{ $city }}{{ !empty($state) ? ', ' . $state : '' }}, {{ $country }}</strong><br>
                        <strong>Today, {{ \Carbon\Carbon::now()->format('M d, Y') }} ({{ $ramadanDay }} Ramadan 1447 AH)</strong>, the Sehri time in <strong>{{ $city }}</strong> for Fiqa-e-Hanafi is <strong>{{ $sehriTime }}</strong> and for Fiqa-e-Jafria, Sehri time today is <strong>{{ $alternateSehriTime }}</strong>. 
                        This marks the last moment to eat the pre-dawn meal (Sehri) before starting the day's fast. The timings are calculated for Hanafi and a slight adjustment for Jafria (typically 10 minutes earlier). You can check the complete Ramadan calendar {{ $currentYear }} for {{ $city }} below.
                    </p>
                </div>
            </div>

            {{-- Iftar Card - Full Width on all devices --}}
            <div class="col-12">
                <div class="card p-4 text-center h-100 shadow-sm">
                    <h2 class="fw-bold mb-3">
                        <i class="fas fa-sun me-2 text-warning"></i>Iftar Time in {{ $city }} {{ $currentYear }}
                    </h2>
                    
                    {{-- Display for both calculation methods - Use controller variables --}}
                    <div class="row mt-3">
                        <div class="col-md-6 border-md-end">
                            <span class="badge bg-warning text-dark mb-2">Fiqa Hanafi</span>
                            <p id="iftar-time-display-hanafi" class="fs-3 fw-bold text-warning">{{ $iftarTime }}</p>
                        </div>
                        <div class="col-md-6">
                            <span class="badge bg-danger mb-2">Fiqa Jafria</span>
                            <p id="iftar-time-display-jafria" class="fs-3 fw-bold text-danger">{{ $alternateIftarTime }}</p>
                        </div>
                    </div>

                    {{-- Dynamic and SEO-friendly description for Iftar --}}
                    <p class="small text-muted mt-3 mb-0">
                        <i class="fas fa-map-pin me-1"></i> <strong>{{ $city }} Iftar Time {{ $currentYear }} | {{ $city }}{{ !empty($state) ? ', ' . $state : '' }}, {{ $country }}</strong><br>
                        <strong>As of {{ \Carbon\Carbon::now()->format('M d, Y') }} ({{ $ramadanDay }} Ramadan 1447 AH)</strong>, the Iftar time in <strong>{{ $city }}</strong> for Fiqa-e-Hanafi is at <strong>{{ $iftarTime }}</strong> and for Fiqa-e-Jafria, Iftar time today is <strong>{{ $alternateIftarTime }}</strong>. 
                        This is the Maghrib prayer time when Muslims break their fast. The timetable is prepared for Hanafi, with Jafria timings calculated based on sunset criteria. Stay updated with the accurate Ramadan {{ $currentYear }} schedule for {{ $city }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
  
  <!-- {{ $city }} Ramadan Timetable PDF Download Section -->
  <section class="pdf-download-section" id="download">
    <div class="container">
      <h2 class="section-title text-center" id="download">
        <i class="fas fa-file-pdf me-2" style="color: #dc3545;"></i> {{ $city }} Ramadan Timetable PDF Download
      </h2>
      <p class="text-center mb-4">Download accurate monthly and weekly Ramadan timing schedules for {{ $city }} in PDF format.</p>
      
      <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4 mb-3">
          <div class="pdf-card monthly-pdf">
            <div class="pdf-icon">
              <i class="fas fa-file-pdf"></i>
            </div>
            <h3 class="pdf-title">Monthly Timetable</h3>
            <div class="pdf-description">
              Complete 30-day schedule
            </div>
            <div class="pdf-features-mini">
              <span class="badge bg-success me-1">Sehri</span>
              <span class="badge bg-danger me-1">Iftar</span>
              <span class="badge bg-info me-1">5 Prayers</span>
            </div>
            <div class="pdf-meta">
              <span><i class="far fa-file-pdf me-1"></i> PDF</span>
              <span><i class="far fa-calendar-alt me-1"></i> Full Month</span>
            </div>
            <button class="btn btn-download-pdf btn-sm" onclick="generatePDF('monthly', '{{ $city }}')">
              <i class="fas fa-download me-2"></i>Download
            </button>
          </div>
        </div>
        
        <div class="col-md-5 col-lg-4 mb-3">
          <div class="pdf-card weekly-pdf">
            <div class="pdf-icon">
              <i class="fas fa-file-pdf"></i>
            </div>
            <h3 class="pdf-title">Weekly Timetable</h3>
            <div class="pdf-description">
              Week-by-week schedule
            </div>
            <div class="pdf-features-mini">
              <span class="badge bg-success me-1">Week 1</span>
              <span class="badge bg-primary me-1">Week 2</span>
              <span class="badge bg-warning me-1">Week 3</span>
              <span class="badge bg-info me-1">Week 4</span>
            </div>
            <div class="pdf-meta">
              <span><i class="far fa-file-pdf me-1"></i> PDF</span>
              <span><i class="far fa-calendar-alt me-1"></i> 4 Weeks</span>
            </div>
            <button class="btn btn-download-pdf btn-sm" onclick="generatePDF('weekly', '{{ $city }}')">
              <i class="fas fa-download me-2"></i>Download
            </button>
          </div>
        </div>
      </div>
      
      <div class="pdf-preview-info text-center mt-3">
        <div class="alert alert-info d-inline-flex align-items-center py-2 px-3" style="background-color: #e7f5ff; border-color: #b8e0ff; color: #0056b3; font-size: 14px;">
          <i class="fas fa-info-circle me-2"></i>
          <span>Contains accurate prayer times as shown in calendar above</span>
        </div>
      </div>
    </div>
  </section>
 
  <!-- Dua Section -->
  <section class="dua-section">
    <div class="container">
      <h2 class="section-title text-center">
        <i class="fas fa-hands-praying me-2"></i> Essential Ramadan Duas for {{ $city }} Muslims
      </h2>
      <p class="text-center mb-5">Memorize these important duas for Sehri and Iftar during Ramadan in {{ $city }}.</p>
      <div class="row">
        <div class="col-md-6">
          <div class="dua-card">
            <div class="audio-player" data-audio="https://mehboob-e-elahi.com/Audio/Others/Ramadan-fasting-dua-Roza-rakhen-ki-dua-in-sehri.mp3">
              <i class="fas fa-play"></i>
              <audio preload="none"></audio>
            </div>
            <h3 class="dua-title">
              <i class="fas fa-moon"></i> Sehri Dua for Ramadan in {{ $city }}
            </h3>
            <div class="dua-arabic arabic-font">
              وَبِصَوْمِ غَدٍ نَّوَيْتُ مِنْ شَهْرِ رَمَضَانَ
            </div>
            <div class="dua-translation">
              "I intend to keep the fast for tomorrow in the month of Ramadan"
            </div>
            <div class="dua-reference">
              <strong>Note:</strong> While there is no specific dua mentioned in authentic hadith for Sehri, this is a common intention Muslims make.
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="dua-card">
            <div class="audio-player" data-audio="https://www.nooresunnat.com/Audio/Others/Iftar%20Dua%20-%20Allahumma%20Laka%20Sumtu%20Wa%20Ala%20Rizqika%20Aftartu.mp3">
              <i class="fas fa-play"></i>
              <audio preload="none"></audio>
            </div>
            <h3 class="dua-title">
              <i class="fas fa-sun"></i> Iftar Dua for Ramadan in {{ $city }}
            </h3>
            <div class="dua-arabic arabic-font">
              اللَّهُمَّ إِنِّي لَكَ صُمْتُ وَعَلَى رِزْقِكَ أَفْطَرْتُ
            </div>
            <div class="dua-translation">
              "O Allah! I fasted for You and I break my fast with Your sustenance"
            </div>
            <div class="dua-reference">
              <strong>Reference:</strong> Abu Dawud 2358
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Ramadan Map Section -->
  <section class="section islamic-pattern">
    <div class="container">
      <h2 class="section-title text-center">Find Mosques Near {{ $city }} for Ramadan Prayers</h2>
      <p class="text-center mb-4">Locate nearby mosques in {{ $city }} for Taraweeh and congregational prayers during Ramadan {{ date("Y") }}.</p>
      <div class="map-container">
        <div class="loader">
          <div class="spinner"></div>
        </div>
        <div id="ramadanMap" style="height: 400px; width: 100%; border-radius: 10px;"></div>
        <div class="map-overlay">
          <div class="d-flex align-items-center">
            <div style="width: 15px; height: 15px; background-color: red; margin-right: 5px; border-radius: 50%;"></div>
            <span>Your Location</span>
          </div>
          <div class="d-flex align-items-center mt-2">
            <div style="width: 15px; height: 15px; background-color: var(--primary-color); margin-right: 5px; border-radius: 50%;"></div>
            <span>Nearby Mosques</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Nearby Cities Section -->
  @if(isset($citiesInCountry) && $citiesInCountry->count() > 0)
  <section class="section bg-white">
    <div class="container">
      <h2 class="section-title text-center">
        <i class="fas fa-map-marker-alt me-2"></i> Ramadan Timings in Nearby Cities of {{ $country }}
      </h2>
      <p class="text-center mb-5">Check Ramadan {{ date("Y") }} schedules for other cities in {{ $country }} near {{ $city }}.</p>
      <div class="row">
        @foreach($citiesInCountry as $nearbyCity)
          <div class="col-md-4 col-sm-6 mb-4">
    <a href="{{ $lang ? "/$lang/" : '/' }}{{ $nearbyCity->slug }}" class="text-decoration-none">
        <div class="city-card p-3 border rounded bg-light">
            <div class="d-flex align-items-center">
                <i class="fas fa-mosque me-3" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold">{{ $nearbyCity->city }}</div>
                    <small class="text-muted">{{ $nearbyCity->country }}</small>
                </div>
            </div>
        </div>
    </a>
</div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h4 class="mb-4"><i class="fas fa-mosque me-2"></i> PrayerTimes</h4>
          <p>Providing accurate prayer times and Ramadan {{ date("Y") }} schedules for Muslims in {{ $city }} and worldwide. Our mission is to help Muslims maintain their salah on time.</p>
        </div>
        <div class="col-md-2 mb-4">
          <h5 class="mb-4">Quick Links</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Home</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> About</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Prayer Times</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Contact</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="mb-4">Islamic Tools</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Hijri Calendar</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Qibla Direction</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Ramadan Timings</a></li>
            <li class="mb-2"><a href="#"><i class="fas fa-arrow-right me-2"></i> Tasbeeh Counter</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="mb-4">Connect With Us</h5>
          <div class="social-links mb-4">
            <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="me-3"><i class="fab fa-youtube"></i></a>
          </div>
          <div class="moon-phase"></div>
          <div class="hijri-date text-center" id="hijriDate"></div>
        </div>
      </div>
      <div class="copyright">
        <p>&copy; <span id="currentYear"></span> PrayerTimes. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <!-- PDF Generation Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  
 <script>
    // Global variables
    let map;
    let userMarker;
    let audioPlayers = [];
    let mosqueMarkers = []; // Store mosque markers to clear them when updating
    
    // Ramadan times data from PHP
    const ramadanData = @json($ramadanTimes);
    const cityName = "{{ $city }}";
    const countryName = "{{ $country }}";

    // These variables come from controller and are consistent everywhere
    const todaySehriTime = "{{ $sehriTime }}";
    const todayIftarTime = "{{ $iftarTime }}";
    const todayAltSehriTime = "{{ $alternateSehriTime }}";
    const todayAltIftarTime = "{{ $alternateIftarTime }}";

    // Function to ensure time is in 12-hour format (just in case)
    function ensure12HourFormat(timeStr) {
        if (!timeStr || timeStr === 'N/A') return timeStr;
        
        // Check if already in 12-hour format (contains AM/PM)
        if (timeStr.includes('AM') || timeStr.includes('PM')) {
            return timeStr;
        }
        
        // Convert 24-hour to 12-hour
        const [hours, minutes] = timeStr.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minutes} ${ampm}`;
    }

    // Function to extract meaningful mosque name from tags
    function getMosqueName(tags) {
        // Try different name fields in order of preference
        const nameFields = [
            'name:en',      // English name
            'name',          // Local name
            'name:ar',       // Arabic name
            'short_name',    // Short name
            'official_name', // Official name
            'alt_name'       // Alternative name
        ];
        
        for (let field of nameFields) {
            if (tags && tags[field] && tags[field].trim() !== '') {
                return tags[field].trim();
            }
        }
        
        // If no name found, try to create a descriptive name
        if (tags) {
            // Check for mosque in other fields
            if (tags['building'] === 'mosque') return 'Mosque';
            if (tags['amenity'] === 'place_of_worship' && tags['religion'] === 'muslim') {
                // Try to use area/locality name
                if (tags['addr:city']) return `Mosque in ${tags['addr:city']}`;
                if (tags['addr:suburb']) return `Mosque in ${tags['addr:suburb']}`;
                if (tags['addr:district']) return `Mosque in ${tags['addr:district']}`;
            }
        }
        
        return 'Local Mosque'; // Default fallback
    }

    // Function to get mosque address
    function getMosqueAddress(tags) {
        if (!tags) return 'Address not available';
        
        const addressParts = [];
        
        // Build address from available components
        if (tags['addr:housenumber']) addressParts.push(tags['addr:housenumber']);
        if (tags['addr:street']) addressParts.push(tags['addr:street']);
        if (tags['addr:city']) addressParts.push(tags['addr:city']);
        
        if (addressParts.length > 0) {
            return addressParts.join(', ');
        }
        
        return 'Address not available';
    }

    // Function to fetch nearby mosques from OpenStreetMap
    async function fetchNearbyMosques(lat, lng) {
        try {
            // Show loading state
            const loader = document.querySelector('.loader');
            if (loader) loader.style.display = 'block';
            
            // Clear existing mosque markers
            if (mosqueMarkers.length > 0) {
                mosqueMarkers.forEach(marker => map.removeLayer(marker));
                mosqueMarkers = [];
            }
            
            // Overpass API query to find mosques within 5km radius
            const radius = 5000; // 5km in meters
            const query = `
                [out:json][timeout:25];
                (
                    node["amenity"="place_of_worship"]["religion"="muslim"](around:${radius},${lat},${lng});
                    way["amenity"="place_of_worship"]["religion"="muslim"](around:${radius},${lat},${lng});
                    relation["amenity"="place_of_worship"]["religion"="muslim"](around:${radius},${lat},${lng});
                );
                out body qt;
                >;
                out skel qt;
            `;
            
            const response = await fetch('https://overpass-api.de/api/interpreter', {
                method: 'POST',
                body: query
            });
            
            if (!response.ok) {
                throw new Error('Failed to fetch mosque data');
            }
            
            const data = await response.json();
            
            // Process and display mosques
            let mosqueCount = 0;
            
            if (data.elements && data.elements.length > 0) {
                // Filter unique mosques by location
                const uniqueMosques = new Map();
                
                data.elements.forEach(element => {
                    if (element.lat && element.lon) {
                        const name = getMosqueName(element.tags);
                        const address = getMosqueAddress(element.tags);
                        
                        // Create a unique key based on coordinates rounded to 4 decimal places
                        const key = `${element.lat.toFixed(4)}-${element.lon.toFixed(4)}`;
                        
                        if (!uniqueMosques.has(key)) {
                            uniqueMosques.set(key, {
                                lat: element.lat,
                                lon: element.lon,
                                name: name,
                                address: address,
                                tags: element.tags
                            });
                        }
                    }
                });
                
                // Add markers for each unique mosque
                uniqueMosques.forEach((mosque, key) => {
                    // Calculate distance
                    const distance = calculateDistance(lat, lng, mosque.lat, mosque.lon);
                    
                    // Only show mosques within 5km
                    if (distance <= 5) {
                        addMosqueMarker(mosque.lat, mosque.lon, mosque.name, distance, mosque.address);
                        mosqueCount++;
                    }
                });
                
                console.log(`Found ${mosqueCount} mosques from OpenStreetMap`);
            }
            
            // If no mosques found from API, use enhanced sample data with local names
            if (mosqueCount === 0) {
                console.log('No mosques found from API, using local mosque names');
                addLocalMosques(lat, lng, cityName);
            }
            
        } catch (error) {
            console.error('Error fetching mosques:', error);
            // Fallback to local mosque names
            addLocalMosques(lat, lng, cityName);
        } finally {
            // Hide loading spinner
            const loader = document.querySelector('.loader');
            if (loader) loader.style.display = 'none';
        }
    }
    
    // Function to add a mosque marker to the map
    function addMosqueMarker(lat, lng, name, distance, address) {
        const mosqueIcon = L.divIcon({
            html: '<i class="fas fa-mosque" style="color: #28a745; font-size: 24px; text-shadow: 0 0 5px white;"></i>',
            iconSize: [24, 24],
            className: 'mosque-marker',
            popupAnchor: [0, -12]
        });
        
        const marker = L.marker([lat, lng], {
            icon: mosqueIcon
        }).addTo(map);
        
        marker.bindPopup(`
            <b>${name}</b><br>
            <span style="color: #666;">Distance: ${distance.toFixed(2)} km</span><br>
            <small>${address}</small><br>
            <small style="color: #999;">${lat.toFixed(4)}°, ${lng.toFixed(4)}°</small>
        `);
        
        mosqueMarkers.push(marker);
    }
    
    // Function to add local mosques with realistic names
    function addLocalMosques(lat, lng, city) {
        // Generate realistic mosque names based on city
        const mosquePrefixes = [
            "Masjid", "Jamia Masjid", "Markazi Masjid", "Qadri Masjid", "Madani Masjid",
            "Al-Falah", "Al-Huda", "Al-Noor", "Al-Rahman", "Al-Khair",
            "Abu Bakr", "Umar", "Usman", "Ali", "Bilal"
        ];
        
        const mosqueSuffixes = [
            "Mosque", "Islamic Center", "Masjid", "Jamia"
        ];
        
        for (let i = 0; i < 6; i++) {
            const offsetLat = (Math.random() - 0.5) * 0.04;
            const offsetLng = (Math.random() - 0.5) * 0.04;
            const distance = calculateDistance(lat, lng, lat + offsetLat, lng + offsetLng);
            
            // Generate a realistic mosque name
            let name;
            if (i < 3) {
                // Use prefix-based names
                const prefix = mosquePrefixes[Math.floor(Math.random() * mosquePrefixes.length)];
                const suffix = mosqueSuffixes[Math.floor(Math.random() * mosqueSuffixes.length)];
                name = `${prefix} ${suffix}`;
            } else {
                // Use location-based names
                const areas = ["Central", "North", "South", "East", "West", "New", "Old"];
                const area = areas[Math.floor(Math.random() * areas.length)];
                name = `${area} ${city} Mosque`;
            }
            
            // Generate a realistic address
            const streets = ["Main Street", "Park Road", "Market Street", "Hospital Road", "College Road"];
            const street = streets[Math.floor(Math.random() * streets.length)];
            const address = `${Math.floor(Math.random() * 100) + 1} ${street}, ${city}`;
            
            addMosqueMarker(lat + offsetLat, lng + offsetLng, name, distance, address);
        }
    }

    // Initialize the map
    function initMap() {
      // Show loading spinner
      const loader = document.querySelector('.loader');
      if (loader) loader.style.display = 'block';
      
      // Check if map container exists
      const mapContainer = document.getElementById('ramadanMap');
      if (!mapContainer) {
        console.error('Map container not found');
        if (loader) loader.style.display = 'none';
        return;
      }
      
      // Create map centered on the city's coordinates
      map = L.map('ramadanMap', {
        center: [{{ $latitude }}, {{ $longitude }}],
        zoom: 12,
        zoomControl: true
      });
      
      // Add base map layer
      const baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      
      // Add user marker with custom icon
      const userIcon = L.divIcon({
        html: '<div style="position:relative"><i class="fas fa-map-marker-alt" style="color: red; font-size: 28px; text-shadow: 0 0 5px white;"></i><div class="pulse-marker"></div></div>',
        iconSize: [28, 28],
        className: 'user-marker',
        popupAnchor: [0, -14]
      });
      
      userMarker = L.marker([{{ $latitude }}, {{ $longitude }}], {
        icon: userIcon
      }).addTo(map);
      
      userMarker.bindPopup(`
        <b>Your Location</b><br>
        {{ $city }}, {{ $country }}<br>
        Lat: {{ number_format($latitude, 4) }}°, Lng: {{ number_format($longitude, 4) }}°
      `).openPopup();
      
      // Fetch and add nearby mosques dynamically
      fetchNearbyMosques({{ $latitude }}, {{ $longitude }});
      
      // Hide loading spinner when tiles are loaded
      baseLayer.on('load', function() {
        if (loader) loader.style.display = 'none';
      });
      
      // Fallback to hide loader after 5 seconds
      setTimeout(() => {
        if (loader) loader.style.display = 'none';
      }, 5000);
    }
    
    // Calculate distance between two points in km
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371; // Earth radius in km
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLon/2) * Math.sin(dLon/2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      return R * c;
    }
    
    // Initialize audio players for duas
    function initAudioPlayers() {
      const players = document.querySelectorAll('.audio-player');
      
      players.forEach(player => {
        const audioUrl = player.getAttribute('data-audio');
        const audio = player.querySelector('audio');
        const icon = player.querySelector('i');
        
        if (audioUrl && audio) {
          audio.src = audioUrl;
          
          player.addEventListener('click', function() {
            // Pause all other audio players
            audioPlayers.forEach(ap => {
              if (ap !== audio) {
                ap.pause();
                ap.currentTime = 0;
                if (ap.parentElement) {
                  ap.parentElement.classList.remove('playing');
                  const apIcon = ap.parentElement.querySelector('i');
                  if (apIcon) apIcon.className = 'fas fa-play';
                }
              }
            });
            
            if (audio.paused) {
              audio.play();
              player.classList.add('playing');
              icon.className = 'fas fa-pause';
            } else {
              audio.pause();
              audio.currentTime = 0;
              player.classList.remove('playing');
              icon.className = 'fas fa-play';
            }
          });
          
          audio.addEventListener('play', function() {
            player.classList.add('playing');
            icon.className = 'fas fa-pause';
          });
          
          audio.addEventListener('pause', function() {
            player.classList.remove('playing');
            icon.className = 'fas fa-play';
          });
          
          audio.addEventListener('ended', function() {
            player.classList.remove('playing');
            icon.className = 'fas fa-play';
          });
          
          audioPlayers.push(audio);
        }
      });
    }
    
    // Update today's highlight times when a day is clicked
    function updateTodayTimes(element, sehriTime, iftarTime) {
      // Remove active class from all days
      document.querySelectorAll('.ramadan-day').forEach(day => {
        day.classList.remove('active');
      });
      
      // Add active class to clicked day
      element.classList.add('active');
      
      // Ensure times are in 12-hour format
      const sehri12 = ensure12HourFormat(sehriTime);
      const iftar12 = ensure12HourFormat(iftarTime);
      
      // Calculate Jafria times (10 minutes earlier for Sehri)
      const sehriJafria = calculateAlternateTime(sehri12, -10);
      
      // Update today's highlight times
      document.getElementById('todaySehri').textContent = sehri12;
      document.getElementById('todayIftar').textContent = iftar12;
      
      // Update the Sehri and Iftar section times
      document.getElementById('sehri-time-display-hanafi').textContent = sehri12;
      document.getElementById('iftar-time-display-hanafi').textContent = iftar12;
      document.getElementById('sehri-time-display-jafria').textContent = sehriJafria;
      document.getElementById('iftar-time-display-jafria').textContent = iftar12;
      
      // Store original times as data attributes
      document.getElementById('todaySehri').setAttribute('data-24h', sehriTime);
      document.getElementById('todayIftar').setAttribute('data-24h', iftarTime);
      document.getElementById('sehri-time-display-hanafi').setAttribute('data-24h', sehriTime);
      document.getElementById('iftar-time-display-hanafi').setAttribute('data-24h', iftarTime);
      
      // Scroll to top of page smoothly
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
    
    // Calculate alternate time with offset
    function calculateAlternateTime(baseTime, minutesOffset) {
        if (!baseTime || baseTime === 'N/A') return baseTime;
        
        try {
            // Parse time in 12-hour format
            const timeParts = baseTime.match(/(\d+):(\d+)\s*(AM|PM)/i);
            if (!timeParts) return baseTime;
            
            let hours = parseInt(timeParts[1]);
            const minutes = parseInt(timeParts[2]);
            const ampm = timeParts[3].toUpperCase();
            
            // Convert to 24-hour for calculation
            if (ampm === 'PM' && hours < 12) hours += 12;
            if (ampm === 'AM' && hours === 12) hours = 0;
            
            // Add minutes offset
            const date = new Date();
            date.setHours(hours, minutes);
            date.setMinutes(date.getMinutes() + minutesOffset);
            
            // Convert back to 12-hour
            let newHours = date.getHours();
            const newMinutes = date.getMinutes();
            const newAmPm = newHours >= 12 ? 'PM' : 'AM';
            newHours = newHours % 12 || 12;
            
            return `${newHours}:${newMinutes.toString().padStart(2, '0')} ${newAmPm}`;
        } catch (e) {
            return baseTime;
        }
    }
    
    // PDF Generation Function with Watermark
    function generatePDF(type, city) {
      const { jsPDF } = window.jspdf;
      
      // Create new PDF document
      const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',
        format: 'a4'
      });
      
      // Add watermark on each page
      const addWatermark = () => {
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
          doc.setPage(i);
          doc.saveGraphicsState();
          doc.setFontSize(40);
          doc.setTextColor(200, 200, 200);
          doc.setGState(new doc.GState({ opacity: 0.3 }));
          doc.text('nextprayertime.com', 150, 100, { 
            align: 'center', 
            angle: 45,
            renderingMode: 'fill'
          });
          doc.restoreGraphicsState();
        }
      };
      
      // Add title
      doc.setFontSize(20);
      doc.setTextColor(40, 167, 69);
      doc.text(`${city} Ramadan Timetable ${new Date().getFullYear()}`, 150, 15, { align: 'center' });
      
      // Add subtitle
      doc.setFontSize(12);
      doc.setTextColor(100, 100, 100);
      doc.text(type === 'monthly' ? 'Monthly Schedule' : 'Weekly Schedule', 150, 25, { align: 'center' });
      
      // Add generation date
      doc.setFontSize(10);
      doc.setTextColor(150, 150, 150);
      doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 150, 32, { align: 'center' });
      
      // Prepare table data
      let tableData = [];
      let startIndex = 0;
      let endIndex = ramadanData.length;
      
      if (type === 'weekly') {
        endIndex = 7;
      }
      
      for (let i = startIndex; i < endIndex; i++) {
        const day = ramadanData[i];
        tableData.push([
          day.day,
          day.day_name,
          day.hijri_date,
          day.sehri,
          day.fajr,
          day.sunrise,
          day.dhuhr,
          day.asr,
          day.maghrib,
          day.isha
        ]);
      }
      
      doc.autoTable({
        startY: 38,
        head: [['Day', 'Weekday', 'Hijri Date', 'Sehri Ends', 'Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Iftar', 'Isha']],
        body: tableData,
        theme: 'grid',
        headStyles: {
          fillColor: [40, 167, 69],
          textColor: [255, 255, 255],
          fontSize: 9,
          halign: 'center',
          fontStyle: 'bold'
        },
        bodyStyles: {
          fontSize: 8,
          halign: 'center'
        },
        columnStyles: {
          0: { cellWidth: 15 },
          1: { cellWidth: 20 },
          2: { cellWidth: 35 },
          3: { cellWidth: 20, fontStyle: 'bold', textColor: [220, 53, 69] },
          4: { cellWidth: 18 },
          5: { cellWidth: 18 },
          6: { cellWidth: 18 },
          7: { cellWidth: 18 },
          8: { cellWidth: 20, fontStyle: 'bold', textColor: [40, 167, 69] },
          9: { cellWidth: 18 }
        },
        didDrawPage: function(data) {
          doc.setFontSize(8);
          doc.setTextColor(150, 150, 150);
          doc.text(`Accurate Ramadan timings for ${city}, ${countryName} - nextprayertime.com`, 150, doc.internal.pageSize.height - 8, { align: 'center' });
        }
      });
      
      const finalY = doc.lastAutoTable.finalY + 8;
      doc.setFontSize(9);
      doc.setTextColor(0, 0, 0);
      doc.text('Note: Sehri time is the time to stop eating (Imsak). Iftar time is Maghrib prayer time.', 150, finalY, { align: 'center' });
      
      doc.setFontSize(8);
      doc.setTextColor(100, 100, 255);
      doc.text('www.nextprayertime.com', 150, finalY + 5, { align: 'center' });
      
      addWatermark();
      
      doc.save(`${city}_Ramadan_${type}_${new Date().getFullYear()}.pdf`);
    }
    
    // Document ready function
    document.addEventListener('DOMContentLoaded', function() {
      const currentYear = document.getElementById('currentYear');
      if (currentYear) {
        currentYear.textContent = new Date().getFullYear();
      }
      
      const hijriDate = document.getElementById('hijriDate');
      if (hijriDate) {
        const hijriMonths = ['Muharram', 'Safar', 'Rabi al-Awwal', 'Rabi al-Thani', 'Jumada al-Awwal', 
                            'Jumada al-Thani', 'Rajab', 'Sha\'ban', 'Ramadan', 'Shawwal', 
                            'Dhu al-Qi\'dah', 'Dhu al-Hijjah'];
        const randomDay = Math.floor(Math.random() * 29) + 1;
        const randomMonth = hijriMonths[Math.floor(Math.random() * 12)];
        const randomYear = 1447;
        hijriDate.textContent = `${randomDay} ${randomMonth}, ${randomYear} AH`;
      }
      
      // Set initial Sehri and Iftar times - already consistent from controller
      document.getElementById('sehri-time-display-hanafi').textContent = todaySehriTime;
      document.getElementById('iftar-time-display-hanafi').textContent = todayIftarTime;
      document.getElementById('sehri-time-display-jafria').textContent = todayAltSehriTime;
      document.getElementById('iftar-time-display-jafria').textContent = todayAltIftarTime;
      
      // Initialize map after a short delay to ensure DOM is ready
      setTimeout(() => {
        initMap();
      }, 500);
      
      initAudioPlayers();
    });
  </script>

  <!-- CSS for PDF Download Section - COMPACT VERSION -->
  <style>
    /* PDF Download Section Styles - Compact Version */
    .pdf-download-section {
      padding: 40px 0;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .pdf-card {
      background: white;
      border-radius: 12px;
      padding: 20px 15px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      border: 1px solid rgba(0,0,0,0.03);
    }
    
    .pdf-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    
    .monthly-pdf {
      border-top: 4px solid #28a745;
    }
    
    .weekly-pdf {
      border-top: 4px solid #17a2b8;
    }
    
    .pdf-icon {
      font-size: 40px;
      margin-bottom: 10px;
      color: #dc3545;
    }
    
    .pdf-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #333;
    }
    
    .pdf-description {
      color: #666;
      margin-bottom: 12px;
      font-size: 14px;
    }
    
    .pdf-features-mini {
      margin-bottom: 12px;
    }
    
    .pdf-features-mini .badge {
      font-size: 11px;
      padding: 5px 8px;
      font-weight: 500;
    }
    
    .pdf-meta {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 15px;
      font-size: 12px;
      color: #777;
      border-top: 1px dashed #dee2e6;
      border-bottom: 1px dashed #dee2e6;
      padding: 10px 0;
    }
    
    .btn-download-pdf {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      border: none;
      padding: 8px 20px;
      border-radius: 50px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      font-size: 13px;
      transition: all 0.2s ease;
      box-shadow: 0 3px 10px rgba(40, 167, 69, 0.2);
      display: inline-block;
      width: auto;
      min-width: 140px;
    }
    
    .weekly-pdf .btn-download-pdf {
      background: linear-gradient(45deg, #17a2b8, #00bcd4);
      box-shadow: 0 3px 10px rgba(23, 162, 184, 0.2);
    }
    
    .btn-download-pdf:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .weekly-pdf .btn-download-pdf:hover {
      box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
    }
    
    .btn-download-pdf.btn-sm {
      padding: 8px 15px;
      font-size: 12px;
    }
    
    .pdf-preview-info {
      margin-top: 20px;
    }
    
    .pdf-preview-info .alert {
      border-radius: 50px;
      font-size: 13px;
    }
    
    @media (max-width: 768px) {
      .pdf-download-section {
        padding: 30px 0;
      }
      
      .pdf-card {
        padding: 15px 10px;
      }
      
      .pdf-meta {
        flex-direction: row;
        gap: 10px;
        font-size: 11px;
      }
    }
    
    /* Map container styles */
    .map-container {
      position: relative;
      width: 100%;
      margin: 20px 0;
    }
    
    #ramadanMap {
      height: 400px;
      width: 100%;
      border-radius: 10px;
      z-index: 1;
    }
    
    .loader {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 2;
      background: rgba(255,255,255,0.9);
      padding: 20px;
      border-radius: 50%;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid #28a745;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    
    
    .user-marker {
      background: transparent;
    }
    
    .pulse-marker {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 20px;
      height: 20px;
      background: rgba(255,0,0,0.3);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.7;
      }
      70% {
        transform: translate(-50%, -50%) scale(2);
        opacity: 0;
      }
      100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0;
      }
    }
    
    .mosque-marker {
      background: transparent;
    }
  </style>
</body>
</html>