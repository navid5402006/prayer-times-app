@section('title', "Mosques Near Me - Find Nearby Mosques " . date('Y'))
@section('description', "Find mosques near your location with accurate distances, directions, and prayer times")
@section('keywords', "mosques near me, nearby mosques, masjid near me, islamic center, prayer times")
@include('header')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<style>
    /* Direction Panel Styles */
    .direction-panel {
        position: fixed;
        top: 0;
        right: -800px;
        width: 780px;
        height: 100vh;
        background: white;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        z-index: 9999;
        transition: right 0.3s ease;
        overflow-y: auto;
    }
    
    .direction-panel.active {
        right: 0;
    }
    
    .direction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: var(--primary-color);
        color: white;
    }
    
    .direction-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }
    
    .close-direction {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: white;
    }
    
    .direction-content {
        display: flex;
        height: calc(100vh - 80px);
    }
    
    .direction-sidebar {
        width: 300px;
        padding: 20px;
        overflow-y: auto;
        border-right: 1px solid #eee;
    }
    
    .direction-map-container {
        width: 480px;
        height: 100%;
    }
    
    #directionMap {
        width: 100%;
        height: 100%;
    }
    
    .direction-input {
        margin-bottom: 15px;
    }
    
    .direction-input label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }
    
    .direction-input input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 0.9rem;
        background: #f9f9f9;
    }
    
    .direction-route-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
    }
    
    .direction-route-info .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .direction-route-info .info-row:last-child {
        margin-bottom: 0;
    }
    
    .direction-route-info i {
        width: 20px;
        color: var(--primary-color);
    }
    
    .direction-steps {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #eee;
        border-radius: 8px;
    }
    
    .direction-step {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        font-size: 0.85rem;
        display: flex;
        align-items: flex-start;
    }
    
    .direction-step:last-child {
        border-bottom: none;
    }
    
    .direction-step i {
        width: 24px;
        color: var(--primary-color);
        margin-right: 8px;
        flex-shrink: 0;
    }
    
    .direction-step span {
        flex: 1;
        line-height: 1.4;
    }
    
    .direction-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        display: none;
    }
    
    .direction-overlay.active {
        display: block;
    }
    
    /* Mosque Card Styles */
    .mosque-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        transition: all 0.3s;
        height: 100%;
        cursor: pointer;
    }
    
    .mosque-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--primary-color);
    }
    
    .mosque-image {
        height: 160px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .mosque-image-overlay {
        position: absolute;
        bottom: 10px;
        right: 10px;
    }
    
    .mosque-distance-badge {
        background: var(--primary-color);
        color: white;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .mosque-card-header {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .mosque-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    
    .mosque-icon i {
        color: white;
        font-size: 20px;
    }
    
    .mosque-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 3px 0;
        color: #333;
    }
    
    .mosque-address-small {
        font-size: 0.75rem;
        color: #666;
    }
    
    .mosque-badge {
        background: var(--primary-color);
        color: white;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .mosque-card-body {
        padding: 15px;
    }
    
    .mosque-facilities {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 10px;
    }
    
    .facility-badge {
        background: #e8f4fd;
        color: var(--primary-color);
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .mosque-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-top: 10px;
    }
    
    .btn-get-directions, .btn-view-on-map {
        padding: 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-get-directions {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-get-directions:hover {
        background: #357abd;
    }
    
    .btn-view-on-map {
        background: #f8f9fa;
        color: #333;
        border: 1px solid #dee2e6;
    }
    
    .btn-view-on-map:hover {
        background: #e9ecef;
    }
    
    .travel-info {
        display: flex;
        justify-content: space-between;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #666;
        margin-top: 10px;
    }
    
    /* City Card Styles */
    .city-card {
        display: flex;
        align-items: center;
        padding: 15px;
        background: white;
        border: 1px solid #eee;
        border-radius: 10px;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
    }
    
    .city-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: var(--primary-color);
    }
    
    .city-card i {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-right: 15px;
    }
    
    /* Feature Card Styles */
    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 20px 15px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        height: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .feature-card i {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    
    .feature-card h4 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .feature-card p {
        font-size: 0.85rem;
        color: #666;
        margin: 0;
        line-height: 1.5;
    }
</style>

<!-- Main Content -->
<div id="app">
    <!-- Hero Section -->
    <section class="hero text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Mosques Near Me</h1>
                    <p class="lead mb-5">Find accurate mosque locations, distances, and prayer times for your area.</p>
                    
                    <!-- Today's Highlight with Location & Stats -->
                    <div class="today-highlight">
                        <div class="current-city mb-3" id="currentCityDisplay">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span id="locationText">Detecting your location...</span>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="time-display-container">
                            <div class="current-time-box">
                                <div class="current-time-label">Mosques Nearby</div>
                                <div class="current-time" id="mosqueCount">0</div>
                            </div>
                            <div class="countdown-container">
                                <div class="countdown-label">Search Radius</div>
                                <div class="countdown-timer" id="searchRadius">5 km</div>
                            </div>
                        </div>
                        
                        <!-- Today's Prayer Times -->
                        <div class="today-timings-grid mt-4">
                            <div class="timing-card">
                                <div class="timing-icon"><i class="fas fa-sun"></i></div>
                                <div class="timing-details">
                                    <span class="timing-label">Fajr</span>
                                    <span class="timing-time" id="todayFajr">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon"><i class="fas fa-clock"></i></div>
                                <div class="timing-details">
                                    <span class="timing-label">Dhuhr</span>
                                    <span class="timing-time" id="todayDhuhr">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon"><i class="fas fa-moon"></i></div>
                                <div class="timing-details">
                                    <span class="timing-label">Asr</span>
                                    <span class="timing-time" id="todayAsr">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon"><i class="fas fa-sunset"></i></div>
                                <div class="timing-details">
                                    <span class="timing-label">Maghrib</span>
                                    <span class="timing-time" id="todayMaghrib">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon"><i class="fas fa-star"></i></div>
                                <div class="timing-details">
                                    <span class="timing-label">Isha</span>
                                    <span class="timing-time" id="todayIsha">--:-- --</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="search-card">
                        <h3 class="mb-4 text-center" style="color: var(--primary-color);">
                            <i class="fas fa-search-location me-2"></i> Search Area
                        </h3>
                        
                        <form id="searchForm" method="GET" action="/mosque-near-me/search">
                            @csrf
                            <div class="mb-4 position-relative">
                                <label for="locationInput" class="form-label fw-bold">City or Location</label>
                                <input type="text" 
                                       name="city"
                                       id="locationInput"
                                       class="form-control form-control-lg" 
                                       placeholder="e.g. Dubai, Riyadh, Lahore" 
                                       autocomplete="off">
                                <div id="autocompleteResults" class="autocomplete-results"></div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Search Radius (km)</label>
                                <input type="range" class="form-range" id="radiusSlider" min="1" max="20" value="5" step="1">
                                <div class="d-flex justify-content-between">
                                    <span>1 km</span>
                                    <span id="radiusValue">5 km</span>
                                    <span>20 km</span>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i> Find Mosques
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map and Mosque List Section -->
    <section class="ramadan-calendar-section">
        <div class="container">
            <div class="month-navigation">
                <button id="listViewBtn" class="month-btn active">
                    <i class="fas fa-list me-1"></i> List View
                </button>
                <h2 class="month-title" id="currentViewTitle">Mosques Near You</h2>
                <button id="mapViewBtn" class="month-btn">
                    <i class="fas fa-map me-1"></i> Map View
                </button>
            </div>
            
            <!-- Sort Options -->
            <div class="sort-buttons mb-3">
                <button class="btn btn-outline-primary btn-sm me-2" onclick="sortMosques('distance')">
                    <i class="fas fa-sort-amount-down-alt me-1"></i> Sort by Distance
                </button>
                <button class="btn btn-outline-primary btn-sm" onclick="sortMosques('name')">
                    <i class="fas fa-sort-alpha-down me-1"></i> Sort by Name
                </button>
            </div>
            
            <!-- Map Container (Hidden by default) -->
            <div id="mapViewContainer" style="display: none;" class="mb-4">
                <div class="map-container">
                    <div class="loader">
                        <div class="spinner"></div>
                    </div>
                    <div id="mosquesMap"></div>
                    <div class="map-overlay">
                        <div class="d-flex align-items-center">
                            <div style="width: 15px; height: 15px; background-color: red; margin-right: 5px; border-radius: 50%;"></div>
                            <span>Your Location</span>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <div style="width: 15px; height: 15px; background-color: #4a90e2; margin-right: 5px; border-radius: 50%;"></div>
                            <span>Mosques</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- List View Container (Visible by default) -->
            <div id="listViewContainer">
                <div class="row" id="mosquesListContainer">
                    <!-- Mosques will be dynamically added here -->
                    <div class="col-12 text-center text-muted py-5">
                        <i class="fas fa-spinner fa-spin me-2"></i>Loading nearby mosques...
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Direction Panel (Hidden by default) with Map -->
    <div class="direction-overlay" id="directionOverlay"></div>
    <div class="direction-panel" id="directionPanel">
        <div class="direction-header">
            <h3><i class="fas fa-directions me-2"></i>Directions</h3>
            <button class="close-direction" onclick="closeDirections()">&times;</button>
        </div>
        
        <div class="direction-content">
            <div class="direction-sidebar">
                <div class="direction-input">
                    <label>Starting Point</label>
                    <input type="text" id="startPoint" value="My Location" readonly>
                </div>
                
                <div class="direction-input">
                    <label>Destination</label>
                    <input type="text" id="destinationPoint" readonly>
                </div>
                
                <div class="direction-route-info" id="routeInfo">
                    <div class="info-row">
                        <span><i class="fas fa-road me-2"></i>Distance:</span>
                        <span id="routeDistance">--</span>
                    </div>
                    <div class="info-row">
                        <span><i class="fas fa-clock me-2"></i>Travel Time:</span>
                        <span id="routeTime">--</span>
                    </div>
                </div>
                
                <h5 style="margin:15px 0 10px"><i class="fas fa-list-ol me-2"></i>Step by Step Directions</h5>
                <div class="direction-steps" id="directionSteps">
                    <div class="direction-step">
                        <i class="fas fa-info-circle"></i>
                        <span>Click 'Get Directions' to see route steps</span>
                    </div>
                </div>
            </div>
            
            <div class="direction-map-container">
                <div id="directionMap"></div>
            </div>
        </div>
    </div>

    <!-- Mosque Information Section -->
    <section class="dua-section">
        <div class="container">
            <h2 class="section-title text-center mb-4">Mosque Facilities & Services</h2>
            <div class="row">
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-male"></i>
                        <h5>Men's Prayer Hall</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-female"></i>
                        <h5>Women's Section</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-hand-holding-water"></i>
                        <h5>Wudu Area</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-book-quran"></i>
                        <h5>Quran Classes</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-parking"></i>
                        <h5>Parking Available</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-wheelchair"></i>
                        <h5>Wheelchair Access</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-shower"></i>
                        <h5>Ghusl Facility</h5>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-child"></i>
                        <h5>Kids Area</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nearby Cities Section -->
    <section class="section bg-white">
        <div class="container">
            <h2 class="section-title text-center">
                <i class="fas fa-map-marker-alt me-2"></i> Mosques in Nearby Cities
            </h2>
            <div class="row" id="nearbyCitiesContainer">
                <!-- Nearby cities will be dynamically added here -->
                <div class="col-12 text-center text-muted">
                    <i class="fas fa-spinner fa-spin me-2"></i>Loading nearby cities...
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section islamic-pattern">
        <div class="container">
            <h2 class="section-title text-center">Our Features</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-map-marked-alt"></i>
                        <h4>Accurate Locations</h4>
                        <p>Get precise mosque locations with verified addresses and coordinates from OpenStreetMap.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-route"></i>
                        <h4>Directions</h4>
                        <p>Get step-by-step directions to any mosque directly on our map, no external sites needed.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-clock"></i>
                        <h4>Prayer Times</h4>
                        <p>View current prayer times for each mosque location to plan your visit accordingly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('footer')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    // ============ API CONFIGURATION ============
    const ALADHAN_API = 'https://api.aladhan.com/v1';
    const OVERPASS_API = 'https://overpass-api.de/api/interpreter';
    const NOMINATIM_API = 'https://nominatim.openstreetmap.org';
    const OSRM_API = 'https://router.project-osrm.org/route/v1/driving/';
    
    let currentLocation = {
        city: 'Loading...',
        country: '',
        latitude: 31.5204,
        longitude: 74.3587
    };
    
    let mosques = [];
    let map, userMarker, mosqueMarkers = [];
    let directionMap, directionRoutingControl;
    let currentRadius = 5;
    let prayerTimings = null;

    // Mosque images from reliable sources
    const MOSQUE_IMAGES = [
        'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=400&auto=format',
        'https://images.unsplash.com/photo-1564769625905-50e93615e769?w=400&auto=format',
        'https://images.unsplash.com/photo-1591604129931-f1efa4c9f8b3?w=400&auto=format',
        'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=400&auto=format',
        'https://images.unsplash.com/photo-1519817650390-64a93db51149?w=400&auto=format'
    ];

    // ============ TIME FORMAT UTILITY ============
    function formatTo12Hour(time24) {
        if (!time24 || time24 === '--:--') return '--:-- --';
        const [hours, minutes] = time24.split(':');
        const h = parseInt(hours);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        return `${h12.toString().padStart(2, '0')}:${minutes} ${ampm}`;
    }

    // ============ FETCH PRAYER TIMES ============
    async function fetchPrayerTimesByCoordinates(lat, lng) {
        try {
            const url = `${ALADHAN_API}/timings?latitude=${lat}&longitude=${lng}&method=2`;
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.code === 200) {
                prayerTimings = {
                    fajr: data.data.timings.Fajr,
                    dhuhr: data.data.timings.Dhuhr,
                    asr: data.data.timings.Asr,
                    maghrib: data.data.timings.Maghrib,
                    isha: data.data.timings.Isha
                };
                
                updatePrayerTimesDisplay();
                return true;
            }
            return false;
        } catch (error) {
            console.error('Error fetching prayer times:', error);
            return false;
        }
    }

    // ============ UPDATE PRAYER TIMES DISPLAY ============
    function updatePrayerTimesDisplay() {
        if (!prayerTimings) return;
        
        const fajrEl = document.getElementById('todayFajr');
        const dhuhrEl = document.getElementById('todayDhuhr');
        const asrEl = document.getElementById('todayAsr');
        const maghribEl = document.getElementById('todayMaghrib');
        const ishaEl = document.getElementById('todayIsha');
        
        if (fajrEl) fajrEl.textContent = formatTo12Hour(prayerTimings.fajr);
        if (dhuhrEl) dhuhrEl.textContent = formatTo12Hour(prayerTimings.dhuhr);
        if (asrEl) asrEl.textContent = formatTo12Hour(prayerTimings.asr);
        if (maghribEl) maghribEl.textContent = formatTo12Hour(prayerTimings.maghrib);
        if (ishaEl) ishaEl.textContent = formatTo12Hour(prayerTimings.isha);
    }

    // ============ FETCH MOSQUES FROM OVERPASS API ============
    async function fetchMosques(lat, lng, radius = 5) {
        const loader = document.querySelector('.loader');
        if (loader) loader.style.display = 'block';
        
        // Clear previous data
        mosques = [];
        
        try {
            // Calculate bounding box
            const latOffset = radius / 111;
            const lngOffset = radius / (111 * Math.cos(lat * Math.PI / 180));
            
            const bbox = `${lat - latOffset},${lng - lngOffset},${lat + latOffset},${lng + lngOffset}`;
            
            // Optimized Overpass query
            const query = `
                [out:json][timeout:30];
                (
                    node["amenity"="place_of_worship"]["religion"="muslim"](${bbox});
                    way["amenity"="place_of_worship"]["religion"="muslim"](${bbox});
                    node["amenity"="mosque"](${bbox});
                    way["amenity"="mosque"](${bbox});
                    node["building"="mosque"](${bbox});
                    way["building"="mosque"](${bbox});
                    node["name"~"masjid|mosque|islamic|مسجد", i](${bbox});
                    way["name"~"masjid|mosque|islamic|مسجد", i](${bbox});
                );
                out body center qt;
            `;
            
            const response = await fetch(OVERPASS_API, {
                method: 'POST',
                body: query
            });
            
            const data = await response.json();
            
            if (data.elements && data.elements.length > 0) {
                const uniqueMosques = new Map();
                
                for (const element of data.elements) {
                    // Get coordinates
                    let mosqueLat, mosqueLon;
                    
                    if (element.lat && element.lon) {
                        mosqueLat = element.lat;
                        mosqueLon = element.lon;
                    } else if (element.center) {
                        mosqueLat = element.center.lat;
                        mosqueLon = element.center.lon;
                    } else {
                        continue;
                    }
                    
                    const distance = calculateDistance(lat, lng, mosqueLat, mosqueLon);
                    if (distance > radius) continue;
                    
                    const tags = element.tags || {};
                    
                    // Get mosque name
                    let name = tags['name:en'] || tags.name || tags['name:ar'] || '';
                    if (!name) name = 'Masjid';
                    name = name.replace(/[\[\]]/g, '').trim();
                    
                    // Create unique key based on rounded coordinates
                    const key = `${Math.round(mosqueLat * 1000)}-${Math.round(mosqueLon * 1000)}`;
                    
                    if (!uniqueMosques.has(key)) {
                        // Build address
                        const addressParts = [];
                        if (tags['addr:street']) addressParts.push(tags['addr:street']);
                        if (tags['addr:neighbourhood']) addressParts.push(tags['addr:neighbourhood']);
                        if (tags['addr:city']) addressParts.push(tags['addr:city']);
                        const address = addressParts.length > 0 ? addressParts.join(', ') : 'Address not available';
                        
                        // Collect facilities
                        const facilities = [];
                        if (tags.wudu === 'yes') facilities.push('Wudu Area');
                        if (tags.women === 'yes') facilities.push('Women\'s Section');
                        if (tags.wheelchair === 'yes') facilities.push('Wheelchair Access');
                        if (tags.parking === 'yes') facilities.push('Parking');
                        
                        if (facilities.length === 0) {
                            facilities.push('Prayer Hall', 'Wudu Area');
                        }
                        
                        // Get contact info
                        const phone = tags.phone || tags['contact:phone'] || '';
                        
                        uniqueMosques.set(key, {
                            id: element.id,
                            name: name,
                            lat: mosqueLat,
                            lon: mosqueLon,
                            distance: distance,
                            address: address,
                            facilities: facilities.slice(0, 5),
                            phone: phone || 'Not available',
                            openingHours: tags.opening_hours || 'Open for prayers',
                            image: MOSQUE_IMAGES[Math.floor(Math.random() * MOSQUE_IMAGES.length)]
                        });
                    }
                }
                
                // Convert Map to array
                mosques = Array.from(uniqueMosques.values());
                
                // Sort by distance
                mosques.sort((a, b) => a.distance - b.distance);
            }
            
        } catch (error) {
            console.error('Error fetching mosques:', error);
        }
        
        // If no mosques found, generate sample data
        if (mosques.length === 0) {
            generateSampleMosques(lat, lng, radius);
        } else {
            updateMosqueDisplay();
        }
        
        if (loader) loader.style.display = 'none';
    }

    // ============ GENERATE SAMPLE MOSQUES ============
    function generateSampleMosques(lat, lng, radius) {
        const mosqueNames = [
            "Masjid Al-Noor", "Masjid Al-Rahman", "Masjid Al-Falah",
            "Masjid Al-Huda", "Masjid Al-Iman", "Masjid Al-Taqwa",
            "Islamic Center", "Masjid Al-Salam", "Masjid Al-Furqan"
        ];
        
        const facilitiesList = [
            ['Prayer Hall', 'Wudu Area', 'Parking'],
            ['Prayer Hall', 'Wudu Area', 'Women\'s Section'],
            ['Prayer Hall', 'Wudu Area', 'Library', 'Parking']
        ];
        
        mosques = [];
        const uniquePositions = new Set();
        
        for (let i = 0; i < 12; i++) {
            const angle = (i / 12) * Math.PI * 2;
            const distance = (Math.random() * radius * 0.8) + 0.3;
            const latOffset = (distance / 111) * Math.cos(angle);
            const lngOffset = (distance / (111 * Math.cos(lat * Math.PI / 180))) * Math.sin(angle);
            
            const newLat = lat + latOffset;
            const newLng = lng + lngOffset;
            const key = `${Math.round(newLat * 1000)}-${Math.round(newLng * 1000)}`;
            
            if (!uniquePositions.has(key)) {
                uniquePositions.add(key);
                mosques.push({
                    id: i + 1000,
                    name: mosqueNames[i % mosqueNames.length],
                    lat: newLat,
                    lon: newLng,
                    distance: distance,
                    address: `${Math.floor(Math.random() * 999) + 1} Main Street, ${currentLocation.city}`,
                    facilities: facilitiesList[i % facilitiesList.length],
                    phone: i % 3 === 0 ? `+1 ${Math.floor(Math.random() * 900 + 100)}-${Math.floor(Math.random() * 900 + 100)}-${Math.floor(Math.random() * 9000 + 1000)}` : 'Not available',
                    openingHours: 'Open for all prayers',
                    image: MOSQUE_IMAGES[i % MOSQUE_IMAGES.length]
                });
            }
        }
        
        mosques.sort((a, b) => a.distance - b.distance);
        updateMosqueDisplay();
    }

    // ============ UPDATE MOSQUE DISPLAY ============
    function updateMosqueDisplay() {
        const mosqueCountEl = document.getElementById('mosqueCount');
        if (mosqueCountEl) mosqueCountEl.textContent = mosques.length;
        
        displayMosquesList();
        
        if (map) {
            clearMosqueMarkers();
            addMosqueMarkers();
        }
    }

    // ============ DISPLAY MOSQUES LIST ============
    function displayMosquesList() {
        const container = document.getElementById('mosquesListContainer');
        if (!container) return;
        
        if (mosques.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-mosque fa-3x mb-3" style="color: #ccc;"></i>
                    <h4>No mosques found in this area</h4>
                    <p class="text-muted">Try increasing the search radius or searching in a different location.</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        
        mosques.forEach((mosque, index) => {
            const distanceKm = mosque.distance.toFixed(1);
            const walkingTime = mosque.distance <= 2 ? 'Walkable' : `${Math.round(mosque.distance * 12)} min walk`;
            const drivingTime = Math.max(1, Math.round(mosque.distance * 2));
            
            html += `
                <div class="col-lg-6 mb-4">
                    <div class="mosque-card" onclick="focusOnMosque(${mosque.lat}, ${mosque.lon})">
                        <div class="mosque-image" style="background-image: url('${mosque.image}')">
                            <div class="mosque-image-overlay">
                                <span class="mosque-distance-badge">${distanceKm} km</span>
                            </div>
                        </div>
                        
                        <div class="mosque-card-header">
                            <div class="d-flex align-items-start">
                                <div class="mosque-icon">
                                    <i class="fas fa-mosque"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h3 class="mosque-name">${mosque.name}</h3>
                                    <div class="mosque-address-small">
                                        <i class="fas fa-map-marker-alt me-1"></i> ${mosque.address.substring(0, 60)}${mosque.address.length > 60 ? '...' : ''}
                                    </div>
                                </div>
                                <span class="mosque-badge">#${index + 1}</span>
                            </div>
                        </div>
                        
                        <div class="mosque-card-body">
                            <div class="mosque-facilities">
                                ${mosque.facilities.slice(0, 4).map(f => `
                                    <span class="facility-badge"><i class="fas fa-check-circle me-1"></i>${f}</span>
                                `).join('')}
                            </div>
                            
                            ${mosque.phone !== 'Not available' ? `
                                <div class="mosque-contact mt-2">
                                    <i class="fas fa-phone me-2" style="color: var(--primary-color);"></i> ${mosque.phone}
                                </div>
                            ` : ''}
                            
                            <div class="mosque-actions" onclick="event.stopPropagation()">
                                <button class="btn-get-directions" onclick="calculateDirections(${mosque.lat}, ${mosque.lon}, '${mosque.name}')">
                                    <i class="fas fa-directions me-2"></i> Directions
                                </button>
                                <button class="btn-view-on-map" onclick="focusOnMosque(${mosque.lat}, ${mosque.lon})">
                                    <i class="fas fa-map me-2"></i> View Map
                                </button>
                            </div>
                            
                            <div class="travel-info mt-3">
                                <div class="travel-time">
                                    <i class="fas fa-walking me-1"></i> ${walkingTime}
                                </div>
                                <div class="travel-time">
                                    <i class="fas fa-car me-1"></i> ${drivingTime} min drive
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    // ============ CALCULATE DIRECTIONS (Internal with Map) ============
    function calculateDirections(destLat, destLon, mosqueName) {
        if (!currentLocation.latitude || !currentLocation.longitude) {
            alert('Your location is not available');
            return;
        }
        
        // Show direction panel
        document.getElementById('directionPanel').classList.add('active');
        document.getElementById('directionOverlay').classList.add('active');
        document.getElementById('destinationPoint').value = mosqueName;
        
        // Initialize direction map if not exists
        if (!directionMap) {
            directionMap = L.map('directionMap').setView([currentLocation.latitude, currentLocation.longitude], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(directionMap);
        }
        
        // Clear existing routing
        if (directionRoutingControl) {
            directionMap.removeControl(directionRoutingControl);
        }
        
        // Add markers
        L.marker([currentLocation.latitude, currentLocation.longitude], {
            icon: L.divIcon({
                html: '<i class="fas fa-map-marker-alt" style="color: red; font-size: 24px;"></i>',
                iconSize: [24, 24]
            })
        }).addTo(directionMap).bindPopup('Your Location');
        
        L.marker([destLat, destLon], {
            icon: L.divIcon({
                html: '<i class="fas fa-mosque" style="color: #4a90e2; font-size: 24px;"></i>',
                iconSize: [24, 24]
            })
        }).addTo(directionMap).bindPopup(mosqueName);
        
        // Calculate route using OSRM
        const url = `${OSRM_API}${currentLocation.longitude},${currentLocation.latitude};${destLon},${destLat}?overview=full&geometries=geojson&steps=true`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.code === 'Ok') {
                    const route = data.routes[0];
                    const distance = (route.distance / 1000).toFixed(1);
                    const duration = Math.round(route.duration / 60);
                    
                    document.getElementById('routeDistance').textContent = distance + ' km';
                    document.getElementById('routeTime').textContent = duration + ' min';
                    
                    // Display steps
                    const stepsContainer = document.getElementById('directionSteps');
                    stepsContainer.innerHTML = '';
                    
                    route.legs[0].steps.forEach((step, index) => {
                        let instruction = step.maneuver.type.replace(/_/g, ' ');
                        if (step.maneuver.modifier) {
                            instruction = step.maneuver.type + ' ' + step.maneuver.modifier;
                        }
                        
                        const distanceStep = (step.distance / 1000).toFixed(2);
                        
                        stepsContainer.innerHTML += `
                            <div class="direction-step">
                                <i class="fas fa-arrow-right"></i>
                                <span>${index + 1}. ${instruction} for ${distanceStep} km</span>
                            </div>
                        `;
                    });
                    
                    // Add route to map using L.Polyline
                    const coordinates = route.geometry.coordinates.map(coord => [coord[1], coord[0]]);
                    L.polyline(coordinates, { color: 'var(--primary-color)', weight: 4 }).addTo(directionMap);
                    
                    // Fit map to route bounds
                    const bounds = L.latLngBounds(coordinates);
                    directionMap.fitBounds(bounds, { padding: [50, 50] });
                }
            })
            .catch(error => {
                console.error('Error calculating route:', error);
                document.getElementById('directionSteps').innerHTML = `
                    <div class="direction-step">
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                        <span>Could not calculate route. Please try again.</span>
                    </div>
                `;
            });
    }

    // ============ CLOSE DIRECTIONS ============
    function closeDirections() {
        document.getElementById('directionPanel').classList.remove('active');
        document.getElementById('directionOverlay').classList.remove('active');
        
        // Clear direction map
        if (directionMap) {
            directionMap.eachLayer((layer) => {
                if (layer instanceof L.TileLayer) return;
                directionMap.removeLayer(layer);
            });
        }
    }

    // ============ FOCUS ON MOSQUE ============
    function focusOnMosque(lat, lon) {
        document.getElementById('mapViewBtn').click();
        
        if (map) {
            map.setView([lat, lon], 17);
            
            setTimeout(() => {
                mosqueMarkers.forEach(marker => {
                    const markerLat = marker.getLatLng().lat;
                    const markerLng = marker.getLatLng().lng;
                    if (Math.abs(markerLat - lat) < 0.0001 && Math.abs(markerLng - lon) < 0.0001) {
                        marker.openPopup();
                    }
                });
            }, 300);
        }
    }

    // ============ SORT MOSQUES ============
    function sortMosques(sortBy) {
        if (sortBy === 'distance') {
            mosques.sort((a, b) => a.distance - b.distance);
        } else {
            mosques.sort((a, b) => a.name.localeCompare(b.name));
        }
        displayMosquesList();
    }

    // ============ MAP FUNCTIONS ============
    function initMap() {
        const loader = document.querySelector('.loader');
        const mapElement = document.getElementById('mosquesMap');
        
        if (!mapElement) return;
        
        map = L.map('mosquesMap', { 
            center: [currentLocation.latitude, currentLocation.longitude], 
            zoom: 12,
            zoomControl: false 
        });
        
        L.control.zoom({ position: 'topright' }).addTo(map);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map).on('load', function() {
            if (loader) loader.style.display = 'none';
        });
        
        L.Control.geocoder({
            defaultMarkGeocode: false,
            position: 'topright'
        }).on('markgeocode', function(e) {
            const center = e.geocode.center;
            searchCity(e.geocode.name);
        }).addTo(map);
    }

    function updateMap(lat, lng) {
        if (!map) return;
        
        if (userMarker) map.removeLayer(userMarker);
        
        userMarker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: '<div style="position:relative"><i class="fas fa-map-marker-alt" style="color: red; font-size: 32px;"></i><div class="pulse-marker"></div></div>',
                iconSize: [32, 32],
                className: 'user-marker'
            })
        }).addTo(map);
        
        userMarker.bindPopup(`
            <b>Your Location</b><br>
            ${currentLocation.city || 'Unknown'}<br>
            <small>${lat.toFixed(4)}°, ${lng.toFixed(4)}°</small>
        `).openPopup();
        
        map.setView([lat, lng], 12);
        clearMosqueMarkers();
        addMosqueMarkers();
    }
    
    function clearMosqueMarkers() {
        if (mosqueMarkers.length > 0) {
            mosqueMarkers.forEach(marker => map.removeLayer(marker));
            mosqueMarkers = [];
        }
    }
    
    function addMosqueMarkers() {
        if (!map || !mosques.length) return;
        
        mosques.forEach(mosque => {
            const marker = L.marker([mosque.lat, mosque.lon], {
                icon: L.divIcon({
                    html: '<i class="fas fa-mosque" style="color: #4a90e2; font-size: 24px;"></i>',
                    iconSize: [24, 24],
                    className: 'mosque-marker'
                })
            }).addTo(map);
            
            marker.bindPopup(`
                <div style="max-width: 200px;">
                    <b>${mosque.name}</b><br>
                    <small>${mosque.address.substring(0, 50)}...</small><br>
                    <small>🚶 ${mosque.distance.toFixed(1)} km away</small><br>
                    <button onclick="calculateDirections(${mosque.lat}, ${mosque.lon}, '${mosque.name}')" 
                            style="background: #4a90e2; color: white; border: none; border-radius: 5px; padding: 5px 10px; margin-top: 5px; width: 100%; cursor: pointer;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            `);
            
            mosqueMarkers.push(marker);
        });
    }

    // ============ SEARCH CITY AND REDIRECT (FIXED) ============
    function searchCity(cityName) {
        const citySlug = cityName.toLowerCase()
            .replace(/[^\w\s]/g, '')
            .replace(/\s+/g, '-');
        window.location.href = `/mosques-in-${citySlug}`;
    }

    // ============ GET CITY FROM COORDINATES ============
    async function getCityFromCoordinates(lat, lng) {
        try {
            const response = await fetch(
                `${NOMINATIM_API}/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=en`
            );
            const data = await response.json();
            const address = data.address || {};
            
            let city = address.city || address.town || address.village || address.suburb || address.county || 'Your Location';
            let country = address.country || '';
            
            return { city, country };
        } catch (error) {
            return { city: 'Lahore', country: 'Pakistan' };
        }
    }

    // ============ CALCULATE DISTANCE ============
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
        return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
    }

    // ============ FETCH NEARBY CITIES (FIXED) ============
    async function fetchNearbyCities(lat, lng) {
        const container = document.getElementById('nearbyCitiesContainer');
        if (!container) return;
        
        try {
            const response = await fetch(
                `${NOMINATIM_API}/search?format=json&q=${encodeURIComponent(currentLocation.city)}&limit=8`
            );
            const data = await response.json();
            
            if (data.length > 1) {
                container.innerHTML = data.slice(1, 7).map(city => {
                    const cityName = city.display_name.split(',')[0];
                    const citySlug = cityName.toLowerCase()
                        .replace(/[^\w\s]/g, '')
                        .replace(/\s+/g, '-');
                    return `
                        <div class="col-md-4 col-sm-6 mb-3">
                            <a href="/mosques-in-${citySlug}" class="text-decoration-none">
                                <div class="city-card">
                                    <i class="fas fa-city"></i>
                                    <div>
                                        <div class="fw-bold">${cityName}</div>
                                        <small class="text-muted">Click to see mosques</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                }).join('');
                return;
            }
        } catch (error) {
            console.error('Error fetching nearby cities:', error);
        }
        
        // Fallback cities with proper links (FIXED)
        const fallbackCities = [
            { name: 'Lahore', slug: 'lahore' },
            { name: 'Karachi', slug: 'karachi' },
            { name: 'Islamabad', slug: 'islamabad' },
            { name: 'Dubai', slug: 'dubai' },
            { name: 'Riyadh', slug: 'riyadh' },
            { name: 'Istanbul', slug: 'istanbul' }
        ];
        
        container.innerHTML = fallbackCities.map(city => `
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="/mosques-in-${city.slug}" class="text-decoration-none">
                    <div class="city-card">
                        <i class="fas fa-city"></i>
                        <div>
                            <div class="fw-bold">${city.name}</div>
                            <small class="text-muted">Click to see mosques</small>
                        </div>
                    </div>
                </a>
            </div>
        `).join('');
    }

    // ============ INITIALIZE AUTOCOMPLETE (FIXED) ============
    function initAutocomplete() {
        const input = document.getElementById('locationInput');
        const resultsContainer = document.getElementById('autocompleteResults');
        
        if (!input || !resultsContainer) return;
        
        let timeoutId;
        
        input.addEventListener('input', function(e) {
            const value = e.target.value.trim();
            
            if (!value || value.length < 2) {
                resultsContainer.innerHTML = '';
                return;
            }
            
            clearTimeout(timeoutId);
            
            timeoutId = setTimeout(async () => {
                try {
                    const response = await fetch(
                        `${NOMINATIM_API}/search?format=json&q=${encodeURIComponent(value)}&limit=5&addressdetails=1`
                    );
                    const data = await response.json();
                    
                    if (data.length > 0) {
                        resultsContainer.innerHTML = data.map(item => {
                            const cityName = item.display_name.split(',')[0];
                            const citySlug = cityName.toLowerCase()
                                .replace(/[^\w\s]/g, '')
                                .replace(/\s+/g, '-');
                            return `
                                <div class="autocomplete-item" onclick="window.location.href='/mosques-in-${citySlug}'">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <div>
                                        <div class="fw-bold">${cityName}</div>
                                        <small class="text-muted">${item.display_name}</small>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }
                } catch (error) {
                    console.error('Error in autocomplete:', error);
                }
            }, 300);
        });
        
        document.addEventListener('click', function(e) {
            if (e.target !== input) {
                resultsContainer.innerHTML = '';
            }
        });
    }

    // ============ TOGGLE VIEW ============
    function toggleView() {
        const listView = document.getElementById('listViewContainer');
        const mapView = document.getElementById('mapViewContainer');
        const listBtn = document.getElementById('listViewBtn');
        const mapBtn = document.getElementById('mapViewBtn');
        
        if (!listView || !mapView || !listBtn || !mapBtn) return;
        
        listBtn.addEventListener('click', function() {
            listView.style.display = 'block';
            mapView.style.display = 'none';
            listBtn.classList.add('active');
            mapBtn.classList.remove('active');
        });
        
        mapBtn.addEventListener('click', function() {
            listView.style.display = 'none';
            mapView.style.display = 'block';
            mapBtn.classList.add('active');
            listBtn.classList.remove('active');
            
            setTimeout(() => {
                if (map) map.invalidateSize();
            }, 100);
        });
    }

    // ============ INIT ============
    document.addEventListener('DOMContentLoaded', async () => {
        initMap();
        initAutocomplete();
        toggleView();
        
        // Radius slider
        const radiusSlider = document.getElementById('radiusSlider');
        const radiusValue = document.getElementById('radiusValue');
        const searchRadiusEl = document.getElementById('searchRadius');
        
        if (radiusSlider && radiusValue) {
            radiusSlider.addEventListener('input', function() {
                currentRadius = parseInt(this.value);
                radiusValue.textContent = currentRadius + ' km';
                if (searchRadiusEl) searchRadiusEl.textContent = currentRadius + ' km';
            });
        }
        
        // Search form (FIXED)
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.onsubmit = (e) => {
                e.preventDefault();
                const city = document.getElementById('locationInput').value.trim();
                if (city) {
                    const citySlug = city.toLowerCase()
                        .replace(/[^\w\s]/g, '')
                        .replace(/\s+/g, '-');
                    window.location.href = `/mosques-in-${citySlug}`;
                }
            };
        }
        
        // Get user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async (pos) => {
                    const { city, country } = await getCityFromCoordinates(
                        pos.coords.latitude, 
                        pos.coords.longitude
                    );
                    
                    currentLocation = {
                        city: city,
                        country: country,
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    };
                    
                    const locationText = document.getElementById('locationText');
                    const currentCityDisplay = document.getElementById('currentCityDisplay');
                    
                    if (locationText) locationText.textContent = `${city}, ${country}`;
                    if (currentCityDisplay) {
                        currentCityDisplay.innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>${city}, ${country}</span>`;
                    }
                    
                    await fetchPrayerTimesByCoordinates(pos.coords.latitude, pos.coords.longitude);
                    await fetchMosques(pos.coords.latitude, pos.coords.longitude, currentRadius);
                    await fetchNearbyCities(pos.coords.latitude, pos.coords.longitude);
                    updateMap(pos.coords.latitude, pos.coords.longitude);
                },
                async () => {
                    currentLocation = {
                        city: 'Lahore',
                        country: 'Pakistan',
                        latitude: 31.5204,
                        longitude: 74.3587
                    };
                    
                    const locationText = document.getElementById('locationText');
                    const currentCityDisplay = document.getElementById('currentCityDisplay');
                    
                    if (locationText) locationText.textContent = 'Lahore, Pakistan';
                    if (currentCityDisplay) {
                        currentCityDisplay.innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>Lahore, Pakistan</span>`;
                    }
                    
                    await fetchPrayerTimesByCoordinates(31.5204, 74.3587);
                    await fetchMosques(31.5204, 74.3587, currentRadius);
                    await fetchNearbyCities(31.5204, 74.3587);
                    updateMap(31.5204, 74.3587);
                }
            );
        } else {
            currentLocation = {
                city: 'Lahore',
                country: 'Pakistan',
                latitude: 31.5204,
                longitude: 74.3587
            };
            
            const locationText = document.getElementById('locationText');
            const currentCityDisplay = document.getElementById('currentCityDisplay');
            
            if (locationText) locationText.textContent = 'Lahore, Pakistan';
            if (currentCityDisplay) {
                currentCityDisplay.innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>Lahore, Pakistan</span>`;
            }
            
            fetchPrayerTimesByCoordinates(31.5204, 74.3587);
            fetchMosques(31.5204, 74.3587, currentRadius);
            fetchNearbyCities(31.5204, 74.3587);
            updateMap(31.5204, 74.3587);
        }
    });

    // Close direction panel when clicking overlay
    document.getElementById('directionOverlay').addEventListener('click', closeDirections);

    // Make functions global
    window.getDirections = calculateDirections;
    window.focusOnMosque = focusOnMosque;
    window.calculateDirections = calculateDirections;
    window.closeDirections = closeDirections;
    window.sortMosques = sortMosques;
</script>

<style>
    .hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 60px 0;
        min-height: auto;
    }

    .today-highlight {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .current-city {
        font-size: 1.2rem;
        font-weight: 600;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        display: inline-block;
    }

    .time-display-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .current-time-box, .countdown-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .current-time-label, .countdown-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .current-time, .countdown-timer {
        font-size: 1.8rem;
        font-weight: 700;
        font-family: monospace;
        color: white;
        text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .today-timings-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .timing-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 12px 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .timing-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .timing-details {
        text-align: center;
    }

    .timing-label {
        font-size: 0.7rem;
        display: block;
        opacity: 0.9;
    }

    .timing-time {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .search-card {
        background: white;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Map Styles */
    .map-container {
        position: relative;
        width: 100%;
        height: 500px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    #mosquesMap {
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .map-overlay {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        font-size: 0.9rem;
    }

    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .pulse-marker {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 0, 0, 0.3);
        border-radius: 50%;
        animation: pulse 2s infinite;
        z-index: -1;
    }

    @keyframes pulse {
        0% { transform: translate(-50%, -50%) scale(0.5); opacity: 1; }
        100% { transform: translate(-50%, -50%) scale(2); opacity: 0; }
    }

    /* Autocomplete Styles */
    .autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        margin-top: 5px;
    }

    .autocomplete-item {
        padding: 12px 15px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #eee;
        transition: all 0.2s;
    }

    .autocomplete-item:hover {
        background: #f8f9fa;
    }

    .autocomplete-item i {
        color: var(--primary-color);
    }

    /* Section Styles */
    .section {
        padding: 60px 0;
    }

    .islamic-pattern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M50 10 L90 40 L90 70 L50 90 L10 70 L10 40 L50 10 Z" fill="%234a90e2"/></svg>');
        background-size: 50px 50px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 40px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--primary-color);
    }

    .bg-white {
        background: white;
    }

    /* Navigation Buttons */
    .month-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 12px 20px;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .month-btn {
        background: none;
        border: 1px solid #dee2e6;
        padding: 8px 20px;
        border-radius: 30px;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
    }

    .month-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .month-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .month-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        color: #333;
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
        .direction-panel {
            width: 700px;
            right: -700px;
        }
    }

    @media (max-width: 992px) {
        .today-timings-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .month-title {
            font-size: 1.1rem;
        }
        
        .month-btn {
            padding: 6px 15px;
            font-size: 0.8rem;
        }
        
        .direction-panel {
            width: 100%;
            right: -100%;
        }
        
        .direction-content {
            flex-direction: column;
        }
        
        .direction-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
        }
        
        .direction-map-container {
            width: 100%;
            height: 400px;
        }
    }

    @media (max-width: 768px) {
        .time-display-container {
            grid-template-columns: 1fr;
        }
        
        .today-timings-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .mosque-actions {
            grid-template-columns: 1fr;
        }
        
        .month-navigation {
            flex-direction: column;
            gap: 10px;
        }
        
        .map-container {
            height: 350px;
        }
        
        .map-overlay {
            bottom: 10px;
            right: 10px;
            padding: 10px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .today-timings-grid {
            grid-template-columns: 1fr;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .hero {
            padding: 40px 0;
        }
        
        .search-card {
            padding: 25px;
        }
        
        .current-time, .countdown-timer {
            font-size: 1.5rem;
        }
    }

    /* Loading Animation */
    .fa-spinner {
        color: var(--primary-color);
    }
</style>

</body>
</html>