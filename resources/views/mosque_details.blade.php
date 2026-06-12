@section('title', $metaTitle)
@section('description', $metaDescription)
@section('keywords', $metaKeywords)
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
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

    /* Mosque Detail Styles */
    .facility-tag {
        display: inline-block;
        background: #e8f4fd;
        color: var(--primary-color);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .facility-tag i {
        margin-right: 3px;
        font-size: 0.7rem;
    }
    
    .distance-badge {
        background: var(--primary-color);
        color: white;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .sort-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .sort-btn {
        background: white;
        border: 1px solid #dee2e6;
        padding: 8px 20px;
        border-radius: 30px;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    
    .sort-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .sort-btn:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .contact-info {
        font-size: 0.85rem;
        color: #666;
    }
    
    .contact-info i {
        width: 18px;
        color: var(--primary-color);
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

    /* SEO Content Styles */
    .seo-content {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .seo-content h2 {
        font-size: 1.5rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #333;
        font-weight: 600;
    }
    
    .seo-content h3 {
        font-size: 1.25rem;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
        color: #555;
        font-weight: 500;
    }
    
    .seo-content ul, .seo-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    
    .seo-content li {
        margin-bottom: 0.5rem;
        color: #666;
        line-height: 1.5;
    }
    
    .seo-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
        color: #666;
        font-size: 1rem;
    }
    
    .seo-content a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
    
    .seo-content a:hover {
        text-decoration: underline;
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

    /* Back Button */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: var(--primary-color);
        padding: 8px 16px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        border: 1px solid var(--primary-color);
        transition: all 0.2s ease;
        margin-bottom: 15px;
    }
    
    .back-button:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .back-button i {
        font-size: 0.9rem;
    }
    
    /* City Links */
    .city-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 15px 0 5px;
    }
    
    .city-link-btn {
        background: #f8f9fa;
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.8rem;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }
    
    .city-link-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* City Details Table - Moved below hero */
    .city-details-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-top: 30px;
    }
    
    .city-details-table table {
        margin-bottom: 0;
    }
    
    .city-details-table th {
        background: var(--primary-color);
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 12px;
        border: none;
    }
    
    .city-details-table td {
        padding: 10px 12px;
        font-size: 0.9rem;
        border-color: #f0f0f0;
    }
    
    .city-details-table tr:last-child td {
        border-bottom: none;
    }
    
    .city-details-table .label {
        font-weight: 600;
        color: #555;
        width: 40%;
    }
    
    .city-details-table .value {
        color: #333;
        font-weight: 500;
    }
</style>

<!-- Hero Section - Only Heading -->
<section class="hero text-white">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Back Button -->
                <a href="/mosque-near-me" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Mosques Near Me
                </a>
                
                <div class="text-center">
                    <h1 class="display-4 fw-bold">
                        Mosques in {{ $city }}, {{ $country }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- City Details Table Section (Below Hero) -->
<section class="section bg-white pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- City Details Table -->
                <div class="city-details-table">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">
                                    <i class="fas fa-info-circle me-2"></i>{{ $city }} City Information
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label"><i class="fas fa-city me-2 text-primary"></i>City Name</td>
                                <td class="value">{{ $city }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-globe me-2 text-primary"></i>Country</td>
                                <td class="value">{{ $country }}</td>
                            </tr>
                            @if(!empty($state) && $state !== 'Unknown')
                            <tr>
                                <td class="label"><i class="fas fa-map-pin me-2 text-primary"></i>State/Region</td>
                                <td class="value">{{ $state }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="label"><i class="fas fa-mosque me-2 text-primary"></i>Total Mosques Found</td>
                                <td class="value"><strong class="text-primary">{{ $totalMosques }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-clock me-2 text-primary"></i>Last Updated</td>
                                <td class="value">{{ now()->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-compass me-2 text-primary"></i>Qibla Direction</td>
                                <td class="value"><span id="qiblaDirection">--°</span></td>
                            </tr>
                            <tr>
                                <td class="label"><i class="fas fa-search me-2 text-primary"></i>Search Radius</td>
                                <td class="value"><span id="searchRadiusDisplay">5 km</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- City Links Section -->
<section class="section bg-white pt-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- City Links -->
                <div class="city-links">
                    <a href="/{{ strtolower(str_replace(' ', '-', $city)) }}-ramadan-timings" class="city-link-btn">
                        <i class="fas fa-moon me-1"></i> {{ $city }} Ramadan Timings
                    </a>
                    <a href="/prayer-times-in-{{ strtolower(str_replace(' ', '-', $city)) }}" class="city-link-btn">
                        <i class="fas fa-clock me-1"></i> Prayer Times in {{ $city }}
                    </a>
                    <a href="/{{ strtolower(str_replace(' ', '-', $city)) }}-qibla-direction" class="city-link-btn">
                        <i class="fas fa-compass me-1"></i> {{ $city }} Qibla Direction
                    </a>
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
                <i class="fas fa-list me-1"></i> List View ({{ $totalMosques }} Mosques)
            </button>
            <h2 class="month-title" id="currentViewTitle">Mosques in {{ $city }}</h2>
            <button id="mapViewBtn" class="month-btn">
                <i class="fas fa-map me-1"></i> Map View
            </button>
        </div>
        
        <!-- Sort Buttons -->
        <div class="sort-buttons" id="sortButtons">
            <button class="sort-btn active" data-sort="distance">Sort by Distance</button>
            <button class="sort-btn" data-sort="name">Sort by Name</button>
        </div>
        
        <!-- Map Container (Hidden by default) with Green Markers -->
        <div id="mapViewContainer" style="display: none;" class="mb-4">
            <div class="map-container">
                <div class="loader">
                    <div class="spinner"></div>
                </div>
                <div id="mosquesMap" style="height: 500px; width: 100%; border-radius: 10px;"></div>
                <div class="map-overlay">
                    <div class="d-flex align-items-center">
                        <div style="width: 15px; height: 15px; background-color: red; margin-right: 5px; border-radius: 50%;"></div>
                        <span>Your Location ({{ $city }})</span>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 5px; border-radius: 50%;"></div>
                        <span>Mosques</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- List View Container (Visible by default) -->
        <div id="listViewContainer">
            <div class="row" id="mosquesListContainer">
                @forelse($mosques as $index => $mosque)
                <div class="col-lg-6 mb-4 mosque-item" 
                     data-distance="{{ $mosque['distance'] }}" 
                     data-name="{{ $mosque['name'] }}">
                    <div class="mosque-card" onclick="focusOnMosque({{ $mosque['lat'] }}, {{ $mosque['lon'] }})">
                        @if(isset($mosque['image']))
                        <div class="mosque-image" style="background-image: url('{{ $mosque['image'] }}')">
                            <div class="mosque-image-overlay">
                                <span class="distance-badge">{{ $mosque['distance'] }} km</span>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mosque-card-header">
                            <div class="d-flex align-items-start">
                                <div class="mosque-icon">
                                    <i class="fas fa-mosque"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h3 class="mosque-name">{{ $mosque['name'] }}</h3>
                                    <div class="mosque-address-small">
                                        <i class="fas fa-map-marker-alt me-1"></i> 
                                        {{ Str::limit($mosque['address'], 60) }}
                                    </div>
                                </div>
                                <span class="mosque-badge">#{{ $index + 1 }}</span>
                            </div>
                        </div>
                        
                        <div class="mosque-card-body">
                            @if(!empty($mosque['facilities']))
                            <div class="mosque-facilities mb-3">
                                @foreach($mosque['facilities'] as $facility)
                                    <span class="facility-tag">
                                        <i class="fas fa-check-circle"></i> {{ $facility }}
                                    </span>
                                @endforeach
                            </div>
                            @endif
                            
                            <div class="contact-info mb-3">
                                @if(!empty($mosque['phone']) && $mosque['phone'] !== 'Not available')
                                <div class="mb-1">
                                    <i class="fas fa-phone me-2"></i> {{ $mosque['phone'] }}
                                </div>
                                @endif
                                
                                @if(!empty($mosque['opening_hours']))
                                <div class="mb-1">
                                    <i class="fas fa-clock me-2"></i> {{ $mosque['opening_hours'] }}
                                </div>
                                @endif
                            </div>
                            
                            <div class="mosque-actions" onclick="event.stopPropagation()">
                                <button class="btn-get-directions" onclick="calculateDirections({{ $mosque['lat'] }}, {{ $mosque['lon'] }}, '{{ $mosque['name'] }}')">
                                    <i class="fas fa-directions me-2"></i> Directions
                                </button>
                                <button class="btn-view-on-map" onclick="focusOnMosque({{ $mosque['lat'] }}, {{ $mosque['lon'] }})">
                                    <i class="fas fa-map me-2"></i> View on Map
                                </button>
                            </div>
                            
                            <div class="travel-info mt-3">
                                <div class="travel-time">
                                    <i class="fas fa-walking me-1"></i> 
                                    {{ $mosque['distance'] <= 2 ? 'Walkable' : round($mosque['distance'] * 12) . ' min walk' }}
                                </div>
                                <div class="travel-time">
                                    <i class="fas fa-car me-1"></i> 
                                    {{ max(1, round($mosque['distance'] * 2)) }} min drive
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-mosque fa-3x mb-3" style="color: #ccc;"></i>
                    <h4>No mosques found in {{ $city }}</h4>
                    <p class="text-muted">Try increasing the search radius or searching in a different location.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- SEO Content Section - AFTER Mosque List -->
<section class="section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- SEO Content -->
                <div class="seo-content">
                    {!! $mainDescription !!}
                    
                    <!-- Natural paragraph with links -->
                    <p class="mt-3">
                        Planning your prayers in <strong>{{ $city }}</strong>? Check the 
                        <a href="/{{ strtolower(str_replace(' ', '-', $city)) }}-ramadan-timings">Ramadan timings for {{ $city }}</a>, 
                        view <a href="/prayer-times-in-{{ strtolower(str_replace(' ', '-', $city)) }}">daily prayer times</a>, 
                        or find the <a href="/{{ strtolower(str_replace(' ', '-', $city)) }}-qibla-direction">Qibla direction</a> 
                        for accurate prayer alignment.
                    </p>
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
                <input type="text" id="startPoint" value="{{ $city }}, {{ $country }}" readonly>
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
        <h2 class="section-title text-center mb-4">Mosque Facilities & Services in {{ $city }}</h2>
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
                    <h5>Parking</h5>
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
@if(isset($citiesInCountry) && $citiesInCountry->count() > 0)
<section class="section bg-white">
    <div class="container">
        <h2 class="section-title text-center">
            <i class="fas fa-map-marker-alt me-2"></i> Mosques in Nearby Cities of {{ $country }}
        </h2>
        <p class="text-center mb-5">Find mosques in other cities near {{ $city }}, {{ $country }}.</p>
        <div class="row">
            @foreach($citiesInCountry as $nearbyCity)
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="{{ route('mosque.show', ['city' => $nearbyCity->slug]) }}" class="text-decoration-none">
                    <div class="city-card">
                        <i class="fas fa-mosque me-3" style="color: var(--primary-color);"></i>
                        <div>
                            <div class="fw-bold">{{ $nearbyCity->city }}</div>
                            <small class="text-muted">{{ $nearbyCity->country }}</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="section islamic-pattern">
    <div class="container">
        <h2 class="section-title text-center">Why Use Our Mosque Finder?</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h4>📍 Accurate Locations</h4>
                    <p>Get precise mosque locations with verified addresses and coordinates from OpenStreetMap. Find masjids near you with precise GPS data.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-mosque"></i>
                    <h4>🕌 Complete Mosque Data</h4>
                    <p>View mosque names, addresses, facilities, and contact information. Get comprehensive details about each Islamic center in {{ $city }}.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <i class="fas fa-route"></i>
                    <h4>🗺️ Directions & Distance</h4>
                    <p>Get turn-by-turn directions, accurate distances, and estimated travel times to any mosque. Never miss a prayer.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('footer')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    // Mosque data from controller
    const mosques = @json($mosques);
    const cityLat = {{ $latitude }};
    const cityLng = {{ $longitude }};
    const cityName = "{{ $city }}";
    const countryName = "{{ $country }}";
    
    let map;
    let userMarker;
    let mosqueMarkers = [];
    let directionMap;
    let directionRoutingControl;
    let currentSort = 'distance';

    // Initialize main map
    function initMap() {
        const loader = document.querySelector('.loader');
        if (loader) loader.style.display = 'block';
        
        const mapContainer = document.getElementById('mosquesMap');
        if (!mapContainer) {
            console.error('Map container not found');
            if (loader) loader.style.display = 'none';
            return;
        }
        
        // Create map centered on city
        map = L.map('mosquesMap', {
            center: [cityLat, cityLng],
            zoom: 12,
            zoomControl: true
        });
        
        // Add base map layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map).on('load', function() {
            if (loader) loader.style.display = 'none';
        });
        
        // Add city marker (red)
        const cityIcon = L.divIcon({
            html: '<div style="position:relative"><i class="fas fa-map-marker-alt" style="color: red; font-size: 32px;"></i><div class="pulse-marker"></div></div>',
            iconSize: [32, 32],
            className: 'city-marker'
        });
        
        userMarker = L.marker([cityLat, cityLng], {
            icon: cityIcon
        }).addTo(map);
        
        userMarker.bindPopup(`
            <b>{{ $city }}, {{ $country }}</b><br>
            <small>Lat: {{ number_format($latitude, 4) }}°, Lng: {{ number_format($longitude, 4) }}°</small>
        `).openPopup();
        
        // Add mosque markers (green)
        addMosqueMarkers();
    }
    
    // Add mosque markers to main map (green dots)
    function addMosqueMarkers() {
        mosqueMarkers.forEach(marker => map.removeLayer(marker));
        mosqueMarkers = [];
        
        mosques.forEach(mosque => {
            // Green marker for mosques - using circle for better visibility
            const mosqueIcon = L.divIcon({
                html: '<i class="fas fa-circle" style="color: #28a745; font-size: 14px; text-shadow: 0 0 2px white;"></i>',
                iconSize: [14, 14],
                className: 'mosque-marker'
            });
            
            const marker = L.marker([mosque.lat, mosque.lon], {
                icon: mosqueIcon
            }).addTo(map);
            
            marker.bindPopup(`
                <div style="max-width: 200px;">
                    <b>${mosque.name}</b><br>
                    <small>${mosque.address}</small><br>
                    <small>Distance: ${mosque.distance} km</small><br>
                    <button onclick="calculateDirections(${mosque.lat}, ${mosque.lon}, '${mosque.name}')" 
                            style="background: #4a90e2; color: white; border: none; border-radius: 5px; padding: 5px 10px; margin-top: 5px; width: 100%; cursor: pointer;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            `);
            
            marker.on('click', function() {
                calculateDirections(mosque.lat, mosque.lon, mosque.name);
            });
            
            mosqueMarkers.push(marker);
        });
    }
    
    // Calculate directions with internal map
    function calculateDirections(destLat, destLon, mosqueName) {
        // Show direction panel
        document.getElementById('directionPanel').classList.add('active');
        document.getElementById('directionOverlay').classList.add('active');
        document.getElementById('destinationPoint').value = mosqueName;
        
        // Initialize direction map if not exists
        if (!directionMap) {
            directionMap = L.map('directionMap').setView([cityLat, cityLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(directionMap);
        } else {
            // Clear existing layers (except tile layer)
            directionMap.eachLayer((layer) => {
                if (layer instanceof L.TileLayer) return;
                directionMap.removeLayer(layer);
            });
        }
        
        // Add start marker
        L.marker([cityLat, cityLng], {
            icon: L.divIcon({
                html: '<i class="fas fa-map-marker-alt" style="color: red; font-size: 24px;"></i>',
                iconSize: [24, 24]
            })
        }).addTo(directionMap).bindPopup('Start: ' + cityName);
        
        // Add destination marker (green)
        L.marker([destLat, destLon], {
            icon: L.divIcon({
                html: '<i class="fas fa-mosque" style="color: #28a745; font-size: 24px;"></i>',
                iconSize: [24, 24]
            })
        }).addTo(directionMap).bindPopup('Destination: ' + mosqueName);
        
        // Calculate route using OSRM
        const url = `https://router.project-osrm.org/route/v1/driving/${cityLng},${cityLat};${destLon},${destLat}?overview=full&geometries=geojson&steps=true`;
        
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
    
    // Close directions panel
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
    
    // Focus on mosque
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
    
    // Sort mosques
    function sortMosques(sortBy) {
        const container = document.getElementById('mosquesListContainer');
        const items = Array.from(document.querySelectorAll('.mosque-item'));
        
        items.sort((a, b) => {
            if (sortBy === 'distance') {
                return parseFloat(a.dataset.distance) - parseFloat(b.dataset.distance);
            } else {
                return a.dataset.name.localeCompare(b.dataset.name);
            }
        });
        
        container.innerHTML = '';
        items.forEach(item => container.appendChild(item));
        
        // Update badges
        document.querySelectorAll('.mosque-item').forEach((item, index) => {
            const badge = item.querySelector('.mosque-badge');
            if (badge) badge.textContent = `#${index + 1}`;
        });
        
        // Update active button
        document.querySelectorAll('.sort-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.sort === sortBy) {
                btn.classList.add('active');
            }
        });
    }
    
    // Toggle view
    function toggleView() {
        const listView = document.getElementById('listViewContainer');
        const mapView = document.getElementById('mapViewContainer');
        const listBtn = document.getElementById('listViewBtn');
        const mapBtn = document.getElementById('mapViewBtn');
        
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
    
    // Calculate Qibla direction
    function calculateQibla() {
        // Kaaba coordinates
        const kaabaLat = 21.4225;
        const kaabaLng = 39.8262;
        
        // Convert to radians
        const lat1 = deg2rad(cityLat);
        const lat2 = deg2rad(kaabaLat);
        const lngDiff = deg2rad(kaabaLng - cityLng);
        
        // Calculate qibla direction
        const x = Math.sin(lngDiff) * Math.cos(lat2);
        const y = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(lngDiff);
        let qibla = rad2deg(Math.atan2(x, y));
        
        // Normalize to 0-360
        qibla = (qibla + 360) % 360;
        
        document.getElementById('qiblaDirection').textContent = Math.round(qibla) + '°';
    }
    
    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
    
    function rad2deg(rad) {
        return rad * (180 / Math.PI);
    }
    
    // Document ready
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        toggleView();
        calculateQibla();
        
        // Sort buttons
        document.querySelectorAll('.sort-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                sortMosques(this.dataset.sort);
            });
        });
        
        // Update current year
        document.getElementById('currentYear').textContent = new Date().getFullYear();
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
    /* Base Styles from Original */
   

    .hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 40px 0;
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
        
        .city-links {
            flex-direction: column;
            gap: 6px;
        }
        
        .city-link-btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.5rem;
        }
        
        .hero {
            padding: 30px 0;
        }
        
        .current-time, .countdown-timer {
            font-size: 1.5rem;
        }
        
        .back-button {
            width: 100%;
            justify-content: center;
        }
    }

    /* Loading Animation */
    .fa-spinner {
        color: var(--primary-color);
    }
</style>

</body>
</html>