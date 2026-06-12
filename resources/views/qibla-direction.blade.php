
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>{{ $meta_title ?? "Qibla Direction for $city | NextPrayerTime - Accurate Qibla Direction" }}</title>
    <meta name="description" content="{{ $meta_description ?? "Find accurate Qibla direction for $city, $country. Face $qiblaDirection° towards the Holy Kaaba in Makkah. Interactive map and compass for Muslims in $city." }}">
    <meta name="keywords" content="{{ $meta_keywords ?? "Qibla Direction $city, Qibla finder $city, Qibla direction $country" }}">
    <meta name="robot" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #2a7f4e;
            --primary-dark: #1e5f3a;
            --primary-light: #4a9e6e;
            --bg-main: #f4f8f2;
            --bg-card: #ffffff;
            --text-primary: #1f2e2a;
            --text-secondary: #3a5248;
            --text-muted: #6b8a7a;
            --border: #e2eae0;
            --shadow-sm: 0 4px 14px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 8px 28px rgba(0, 0, 0, 0.08);
            --radius-lg: 1.5rem;
            --radius-md: 1rem;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-primary); line-height: 1.5; font-size: 15px; }
        .app-wrapper { display: flex; max-width: 1400px; margin: 0 auto; gap: 28px; padding: 0 24px; }
        .main-content { flex: 1; min-width: 0; }
        .right-sidebar { width: 320px; flex-shrink: 0; margin-top: 28px; position: sticky; top: 24px; height: fit-content; }

        .header { background: var(--bg-card); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.98); backdrop-filter: blur(8px); }
        .nav-bar { display: flex; justify-content: space-between; align-items: center; padding: 12px 24px; max-width: 1400px; margin: 0 auto; }
        .logo a { text-decoration: none; display: block; }
        .logo h1 { font-size: 1.3rem; font-weight: 700; letter-spacing: -0.3px; color: var(--text-primary); }
        .logo span { color: var(--primary); }
        .logo p { font-size: 0.65rem; color: var(--text-muted); }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; font-size: 0.8rem; font-weight: 500; color: var(--text-secondary); transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        .btn-outline-nav, .btn-primary-nav { padding: 5px 16px; border-radius: 40px; font-weight: 500; font-size: 0.8rem; }
        .btn-outline-nav { border: 1.5px solid var(--border); background: transparent; }
        .btn-primary-nav { background: var(--primary); color: white !important; }
        .mobile-menu-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: var(--primary); cursor: pointer; }

        .hero-card, .sidebar-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 24px;
            margin-bottom: 20px;
            border: 1px solid var(--border);
        }
        .hero-card { margin-top: 30px; }
        
        .qibla-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .qibla-header h2 { font-size: 1.2rem; }
        .direction-badge { background: #eef5ea; padding: 6px 16px; border-radius: 60px; font-weight: 700; font-size: 0.8rem; color: var(--primary); }
        
        .compass-container { text-align: center; margin: 20px 0; background: linear-gradient(145deg, #ffffff, #fafefa); border-radius: 40px; padding: 28px 20px; border: 1px solid var(--border); position: relative; }
        .compass-dial { width: 220px; height: 220px; margin: 0 auto; position: relative; background: radial-gradient(circle at 30% 30%, #fefefe, #f3f7ef); border-radius: 50%; box-shadow: 0 16px 32px rgba(0,0,0,0.08); border: 1px solid rgba(42,127,78,0.25); }
        .compass-needle { position: absolute; width: 5px; height: 82px; background: linear-gradient(180deg, #e67e22, #c0392b); left: 50%; bottom: 50%; transform-origin: 50% 100%; transform: translateX(-50%) rotate(0deg); transition: transform 0.08s cubic-bezier(0.2, 0.9, 0.4, 1.1); border-radius: 6px; z-index: 12; will-change: transform; }
        .compass-needle::after { content: "N"; position: absolute; top: -26px; left: -9px; font-size: 14px; font-weight: 800; color: #1e5f3a; background: white; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: 1px solid #d4e0d0; }
        .kaaba-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 48px; height: 48px; background: linear-gradient(145deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 14px rgba(30,95,58,0.35); z-index: 8; border: 3px solid white; }
        .kaaba-center i { font-size: 24px; color: white; }
        .compass-markers span { position: absolute; font-size: 11px; font-weight: 700; color: #2f5d48; background: rgba(255,255,245,0.8); padding: 2px 5px; border-radius: 20px; }
        .bearing-value { font-size: 1.8rem; font-weight: 800; background: #eef5ea; display: inline-block; padding: 8px 24px; border-radius: 80px; margin: 16px 0; color: var(--primary-dark); }
        .btn-primary-solid { background: var(--primary); border: none; padding: 10px 20px; border-radius: 60px; color: white; font-weight: 600; cursor: pointer; font-size: 0.8rem; transition: 0.15s; }
        .btn-primary-solid:hover { background: var(--primary-dark); }
        .map-container { border-radius: 16px; overflow: hidden; margin: 16px 0; border: 1px solid var(--border); height: 350px; position: relative; background: #e8f0e6; }
        #qiblaMap { height: 100%; width: 100%; background: #e8f0e6; z-index: 1; }
        .map-distance-overlay { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); padding: 8px 18px; border-radius: 40px; font-size: 0.75rem; font-weight: 500; color: white; z-index: 10; white-space: nowrap; pointer-events: none; }
        .city-grid { display: flex; flex-wrap: wrap; gap: 8px; margin: 16px 0; max-height: 300px; overflow-y: auto; }
        .city-chip { background: #eef5ea; padding: 5px 12px; border-radius: 40px; cursor: pointer; font-size: 0.7rem; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; transition: 0.1s; }
        .city-chip:hover { background: var(--primary); color: white; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); }
        .info-label { font-weight: 600; color: var(--text-secondary); font-size: 0.85rem; }
        .info-value { color: var(--text-primary); font-size: 0.85rem; }
        .pulse-marker { position: absolute; width: 40px; height: 40px; background: rgba(220,53,69,0.4); border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(0.5); opacity: 0.5; } 100% { transform: scale(2); opacity: 0; } }
        .footer { background: #112e1f; color: #d4e0d4; margin-top: 48px; padding: 32px 0 24px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 24px; max-width: 1400px; margin: 0 auto; padding: 0 24px; }
        .footer-col h4 { color: white; margin-bottom: 12px; font-size: 0.85rem; }
        .footer-col p, .footer-col a { font-size: 0.7rem; color: #c0d4c0; text-decoration: none; display: block; margin-bottom: 6px; transition: all 0.2s; }
        .footer-col a:hover { color: white; padding-left: 4px; }
        .social-icons { display: flex; gap: 14px; margin-top: 8px; }
        .mobile-bottom-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: rgba(255,255,255,0.96); backdrop-filter: blur(20px); border-top: 1px solid var(--border); padding: 8px 16px 10px; z-index: 200; justify-content: space-around; }
        .nav-icon { display: flex; flex-direction: column; align-items: center; gap: 2px; background: none; border: none; font-size: 1.3rem; color: var(--text-muted); cursor: pointer; padding: 4px 10px; border-radius: 40px; }
        .nav-icon span { font-size: 0.6rem; font-weight: 500; }
        .nav-icon.active { color: var(--primary); background: rgba(42,127,78,0.1); }
        .menu-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 104; opacity: 0; visibility: hidden; transition: 0.2s; }
        .menu-overlay.active { opacity: 1; visibility: visible; }
        .permission-modal { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 10000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .permission-modal.active { display: flex; }
        .permission-content { background: white; border-radius: 24px; padding: 30px; max-width: 400px; text-align: center; }
        .permission-icon { width: 80px; height: 80px; background: var(--bg-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2rem; color: var(--primary); }
        .permission-buttons { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
        .permission-btn { padding: 12px 25px; border-radius: 50px; font-weight: 500; cursor: pointer; border: none; }
        .permission-btn.primary { background: var(--primary); color: white; }
        
        @media (max-width: 1024px) { .app-wrapper { flex-direction: column; padding: 0 16px; } .right-sidebar { width: 100%; position: static; margin-top: 0; } }
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: block; }
            .nav-links { position: fixed; top: 0; left: -100%; width: 75%; max-width: 260px; height: 100vh; background: var(--bg-card); flex-direction: column; align-items: flex-start; padding: 70px 20px 30px; gap: 16px; z-index: 105; transition: left 0.3s; }
            .nav-links.open { left: 0; }
            .mobile-bottom-nav { display: flex; }
            body { padding-bottom: 70px; }
            .hero-card, .sidebar-card { padding: 16px; margin-bottom: 16px; }
            .hero-card { margin-top: 20px; }
            .compass-dial { width: 180px; height: 180px; }
            .compass-needle { height: 65px; }
            .bearing-value { font-size: 1.4rem; padding: 6px 16px; }
            .info-label, .info-value { font-size: 0.75rem; }
            .map-distance-overlay { font-size: 0.65rem; padding: 6px 12px; white-space: nowrap; }
        }
    </style>
</head>
<body>
<div class="header">
    <div class="nav-bar">
        <div class="logo"><a href="{{ url('/') }}"><h1>Next<span>PrayerTime</span></h1><p>Precision Salah Times & Islamic Tools</p></a></div>
        <div class="nav-links" id="navLinks">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/qibla-direction') }}" class="active">Qibla</a>
            <a href="{{ url('/ramadan-timing') }}">Ramadan</a>
            <a href="{{ url('/Tasbeeh-counter') }}">Tools</a>
            <a href="{{ url('/blogs') }}">Blog</a>
            <a href="{{ url('/user/login') }}" class="btn-outline-nav">Login</a>
            <a href="{{ url('/user/register') }}" class="btn-primary-nav">Register</a>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
    </div>
    <div id="menuOverlay" class="menu-overlay"></div>
</div>

<div class="app-wrapper">
    <div class="main-content">
        <div class="hero-card">
            <div class="qibla-header">
                <h2><i class="fas fa-kaaba"></i> Qibla Direction for <span id="cityNameTitle">{{ $city }}</span></h2>
                <div class="direction-badge" id="qiblaBadge"><i class="fas fa-location-arrow"></i> Bearing: {{ number_format($qiblaDirection, 2) }}°</div>
            </div>
            
            <div class="compass-container">
                <div class="compass-dial" id="compassDial">
                    <div class="kaaba-center"><i class="fas fa-cube"></i></div>
                    <div class="compass-needle" id="compassNeedle"></div>
                    <div class="compass-markers">
                        <span style="top: 8px; left: 50%; transform: translateX(-50%);">N</span>
                        <span style="bottom: 8px; left: 50%; transform: translateX(-50%);">S</span>
                        <span style="left: 8px; top: 50%; transform: translateY(-50%);">W</span>
                        <span style="right: 8px; top: 50%; transform: translateY(-50%);">E</span>
                    </div>
                </div>
                <div><span class="bearing-value" id="liveBearing">{{ number_format($qiblaDirection, 2) }}°</span></div>
                <div id="matchStatus" style="font-size:0.7rem; margin:8px 0; padding:6px 10px; background:#f0f5ed; border-radius:40px;"><i class="fas fa-info-circle"></i> Enable Live Compass</div>
                <button id="activateCompassBtn" class="btn-primary-solid"><i class="fas fa-sync-alt"></i> Enable Live Compass</button>
            </div>
            
            <div class="info-row"><div class="info-label">Qibla:</div><div class="info-value" id="qiblaDisplay">{{ number_format($qiblaDirection, 2) }}° for {{ $city }}</div></div>
            <div class="info-row"><div class="info-label">Face:</div><div class="info-value" id="faceDirection">{{ number_format($qiblaDirection, 2) }}° from North in {{ $city }}</div></div>
            <div class="info-row"><div class="info-label">True North:</div><div class="info-value">0°</div></div>
            <div class="info-row"><div class="info-label">Kaaba Direction:</div><div class="info-value" id="kaabaDirection">{{ number_format($qiblaDirection, 2) }}°</div></div>
        </div>
        
        <div class="hero-card">
            <h3><i class="fas fa-map-marked-alt"></i> See Your Path to Kaaba from {{ $city }}</h3>
            <div class="map-container">
                <div id="qiblaMap"></div>
                <div id="mapDistanceOverlay" class="map-distance-overlay"><i class="fas fa-route me-1"></i> Calculating distance...</div>
            </div>
            <div class="info-row"><div class="info-label">Distance:</div><div class="info-value" id="distanceValue">0 km (0 miles)</div></div>
            <div class="info-row"><div class="info-label">Path:</div><div class="info-value">The curved line shows the great circle path (shortest distance)</div></div>
        </div>
        
        <div class="hero-card" id="mainDescriptionContainer">
            <h3><i class="fas fa-info-circle"></i> About Qibla Direction in {{ $city }}, {{ $country }}</h3>
            @if(isset($main_description) && $main_description)
                {!! $main_description !!}
            @else
                <p>The Qibla direction for <strong>{{ $city }}, {{ $country }}</strong> is approximately <strong>{{ number_format($qiblaDirection, 2) }}°</strong> degrees from True North towards the Holy Kaaba in Mecca, Saudi Arabia. This direction is calculated using precise geographic coordinates (latitude: {{ number_format($latitude, 2) }}°, longitude: {{ number_format($longitude, 2) }}°) and spherical trigonometry formulas, ensuring maximum accuracy for Muslims in {{ $city }}.</p>
                
                <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
                    <div style="flex: 1; min-width: 200px;">
                        <h4><i class="fas fa-compass" style="color:var(--primary); margin-right: 8px;"></i> How to Find Qibla in {{ $city }}</h4>
                        <p>Muslims in {{ $city }} can determine the Qibla direction using several reliable methods:</p>
                        <ul style="margin-left: 20px; margin-top: 8px;">
                            <li><strong>Digital Compass:</strong> The compass above is automatically set to <strong>{{ number_format($qiblaDirection, 2) }}°</strong> for {{ $city }}. Click "Enable Live Compass" to see real-time direction.</li>
                            <li><strong>Smartphone Apps:</strong> Many Islamic apps have built-in qibla finders with GPS</li>
                            <li><strong>Local Mosques:</strong> Mosques in {{ $city }} are constructed facing the correct qibla direction</li>
                            <li><strong>Sun Position:</strong> At solar noon, the sun's shadow can indicate direction</li>
                        </ul>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <h4><i class="fas fa-mosque" style="color:var(--primary); margin-right: 8px;"></i> Islamic Significance</h4>
                        <p>The qibla direction unites Muslims worldwide, including those in {{ $city }}, in facing the same point during prayer. This practice symbolizes the unity of the Muslim ummah and their devotion to Allah. The Kaaba in Mecca serves as this central point, making it crucial for {{ $city }} residents to face the correct direction during salah.</p>
                    </div>
                </div>
                
                <h4 style="margin-top: 20px;"><i class="fas fa-clock" style="color:var(--primary); margin-right: 8px;"></i> Prayer Times in {{ $city }}</h4>
                <p>Knowing the correct prayer times is essential for Muslims in {{ $city }}. The five daily prayers - Fajr, Dhuhr, Asr, Maghrib, and Isha - follow the sun's position throughout the day. In {{ $city }}, prayer times vary throughout the year due to changing daylight hours. Stay connected with your local {{ $city }} mosque or Islamic center for accurate prayer schedules.</p>
                
                <div style="background: #eef5ea; border-radius: 20px; padding: 20px; margin-top: 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                    <div style="display: inline-block; width: 48px; height: 48px; background: white; border-radius: 50%; border: 3px solid #212529; color: var(--primary); font-size: 1.5rem; line-height: 42px; text-align: center; flex-shrink: 0;"><i class="fas fa-kaaba"></i></div>
                    <div style="flex: 1;">
                        <h4 class="h5 mb-1" style="font-size: 1rem;">Pro Tip for {{ $city }} Residents</h4>
                        <p class="mb-0" style="font-size: 0.85rem;">The compass above is automatically calibrated to <strong>{{ number_format($qiblaDirection, 2) }}°</strong> for {{ $city }}. On your mobile, enable the live compass and rotate your phone until the Kaaba icon points straight up - that's the exact Qibla direction!</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="hero-card">
            <h3><i class="fas fa-city"></i> More Cities in {{ $country }}</h3>
            <div class="city-grid" id="moreCitiesList">
                @if(isset($citiesInCountry) && count($citiesInCountry) > 0)
                    @foreach($citiesInCountry as $cityItem)
                        <span class="city-chip" data-city="{{ $cityItem->city }}" data-lat="{{ $cityItem->latitude }}" data-lon="{{ $cityItem->longitude }}">
                            <i class="fas fa-city"></i> {{ $cityItem->city }}
                            <span style="margin-left:5px; font-size:0.65rem;">{{ number_format($cityItem->qibla_direction, 2) }}°</span>
                        </span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    
    <div class="right-sidebar">
        <div class="sidebar-card">
            <h3><i class="fas fa-map-marker-alt"></i> Your Location</h3>
            <div class="info-row"><div class="info-label">City:</div><div class="info-value" id="sidebarCity">{{ $city }}</div></div>
            <div class="info-row"><div class="info-label">State/Region:</div><div class="info-value" id="sidebarRegion">{{ $state ?? $city }}</div></div>
            <div class="info-row"><div class="info-label">Country:</div><div class="info-value" id="sidebarCountry">{{ $country }}</div></div>
            <div class="info-row"><div class="info-label">Coordinates:</div><div class="info-value" id="sidebarCoords">{{ number_format($latitude, 2) }}°, {{ number_format($longitude, 2) }}°</div></div>
            <div class="info-row"><div class="info-label">Distance to Kaaba:</div><div class="info-value" id="sidebarDistance">0 km</div></div>
        </div>
        
        <div class="sidebar-card">
            <h3><i class="fas fa-compass"></i> Qibla Direction for {{ $city }}</h3>
            <div class="info-row"><div class="info-label">Qibla:</div><div class="info-value" id="sidebarQibla">{{ number_format($qiblaDirection, 2) }}°</div></div>
            <div class="info-row"><div class="info-label">NESW:</div><div class="info-value" id="sidebarNESW">--</div></div>
        </div>
        
        <div class="sidebar-card">
            <h3><i class="fas fa-mosque"></i> Prayer Times</h3>
            <p>Complete Salah schedule for your city</p>
            <button id="goToPrayerBtn" class="btn-primary-solid" style="margin-top:10px; width:100%;">Go to Prayer Times</button>
        </div>
    </div>
</div>

<div class="mobile-bottom-nav">
    <button class="nav-icon" data-nav="home"><i class="fas fa-home"></i><span>Home</span></button>
    <button class="nav-icon active" data-nav="qibla"><i class="fas fa-compass"></i><span>Qibla</span></button>
    <button class="nav-icon" data-nav="zakat"><i class="fas fa-coins"></i><span>Zakat</span></button>
    <button class="nav-icon" data-nav="search"><i class="fas fa-search"></i><span>Search</span></button>
</div>

<div class="permission-modal" id="permissionModal">
    <div class="permission-content">
        <div class="permission-icon"><i class="fas fa-kaaba"></i></div>
        <h3>Enable Live Compass</h3>
        <p>To see the Kaaba icon point in real-time as you move your device, we need access to your device's orientation sensors.</p>
        <div class="permission-buttons">
            <button class="permission-btn primary" id="allowCompass">Allow Access</button>
            <button class="permission-btn secondary" id="declineCompass">Not Now</button>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-grid">
        <div class="footer-col"><h4>NextPrayerTime</h4><p>Accurate prayer times since 2023</p><div class="social-icons"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
        <div class="footer-col"><h4>Quick Links</h4><a href="{{ url('/') }}">Home</a><a href="{{ url('/aboutus') }}">About</a><a href="{{ url('/blogs') }}">Blog</a></div>
        <div class="footer-col"><h4>Islamic Tools</h4><a href="{{ url('/islamic-calendar') }}">Hijri Calendar</a><a href="{{ url('/ramadan-timing') }}">Ramadan Timings</a><a href="{{ url('/qibla-direction') }}">Qibla Finder</a></div>
        <div class="footer-col"><h4>Resources</h4><a href="{{ url('/mosque-near-me') }}">Mosque Near Me</a><a href="{{ url('/developers') }}">Developers API</a></div>
    </div>
    <hr style="margin:24px 24px 12px; border-color:#2c4b38;">
    <div style="text-align:center; font-size:0.65rem;">© {{ date('Y') }} NextPrayerTimes – Qibla Direction Finder</div>
</footer>

<script>
    // Pass PHP variables to JavaScript
    const cityLat = {{ $latitude }};
    const cityLon = {{ $longitude }};
    const qiblaDirection = {{ $qiblaDirection }};
    const cityName = "{{ $city }}";
    const countryName = "{{ $country }}";
    const KAABA_LAT = 21.4225;
    const KAABA_LON = 39.8262;
    
    let map = null;
    let userMarker = null;
    let qiblaLine = null;
    let kaabaMarker = null;
    let deviceOrientationActive = false;
    let currentAlpha = 0;
    let animationId = null;
    let targetRotation = 0;
    let currentRotation = 0;
    let currentBearing = qiblaDirection;
    
    function calculateDistance(lat1, lon1) {
        const R = 6371;
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = KAABA_LAT * Math.PI / 180;
        const Δφ = (KAABA_LAT - lat1) * Math.PI / 180;
        const Δλ = (KAABA_LON - lon1) * Math.PI / 180;
        const a = Math.sin(Δφ/2)**2 + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2)**2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
    
    function getCardinalDirection(bearing) {
        const directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
        const index = Math.round(bearing / 22.5) % 16;
        return directions[index];
    }
    
    function updatePageData() {
        const distance = calculateDistance(cityLat, cityLon);
        const miles = (distance * 0.621371).toFixed(0);
        document.getElementById("distanceValue").innerHTML = `${distance.toFixed(0)} km (${miles} miles)`;
        document.getElementById("sidebarDistance").innerHTML = distance.toFixed(0) + " km";
        document.getElementById("mapDistanceOverlay").innerHTML = `<i class="fas fa-route me-1"></i> Distance: ${distance.toFixed(0)} km (${miles} miles)`;
        document.getElementById("sidebarNESW").innerHTML = getCardinalDirection(qiblaDirection);
        
        const compassRotation = 360 - qiblaDirection;
        document.getElementById("compassNeedle").style.transform = `translateX(-50%) rotate(${compassRotation}deg)`;
        
        updateMap();
        setupCityChips();
    }
    
    function updateMap() {
        if(map && window.mapInitialized) {
            if(userMarker) map.removeLayer(userMarker);
            const userIcon = L.divIcon({
                html: `<div style="position: relative;"><i class="fas fa-map-marker-alt" style="color: #dc3545; font-size: 32px;"></i><div class="pulse-marker" style="position: absolute; top: -4px; left: -4px;"></div></div>`,
                iconSize: [32, 32],
                className: 'user-marker'
            });
            userMarker = L.marker([cityLat, cityLon], { icon: userIcon }).addTo(map).bindPopup(`<b>${cityName}</b><br>Qibla: ${qiblaDirection.toFixed(2)}°`).openPopup();
            
            if(qiblaLine) map.removeLayer(qiblaLine);
            const points = [];
            for(let i = 0; i <= 40; i++) {
                const f = i / 40;
                const φ1 = cityLat * Math.PI/180, λ1 = cityLon * Math.PI/180;
                const φ2 = KAABA_LAT * Math.PI/180, λ2 = KAABA_LON * Math.PI/180;
                const Δλ = λ2 - λ1;
                const a = Math.sin((φ2-φ1)/2)**2 + Math.cos(φ1)*Math.cos(φ2)*Math.sin(Δλ/2)**2;
                let δ = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                const A = Math.sin((1-f)*δ) / Math.sin(δ);
                const B = Math.sin(f*δ) / Math.sin(δ);
                const x = A * Math.cos(φ1) * Math.cos(λ1) + B * Math.cos(φ2) * Math.cos(λ2);
                const y = A * Math.cos(φ1) * Math.sin(λ1) + B * Math.cos(φ2) * Math.sin(λ2);
                const z = A * Math.sin(φ1) + B * Math.sin(φ2);
                points.push([Math.atan2(z, Math.sqrt(x*x+y*y)) * 180/Math.PI, Math.atan2(y, x) * 180/Math.PI]);
            }
            qiblaLine = L.polyline(points, { color: '#2a7f4e', weight: 3, dashArray: '6, 6' }).addTo(map);
            
            if(!kaabaMarker) {
                const kaabaIcon = L.divIcon({
                    html: '<div style="background: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 20px; border: 3px solid #212529; box-shadow: 0 4px 10px rgba(0,0,0,0.3);"><i class="fas fa-kaaba"></i></div>',
                    iconSize: [40, 40]
                });
                kaabaMarker = L.marker([KAABA_LAT, KAABA_LON], { icon: kaabaIcon }).addTo(map).bindPopup('Holy Kaaba');
            }
            map.fitBounds([[cityLat, cityLon], [KAABA_LAT, KAABA_LON]], { padding: [40,40] });
        }
    }
    
    function initMap() {
        if(map) map.remove();
        map = L.map('qiblaMap').setView([cityLat, cityLon], 6);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { attribution: '© OpenStreetMap' }).addTo(map);
        window.mapInitialized = true;
        updateMap();
    }
    
    function setupCityChips() {
        const chips = document.querySelectorAll('.city-chip');
        chips.forEach(chip => {
            chip.addEventListener('click', function() {
                const city = this.getAttribute('data-city');
                const lat = this.getAttribute('data-lat');
                const lon = this.getAttribute('data-lon');
                if(city && lat && lon) {
                    window.location.href = `/${city.toLowerCase().replace(/ /g, '-')}-qibla-direction?city=${encodeURIComponent(city)}&lat=${lat}&lon=${lon}`;
                } else {
                    const cityName = this.innerText.split('°')[0].trim();
                    window.location.href = `/${cityName.toLowerCase().replace(/ /g, '-')}-qibla-direction`;
                }
            });
        });
    }
    
    function animateCompass() {
        if(deviceOrientationActive) {
            const diff = targetRotation - currentRotation;
            currentRotation += diff * 0.15;
            let relativeAngle = (currentBearing - currentRotation + 360) % 360;
            const needle = document.getElementById("compassNeedle");
            const matchStatus = document.getElementById("matchStatus");
            if(needle) {
                needle.style.transform = `translateX(-50%) rotate(${relativeAngle}deg)`;
                const deviation = Math.min(relativeAngle, 360 - relativeAngle);
                if(deviation <= 5) {
                    needle.style.background = "linear-gradient(180deg, #2ecc71, #27ae60)";
                    if(matchStatus) matchStatus.innerHTML = '<i class="fas fa-check-circle" style="color:#2ecc71;"></i> You are facing the Qibla!';
                } else {
                    needle.style.background = "linear-gradient(180deg, #e67e22, #c0392b)";
                    if(matchStatus) matchStatus.innerHTML = `<i class="fas fa-compass"></i> Turn ${deviation.toFixed(0)}° ${relativeAngle < 180 ? "left" : "right"} to face Qibla`;
                }
            }
        }
        animationId = requestAnimationFrame(animateCompass);
    }
    
    function handleOrientation(e) {
        if(e.alpha !== null) {
            let alpha = e.alpha;
            if(e.webkitCompassHeading !== undefined) alpha = e.webkitCompassHeading;
            if(window.orientation === 90) alpha += 90;
            else if(window.orientation === -90) alpha -= 90;
            targetRotation = alpha % 360;
            currentAlpha = alpha;
            if(!deviceOrientationActive) deviceOrientationActive = true;
        }
    }
    
    function enableLiveCompass() {
        if(typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
            DeviceOrientationEvent.requestPermission().then(response => {
                if(response === 'granted') {
                    window.addEventListener('deviceorientation', handleOrientation);
                    deviceOrientationActive = true;
                    document.getElementById("matchStatus").innerHTML = '<i class="fas fa-check"></i> Compass active. Rotate phone to face Qibla.';
                    document.getElementById("permissionModal").classList.remove('active');
                } else alert("Permission needed for compass");
            }).catch(console.error);
        } else {
            window.addEventListener('deviceorientation', handleOrientation);
            deviceOrientationActive = true;
            document.getElementById("matchStatus").innerHTML = '<i class="fas fa-check"></i> Compass active.';
        }
    }
    
    document.getElementById("activateCompassBtn").addEventListener("click", () => {
        if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
            document.getElementById("permissionModal").classList.add('active');
        } else {
            enableLiveCompass();
        }
    });
    document.getElementById("allowCompass").addEventListener("click", enableLiveCompass);
    document.getElementById("declineCompass").addEventListener("click", () => {
        document.getElementById("permissionModal").classList.remove('active');
    });
    document.getElementById("permissionModal").addEventListener("click", (e) => {
        if(e.target === document.getElementById("permissionModal")) {
            document.getElementById("permissionModal").classList.remove('active');
        }
    });
    
    document.getElementById("goToPrayerBtn")?.addEventListener("click", () => { window.location.href = "/prayer-times"; });
    
    document.querySelectorAll(".nav-icon").forEach(btn => {
        btn.addEventListener("click", () => {
            const type = btn.dataset.nav;
            if(type === "home") window.location.href = "/";
            else if(type === "qibla") window.location.href = "/qibla-direction";
            else if(type === "zakat") window.location.href = "/Zakat-Calculator";
            else if(type === "search") alert("Search feature");
        });
    });
    
    const mobileToggle = document.getElementById("mobileMenuToggle");
    const navLinks = document.getElementById("navLinks");
    const overlayMenu = document.getElementById("menuOverlay");
    mobileToggle.onclick = () => { navLinks.classList.toggle("open"); overlayMenu.classList.toggle("active"); mobileToggle.innerHTML = navLinks.classList.contains("open") ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>'; };
    overlayMenu.onclick = () => { navLinks.classList.remove("open"); overlayMenu.classList.remove("active"); mobileToggle.innerHTML = '<i class="fas fa-bars"></i>'; };
    
    initMap();
    updatePageData();
    animateCompass();
    
    window.addEventListener('beforeunload', () => { if(animationId) cancelAnimationFrame(animationId); });
</script>
</body>
</html>
