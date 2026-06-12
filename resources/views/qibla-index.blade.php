
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Find Qibla Direction for your Location | NextPrayerTime - Accurate Qibla Direction</title>
    <meta name="description" content="Discover the accurate direction to the Holy Kaaba in Mecca from any location worldwide with our Islamic compass. Find Qibla direction from your current location using our precise compass.">
    <meta name="keywords" content="Qibla Direction,qibla finder,qibla finder online,Qibla direction finder,Islamic compass">
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
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-primary); line-height: 1.4; scroll-behavior: smooth; }
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
            position: relative;
        }
        .hero-card { margin-top: 30px; }
        
        .qibla-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .qibla-header h2 { font-size: 1.2rem; }
        .direction-badge { background: #eef5ea; padding: 6px 16px; border-radius: 60px; font-weight: 700; font-size: 0.85rem; color: var(--primary); }
        
        .current-city-badge { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 6px 16px; border-radius: 60px; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; }
        .current-city-badge i { font-size: 0.8rem; }
        
        .search-wrapper { display: flex; gap: 10px; margin-bottom: 20px; }
        .search-input-field { flex: 1; position: relative; }
        .search-input-field input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 60px; font-size: 0.85rem; background: white; outline: none; }
        .search-input-field input:focus { border-color: var(--primary); }
        .search-btn { background: var(--primary); border: none; padding: 0 20px; border-radius: 60px; color: white; font-weight: 600; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 6px; }
        .suggestions-list { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border); border-radius: 16px; max-height: 240px; overflow-y: auto; z-index: 50; margin-top: 6px; box-shadow: var(--shadow-md); display: none; }
        .suggestion-item { padding: 10px 16px; cursor: pointer; border-bottom: 1px solid #f0f0f0; font-size: 0.8rem; }
        .suggestion-item:hover { background: var(--bg-main); color: var(--primary); }
        
        .city-info-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border); }
        
        .compass-container {
            text-align: center;
            margin: 20px 0;
            background: linear-gradient(145deg, #ffffff, #fafefa);
            border-radius: 40px;
            padding: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }
        .camera-view {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 40px;
            z-index: 0;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .camera-view.active {
            opacity: 0.45;
        }
        .compass-dial {
            width: 260px;
            height: 260px;
            margin: 0 auto;
            position: relative;
            background: radial-gradient(circle at 30% 30%, rgba(254,254,254,0.9), rgba(243,247,239,0.9));
            border-radius: 50%;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08), inset 0 1px 2px rgba(255,255,255,0.8);
            border: 1px solid rgba(42,127,78,0.25);
            z-index: 2;
            backdrop-filter: blur(2px);
        }
        .compass-inner {
            position: absolute;
            top: 12px;
            left: 12px;
            width: calc(100% - 24px);
            height: calc(100% - 24px);
            background: rgba(255, 255, 245, 0.6);
            border-radius: 50%;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.02), 0 0 0 2px rgba(42,127,78,0.1);
        }
        .kaaba-icon-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 14px rgba(30, 95, 58, 0.35);
            z-index: 8;
            border: 3px solid white;
            backdrop-filter: blur(2px);
        }
        .kaaba-icon-center i {
            font-size: 28px;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .kaaba-icon-center::after {
            content: "MAKKAH";
            position: absolute;
            bottom: -28px;
            font-size: 10px;
            font-weight: 700;
            color: var(--primary-dark);
            white-space: nowrap;
            background: rgba(255,255,240,0.9);
            padding: 2px 8px;
            border-radius: 60px;
            letter-spacing: 0.5px;
            backdrop-filter: blur(2px);
        }
        .compass-needle {
            position: absolute;
            width: 5px;
            height: 98px;
            background: linear-gradient(180deg, #e67e22, #c0392b);
            left: 50%;
            bottom: 50%;
            transform-origin: 50% 100%;
            transform: translateX(-50%) rotate(0deg);
            transition: transform 0.08s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border-radius: 6px;
            z-index: 12;
            box-shadow: 0 0 0 1px rgba(255,255,200,0.4);
            will-change: transform;
        }
        .compass-needle::after {
            content: "N";
            position: absolute;
            top: -28px;
            left: -9px;
            font-size: 15px;
            font-weight: 800;
            color: #1e5f3a;
            background: white;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid #d4e0d0;
        }
        .compass-needle::before {
            content: "S";
            position: absolute;
            bottom: -28px;
            left: -7px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            background: rgba(255,255,245,0.8);
            padding: 3px 6px;
            border-radius: 20px;
            backdrop-filter: blur(2px);
        }
        .compass-markers span {
            position: absolute;
            font-size: 12px;
            font-weight: 700;
            color: #2f5d48;
            background: rgba(255, 255, 245, 0.8);
            padding: 2px 5px;
            border-radius: 24px;
            backdrop-filter: blur(2px);
            letter-spacing: 0.5px;
        }
        .bearing-value {
            font-size: 1.9rem;
            font-weight: 800;
            font-family: 'Inter', monospace;
            background: #eef5ea;
            display: inline-block;
            padding: 8px 28px;
            border-radius: 80px;
            margin: 16px 0 8px;
            letter-spacing: 1px;
            color: var(--primary-dark);
            box-shadow: inset 0 0 0 1px rgba(42,127,78,0.2), 0 2px 4px rgba(0,0,0,0.02);
            position: relative;
            z-index: 2;
        }
        .location-status { background: #eef5ea; border-radius: 40px; padding: 10px 16px; text-align: center; font-size: 0.75rem; margin: 12px 0; font-weight: 500; }
        .btn-primary-solid { background: var(--primary); border: none; padding: 10px 20px; border-radius: 60px; color: white; font-weight: 600; cursor: pointer; font-size: 0.8rem; margin-top: 6px; transition: 0.15s; }
        .btn-primary-solid:hover { background: var(--primary-dark); transform: scale(0.98); }
        .compass-actions { display: flex; gap: 12px; margin-top: 16px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 2; }
        .compass-actions button { margin: 0; flex: 1; min-width: 140px; }
        
        .map-container { border-radius: 16px; overflow: hidden; margin: 16px 0; border: 1px solid var(--border); height: 320px; }
        #qiblaMap { height: 100%; width: 100%; background: #e8f0e6; }
        
        .city-grid { display: flex; flex-wrap: wrap; gap: 8px; margin: 16px 0; }
        .city-chip { background: #eef5ea; padding: 6px 14px; border-radius: 40px; cursor: pointer; font-size: 0.75rem; font-weight: 500; display: inline-flex; align-items: center; gap: 5px; transition: 0.1s; }
        .city-chip:hover, .city-chip.active-city { background: var(--primary); color: white; }
        
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-top: 16px; }
        .feature-item { text-align: center; padding: 16px 12px; background: #f9fdf8; border-radius: 20px; transition: all 0.2s; border: 1px solid var(--border); cursor: pointer; }
        .feature-item i { font-size: 1.8rem; color: var(--primary); margin-bottom: 12px; }
        .feature-item h4 { font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; color: var(--text-primary); }
        .feature-item p { font-size: 0.7rem; color: var(--text-muted); line-height: 1.3; }
        .feature-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-sm); border-color: var(--primary-light); }
        
        .city-link { padding: 10px 0; border-bottom: 1px solid var(--border); cursor: pointer; font-size: 0.8rem; font-weight: 500; }
        .city-link:hover { color: var(--primary); padding-left: 6px; }
        
        .sidebar-card h3 { font-size: 0.9rem; margin-bottom: 12px; color: var(--primary-dark); }
        .sidebar-card p, .sidebar-card div { font-size: 0.8rem; line-height: 1.4; }
        #locationDetails { font-size: 0.8rem; line-height: 1.5; margin-top: 8px; }
        #displayCityNameSidebar { font-weight: 700; color: var(--primary); font-size: 0.9rem; margin-top: 6px; padding: 8px; background: #eef5ea; border-radius: 12px; text-align: center; }
        
        .popular-city-card {
            background: #f9fdf8;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .popular-city-card:hover { background: var(--primary); color: white; border-color: var(--primary); transform: translateX(4px); }
        .popular-city-card i { margin-right: 10px; color: var(--primary); }
        .popular-city-card:hover i { color: white; }
        
        .footer { background: #112e1f; color: #d4e0d4; margin-top: 48px; padding: 32px 0 24px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 24px; max-width: 1400px; margin: 0 auto; padding: 0 24px; }
        .footer-col h4 { color: white; margin-bottom: 12px; font-size: 0.85rem; }
        .footer-col p, .footer-col a { font-size: 0.7rem; color: #c0d4c0; text-decoration: none; display: block; margin-bottom: 6px; transition: all 0.2s; }
        .footer-col a:hover { color: white; padding-left: 4px; }
        .social-icons { display: flex; gap: 14px; margin-top: 8px; }
        .social-icons a { display: inline-block; margin-bottom: 0; }
        .social-icons a:hover { padding-left: 0; color: var(--primary-light); }
        
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border);
            padding: 8px 16px 10px;
            z-index: 200;
            justify-content: space-around;
        }
        .nav-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 40px;
        }
        .nav-icon span { font-size: 0.6rem; font-weight: 500; }
        .nav-icon.active { color: var(--primary); background: rgba(42,127,78,0.1); }
        
        .mobile-search-modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(12px);
            z-index: 300;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-container {
            background: var(--bg-card);
            border-radius: 32px;
            width: 90%;
            max-width: 400px;
            padding: 24px;
            animation: fadeInScale 0.2s ease;
        }
        @keyframes fadeInScale { from { opacity:0; transform:scale(0.95); } to { opacity:1; transform:scale(1); } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h3 { font-size: 1.2rem; color: var(--primary); }
        .close-modal-btn { background: #eee; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 1.2rem; cursor: pointer; }
        .mobile-search-input-wrapper { position: relative; margin-bottom: 20px; }
        .mobile-search-input-wrapper input { width: 100%; padding: 14px 20px 14px 48px; border: 1.5px solid var(--border); border-radius: 60px; font-size: 1rem; }
        .mobile-search-input-wrapper i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .modal-buttons { display: flex; flex-direction: column; gap: 12px; }
        .modal-buttons button { padding: 12px; font-size: 0.9rem; }
        
        .menu-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 104; opacity: 0; visibility: hidden; transition: 0.2s; }
        .menu-overlay.active { opacity: 1; visibility: visible; }
        
        @media (max-width: 1024px) { .app-wrapper { flex-direction: column; padding: 0 16px; } .right-sidebar { width: 100%; position: static; margin-top: 0; } }
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: block; }
            .nav-links { position: fixed; top: 0; left: -100%; width: 75%; max-width: 260px; height: 100vh; background: var(--bg-card); flex-direction: column; align-items: flex-start; padding: 70px 20px 30px; gap: 16px; z-index: 105; transition: left 0.3s; }
            .nav-links.open { left: 0; }
            .mobile-bottom-nav { display: flex; }
            body { padding-bottom: 70px; }
            .hero-card, .sidebar-card { padding: 16px; margin-bottom: 12px; }
            .hero-card { margin-top: 16px; }
            .compass-dial { width: 180px; height: 180px; }
            .compass-needle { height: 65px; width: 4px; }
            .compass-needle::after { width: 20px; height: 20px; font-size: 11px; top: -24px; left: -7px; }
            .compass-needle::before { font-size: 9px; bottom: -24px; left: -6px; }
            .kaaba-icon-center { width: 42px; height: 42px; }
            .kaaba-icon-center i { font-size: 20px; }
            .kaaba-icon-center::after { font-size: 8px; bottom: -22px; }
            .bearing-value { font-size: 1.3rem; padding: 5px 16px; margin: 12px 0 5px; }
            .compass-markers span { font-size: 9px; padding: 1px 3px; }
            .compass-container { padding: 20px 12px; margin: 12px 0; }
        }
    </style>
</head>
<body>
<div class="header">
    <div class="nav-bar">
        <div class="logo"><a href="/"><h1>Next<span>PrayerTime</span></h1><p>Precision Salah Times & Islamic Tools</p></a></div>
        <div class="nav-links" id="navLinks"><a href="/">Home</a><a href="/qibla-direction" class="active">Qibla</a><a href="/ramadan-timing">Ramadan</a><a href="/Tasbeeh-counter">Tools</a><a href="/blogs">Blog</a><a href="/user/login" class="btn-outline-nav">Login</a><a href="/user/register" class="btn-primary-nav">Register</a></div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
    </div>
    <div id="menuOverlay" class="menu-overlay"></div>
</div>

<div class="app-wrapper">
    <div class="main-content">
        <div class="hero-card">
            <div class="qibla-header"><h2><i class="fas fa-kaaba"></i> Find Qibla Direction</h2><div class="direction-badge" id="qiblaBadge"><i class="fas fa-location-arrow"></i> Bearing: --°</div></div>
            <div class="search-wrapper"><div class="search-input-field"><input type="text" id="citySearchInput" placeholder="Search city... London, Dubai, Karachi"><div id="searchSuggestions" class="suggestions-list"></div></div><button id="searchCityBtn" class="search-btn"><i class="fas fa-search"></i> Find</button></div>
            <div class="city-info-row"><div class="current-city-badge"><i class="fas fa-map-marker-alt"></i> <span id="currentCityDisplay">--</span></div><div class="direction-badge"><i class="fas fa-globe"></i> <span id="distanceDisplay">--</span> km</div></div>
            
            <div class="compass-container" id="compassContainer">
                <video id="cameraVideo" class="camera-view" autoplay playsinline muted></video>
                <div class="compass-dial" id="compassDial">
                    <div class="compass-inner"></div>
                    <div class="kaaba-icon-center"><i class="fas fa-cube"></i></div>
                    <div class="compass-needle" id="compassNeedle"></div>
                    <div class="compass-markers"><span style="top:8px;left:50%;transform:translateX(-50%);">N</span><span style="bottom:8px;left:50%;transform:translateX(-50%);">S</span><span style="left:8px;top:50%;transform:translateY(-50%);">W</span><span style="right:8px;top:50%;transform:translateY(-50%);">E</span><span style="top:27%;left:50%;transform:translateX(-50%);font-size:8px;">NE</span><span style="bottom:27%;left:50%;transform:translateX(-50%);font-size:8px;">SW</span><span style="left:27%;top:50%;transform:translateY(-50%);font-size:8px;">NW</span><span style="right:27%;top:50%;transform:translateY(-50%);font-size:8px;">SE</span></div>
                </div>
                <div><span class="bearing-value" id="liveBearing">---°</span></div>
                <div id="matchStatus" style="font-size:0.7rem;margin:8px 0;font-weight:500;padding:6px 10px;background:#f0f5ed;border-radius:40px;position:relative;z-index:2;"><i class="fas fa-info-circle"></i> Click Live Compass to start</div>
                <div class="compass-actions"><button id="activateCompassBtn" class="btn-primary-solid"><i class="fas fa-sync-alt"></i> Live Compass</button><button id="getMyLocationBtn" class="btn-primary-solid"><i class="fas fa-crosshairs"></i> My Location</button></div>
            </div>
            <div class="location-status" id="locationMsg"><i class="fas fa-map-marker-alt"></i> Detecting your location...</div>
        </div>
        
        <div class="hero-card"><h3><i class="fas fa-map-marked-alt"></i> Interactive Map</h3><div class="map-container"><div id="qiblaMap"></div></div><div class="city-grid" id="cityList"></div></div>
        <div class="hero-card"><h3 style="font-size:1rem;margin-bottom:12px;"><i class="fas fa-star-of-life" style="color:var(--primary);"></i> Our Features</h3><div class="feature-grid"><div class="feature-item"><i class="fas fa-compass"></i><h4>Accurate Qibla</h4><p>Find the exact Qibla direction from your current location using our precise Islamic compass.</p></div><div class="feature-item"><i class="fas fa-map-marked-alt"></i><h4>Interactive Map</h4><p>Visualize your location and the direction to Kaaba on our beautiful interactive map.</p></div><div class="feature-item"><i class="fas fa-globe-asia"></i><h4>Worldwide Coverage</h4><p>Find Qibla direction from any city in the world with our comprehensive database.</p></div></div></div>
    </div>
    
    <div class="right-sidebar">
        <div class="sidebar-card"><h3><i class="fas fa-user-alt"></i> Your Location</h3><div id="displayCityNameSidebar"><i class="fas fa-city"></i> <strong id="sidebarCityName">Detecting...</strong></div><div id="locationDetails">Latitude: --<br>Longitude: --</div><div id="distanceSidebar" style="margin-top:10px;"><i class="fas fa-kaaba"></i> Distance: -- km</div></div>
        <div class="sidebar-card"><h3><i class="fas fa-compass"></i> Qibla Info</h3><p>Direction to Makkah: <strong id="qiblaSideDir">---°</strong></p><p style="font-size:0.65rem;color:var(--text-muted);margin-top:6px;">Needle turns green when pointing to Qibla</p></div>
        <div class="sidebar-card" id="popularCitiesCard"><h3><i class="fas fa-globe"></i> Popular Cities</h3><div id="dynamicCityList"></div></div>
        <div class="sidebar-card"><h3><i class="fas fa-mosque"></i> Prayer Times</h3><p>Complete Salah schedule for your city</p><button id="goToPrayerBtn" class="btn-primary-solid" style="margin-top:0;">Go to Prayer Times</button></div>
    </div>
</div>

<div class="mobile-bottom-nav"><button class="nav-icon" data-nav="home"><i class="fas fa-home"></i><span>Home</span></button><button class="nav-icon active" data-nav="qibla"><i class="fas fa-compass"></i><span>Qibla</span></button><button class="nav-icon" data-nav="zakat"><i class="fas fa-coins"></i><span>Zakat</span></button><button class="nav-icon" data-nav="search"><i class="fas fa-search"></i><span>Search</span></button></div>
<div id="mobileSearchModal" class="mobile-search-modal" style="display:none;"><div class="modal-container"><div class="modal-header"><h3><i class="fas fa-map-marker-alt"></i> Search City</h3><button class="close-modal-btn" id="closeModalBtn"><i class="fas fa-times"></i></button></div><div class="mobile-search-input-wrapper"><i class="fas fa-search"></i><input type="text" id="modalCityInput" placeholder="e.g., London, Dubai, Karachi"><div id="modalSuggestions" class="suggestions-list" style="position:relative;width:100%;"></div></div><div class="modal-buttons"><button id="modalSearchBtn" class="btn-primary-solid">Get Qibla Direction</button><button id="modalLocateBtn" class="btn-primary-solid" style="background:var(--primary-dark);">Use My Location</button></div></div></div>

<footer class="footer"><div class="footer-grid"><div class="footer-col"><h4>NextPrayerTime</h4><p>Accurate prayer times since 2023</p><div class="social-icons"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div><div class="footer-col"><h4>Quick Links</h4><a href="/">Home</a><a href="/aboutus">About</a><a href="/blogs">Blog</a><a href="/write-for-us">Write for Us</a></div><div class="footer-col"><h4>Islamic Tools</h4><a href="/islamic-calendar">Hijri Calendar</a><a href="/ramadan-timing">Ramadan Timings</a><a href="/qibla-direction">Qibla Finder</a><a href="/Tasbeeh-counter">Tasbeeh Counter</a><a href="/Zakat-Calculator">Zakat Calculator</a></div><div class="footer-col"><h4>Resources</h4><a href="/mosque-near-me">Mosque Near Me</a><a href="/developers">Developers API</a><a href="/donation">Donation</a></div></div><hr style="margin:24px 24px 12px; border-color:#2c4b38;"><div style="text-align:center; font-size:0.65rem;">© 2026 NextPrayerTimes – Qibla Direction Finder</div></footer>

<script>
    const KAABA_LAT = 21.4225, KAABA_LON = 39.8262;
    let currentLat = null, currentLon = null, currentCityName = null, currentBearing = 0, map = null, userMarker = null, qiblaLine = null, kaabaMarker = null;
    let deviceOrientationActive = false, animationId = null, targetRotation = 0, currentRotation = 0, videoStream = null;
    let lastTimestamp = 0;
    
    const popularCitiesList = [{name:"Mecca",lat:21.4225,lon:39.8262},{name:"Medina",lat:24.5247,lon:39.5692},{name:"Dubai",lat:25.2048,lon:55.2708},{name:"Istanbul",lat:41.0082,lon:28.9784},{name:"Cairo",lat:30.0444,lon:31.2357},{name:"Karachi",lat:24.8607,lon:67.0011},{name:"Riyadh",lat:24.7136,lon:46.6753},{name:"London",lat:51.5074,lon:-0.1278}];
    
    function navigateToCity(cityName){ window.location.href = `/${cityName.toLowerCase().replace(/ /g,'-')}-qibla-direction`; }
    function buildPopularCities(){ const c=document.getElementById("dynamicCityList"); if(c){ c.innerHTML=""; popularCitiesList.forEach(city=>{ let d=document.createElement("div"); d.className="popular-city-card"; d.innerHTML=`<i class="fas fa-city"></i> ${city.name}`; d.onclick=()=>navigateToCity(city.name); c.appendChild(d); }); } }
    function calcBearing(lat,lon){ let φ1=lat*Math.PI/180, φ2=KAABA_LAT*Math.PI/180, Δλ=(KAABA_LON-lon)*Math.PI/180, y=Math.sin(Δλ)*Math.cos(φ2), x=Math.cos(φ1)*Math.sin(φ2)-Math.sin(φ1)*Math.cos(φ2)*Math.cos(Δλ); return (Math.atan2(y,x)*180/Math.PI+360)%360; }
    function calcDistance(lat,lon){ let R=6371, φ1=lat*Math.PI/180, φ2=KAABA_LAT*Math.PI/180, Δφ=(KAABA_LAT-lat)*Math.PI/180, Δλ=(KAABA_LON-lon)*Math.PI/180, a=Math.sin(Δφ/2)**2+Math.cos(φ1)*Math.cos(φ2)*Math.sin(Δλ/2)**2; return (R*2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a))).toFixed(1); }
    function updateDisplay(city,lat,lon,brg,dist){ document.getElementById("currentCityDisplay").innerHTML=city||"Your Location"; document.getElementById("sidebarCityName").innerHTML=city||"Your Location"; document.getElementById("distanceDisplay").innerHTML=dist+" km"; document.getElementById("distanceSidebar").innerHTML=`<i class="fas fa-kaaba"></i> Distance: ${dist} km`; document.getElementById("locationDetails").innerHTML=`Latitude: ${lat.toFixed(4)}<br>Longitude: ${lon.toFixed(4)}`; document.getElementById("liveBearing").innerHTML=brg.toFixed(1)+"°"; document.getElementById("qiblaBadge").innerHTML=`<i class="fas fa-location-arrow"></i> Bearing: ${brg.toFixed(1)}°`; document.getElementById("qiblaSideDir").innerHTML=brg.toFixed(1)+"°"; document.getElementById("locationMsg").innerHTML=`<i class="fas fa-check-circle"></i> ${city||"Your Location"} | Qibla: ${brg.toFixed(1)}° | Distance: ${dist} km`; }
    
    // Super smooth compass animation with physics-based interpolation
    function animateCompass(timestamp){ if(!deviceOrientationActive){ animationId=requestAnimationFrame(animateCompass); return; } let diff=targetRotation-currentRotation; if(diff>180) diff-=360; if(diff<-180) diff+=360; currentRotation+=diff*0.12; let needle=document.getElementById("compassNeedle"); if(needle){ needle.style.transform=`translateX(-50%) rotate(${currentRotation}deg)`; let relativeAngle=(currentBearing-currentRotation+360)%360, dev=Math.min(relativeAngle,360-relativeAngle), status=document.getElementById("matchStatus"); if(dev<=3){ needle.style.background="linear-gradient(180deg, #2ecc71, #27ae60)"; needle.style.boxShadow="0 0 16px #2ecc71"; if(status){ status.innerHTML='<i class="fas fa-check-circle" style="color:#2ecc71;"></i> You are facing the Qibla!'; status.style.background="#e8f5e9"; status.style.color="#2e7d32"; } if(navigator.vibrate&&dev<=2) navigator.vibrate(100); }else{ needle.style.background="linear-gradient(180deg, #e67e22, #c0392b)"; needle.style.boxShadow="none"; if(status){ status.innerHTML=`<i class="fas fa-compass"></i> Turn ${dev.toFixed(0)}° ${relativeAngle<180?"left":"right"} to face Qibla`; status.style.background="#f0f5ed"; status.style.color="#e67e22"; } } } animationId=requestAnimationFrame(animateCompass); }
    
    async function requestCamera(){ try{ let stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:"environment"}}); videoStream=stream; let vid=document.getElementById("cameraVideo"); vid.srcObject=stream; vid.classList.add("active"); }catch(e){ console.log("Camera not available"); } }
    
    function handleOrientation(e){ if(e.alpha!==null){ let alpha=e.alpha; if(e.webkitCompassHeading!==undefined) alpha=e.webkitCompassHeading; if(window.orientation===90) alpha+=90; else if(window.orientation===-90) alpha-=90; else if(window.orientation===180) alpha+=180; targetRotation=alpha%360; if(!deviceOrientationActive){ deviceOrientationActive=true; } } }
    
    async function activateCompass(){ await requestCamera(); if(typeof DeviceOrientationEvent!=='undefined'&&typeof DeviceOrientationEvent.requestPermission==='function'){ try{ let perm=await DeviceOrientationEvent.requestPermission(); if(perm==='granted'){ window.addEventListener('deviceorientation',handleOrientation); deviceOrientationActive=true; document.getElementById("matchStatus").innerHTML='<i class="fas fa-check"></i> Compass active! Rotate your phone.'; }else alert("Please allow compass access"); }catch(e){ fallbackCompass(); } }else{ window.addEventListener('deviceorientation',handleOrientation); deviceOrientationActive=true; document.getElementById("matchStatus").innerHTML='<i class="fas fa-check"></i> Compass active!'; } }
    
    function fallbackCompass(){ let angle=0; setInterval(()=>{ angle=(angle+2)%360; targetRotation=angle; if(!deviceOrientationActive) deviceOrientationActive=true; },50); document.getElementById("matchStatus").innerHTML='<i class="fas fa-info-circle"></i> Demo mode - simulated compass'; }
    
    function updateUI(lat,lon,city){ currentLat=lat; currentLon=lon; currentCityName=city; currentBearing=calcBearing(lat,lon); let dist=calcDistance(lat,lon); updateDisplay(city,lat,lon,currentBearing,dist); if(map&&window.mapInitialized){ if(userMarker) map.removeLayer(userMarker); userMarker=L.marker([lat,lon]).addTo(map).bindPopup(`<b>${city||'Your Location'}</b><br>Qibla: ${currentBearing.toFixed(1)}°`).openPopup(); if(qiblaLine) map.removeLayer(qiblaLine); let pts=[]; for(let i=0;i<=40;i++){ let f=i/40, φ1=lat*Math.PI/180, λ1=lon*Math.PI/180, φ2=KAABA_LAT*Math.PI/180, λ2=KAABA_LON*Math.PI/180, Δλ=λ2-λ1, a=Math.sin((φ2-φ1)/2)**2+Math.cos(φ1)*Math.cos(φ2)*Math.sin(Δλ/2)**2, δ=2*Math.atan2(Math.sqrt(a),Math.sqrt(1-a)), A=Math.sin((1-f)*δ)/Math.sin(δ), B=Math.sin(f*δ)/Math.sin(δ), x=A*Math.cos(φ1)*Math.cos(λ1)+B*Math.cos(φ2)*Math.cos(λ2), y=A*Math.cos(φ1)*Math.sin(λ1)+B*Math.cos(φ2)*Math.sin(λ2), z=A*Math.sin(φ1)+B*Math.sin(φ2); pts.push([Math.atan2(z,Math.sqrt(x*x+y*y))*180/Math.PI,Math.atan2(y,x)*180/Math.PI]); } qiblaLine=L.polyline(pts,{color:'#2a7f4e',weight:3,dashArray:'6,6'}).addTo(map); if(!kaabaMarker) kaabaMarker=L.marker([KAABA_LAT,KAABA_LON],{icon:L.divIcon({html:'<div style="background:#d44c2f;width:28px;height:28px;border-radius:8px;text-align:center;line-height:28px;font-size:16px;">🕋</div>',iconSize:[28,28]})}).addTo(map).bindPopup('Holy Kaaba'); map.fitBounds([[lat,lon],[KAABA_LAT,KAABA_LON]],{padding:[40,40]}); } }
    
    function initMap(lat,lon){ if(map) map.remove(); map=L.map('qiblaMap').setView([lat,lon],5); L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{attribution:'© OpenStreetMap'}).addTo(map); window.mapInitialized=true; kaabaMarker=L.marker([KAABA_LAT,KAABA_LON],{icon:L.divIcon({html:'<div style="background:#d44c2f;width:28px;height:28px;border-radius:8px;text-align:center;line-height:28px;font-size:16px;">🕋</div>',iconSize:[28,28]})}).addTo(map).bindPopup('Holy Kaaba'); if(lat&&lon) updateUI(lat,lon,"London"); }
    
    function getUserLocation(){ if(!navigator.geolocation){ alert("Geolocation not supported"); initMap(51.5074,-0.1278); updateUI(51.5074,-0.1278,"London"); return; } document.getElementById("locationMsg").innerHTML='<i class="fas fa-spinner fa-pulse"></i> Requesting location...'; navigator.geolocation.getCurrentPosition(async(pos)=>{ let lat=pos.coords.latitude, lon=pos.coords.longitude, exact="Your Location"; try{ let res=await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`); let data=await res.json(); let addr=data.address||{}; exact=addr.suburb||addr.city_district||addr.town||addr.city||addr.village||addr.hamlet||addr.neighbourhood||"Your Location"; if(addr.road&&addr.suburb) exact=`${addr.road}, ${addr.suburb}`; }catch(e){} if(!map||!window.mapInitialized) initMap(lat,lon); updateUI(lat,lon,exact); map.setView([lat,lon],15); },(err)=>{ alert("Location access denied. Using default London."); if(!map||!window.mapInitialized) initMap(51.5074,-0.1278); updateUI(51.5074,-0.1278,"London"); },{enableHighAccuracy:true,timeout:15000}); }
    
    const searchInput=document.getElementById("citySearchInput"), suggestionsBox=document.getElementById("searchSuggestions"), searchBtn=document.getElementById("searchCityBtn"); let searchTimeout;
    async function performSearch(){ let q=searchInput.value.trim(); if(q.length<2) return; try{ let res=await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(q)}&format=json&limit=1&featureclass=city`); let data=await res.json(); if(data.length) navigateToCity(data[0].display_name.split(',')[0]); else alert("City not found"); }catch(e){ alert("Search error"); } }
    searchBtn.addEventListener("click",performSearch); searchInput.addEventListener("keypress",(e)=>{if(e.key==="Enter")performSearch();});
    searchInput.addEventListener("input",function(){ clearTimeout(searchTimeout); let q=this.value.trim(); if(q.length<2){ suggestionsBox.style.display="none"; return; } searchTimeout=setTimeout(async()=>{ try{ let res=await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(q)}&format=json&limit=5&featureclass=city`); let data=await res.json(); if(data.length){ suggestionsBox.innerHTML=data.map(p=>`<div class="suggestion-item" data-name="${p.display_name.split(',')[0]}"><i class="fas fa-map-marker-alt" style="margin-right:6px;color:var(--primary);"></i> ${p.display_name.substring(0,50)}</div>`).join(''); suggestionsBox.style.display="block"; document.querySelectorAll('.suggestion-item').forEach(item=>{ item.addEventListener("click",()=>{ navigateToCity(item.dataset.name); }); }); }else suggestionsBox.style.display="none"; }catch(e){ suggestionsBox.style.display="none"; } },300); }); document.addEventListener("click",(e)=>{if(!searchInput.contains(e.target)&&!suggestionsBox.contains(e.target)) suggestionsBox.style.display="none";});
    
    let citiesStatic=[{name:"London",lat:51.5074,lon:-0.1278},{name:"Mecca",lat:21.4225,lon:39.8262},{name:"Medina",lat:24.5247,lon:39.5692},{name:"Dubai",lat:25.2048,lon:55.2708},{name:"Istanbul",lat:41.0082,lon:28.9784},{name:"Karachi",lat:24.8607,lon:67.0011},{name:"Cairo",lat:30.0444,lon:31.2357}];
    function buildCityLists(){ let g=document.getElementById("cityList"); if(g){ g.innerHTML=""; citiesStatic.forEach(c=>{ let chip=document.createElement("span"); chip.className="city-chip"; chip.innerHTML='<i class="fas fa-city"></i> '+c.name; chip.onclick=()=>navigateToCity(c.name); g.appendChild(chip); }); } }
    
    const modal=document.getElementById("mobileSearchModal"), modalInput=document.getElementById("modalCityInput"), modalSuggest=document.getElementById("modalSuggestions");
    function openModal(){ modal.style.display="flex"; setTimeout(()=>modalInput.focus(),50); } function closeModal(){ modal.style.display="none"; modalSuggest.style.display="none"; }
    document.getElementById("closeModalBtn")?.addEventListener("click",closeModal); modal.addEventListener("click",(e)=>{if(e.target===modal)closeModal();});
    document.getElementById("modalSearchBtn")?.addEventListener("click",async()=>{ if(modalInput.value.trim()){ let q=modalInput.value.trim(); try{ let res=await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(q)}&format=json&limit=1&featureclass=city`); let data=await res.json(); if(data.length) navigateToCity(data[0].display_name.split(',')[0]); else alert("City not found"); }catch(e){ alert("Error"); } closeModal(); } });
    document.getElementById("modalLocateBtn")?.addEventListener("click",()=>{ getUserLocation(); closeModal(); });
    let modalTimeout; modalInput.addEventListener("input",(e)=>{ clearTimeout(modalTimeout); let v=e.target.value.trim(); if(v.length<2){ modalSuggest.style.display="none"; return; } modalTimeout=setTimeout(async()=>{ try{ let res=await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(v)}&format=json&limit=4&featureclass=city`); let data=await res.json(); if(data.length){ modalSuggest.innerHTML=data.map(p=>`<div class="suggestion-item" data-name="${p.display_name.split(',')[0]}">${p.display_name.substring(0,45)}</div>`).join(''); modalSuggest.style.display="block"; modalSuggest.querySelectorAll(".suggestion-item").forEach(el=>{ el.addEventListener("click",()=>{ navigateToCity(el.dataset.name); }); }); }else modalSuggest.style.display="none"; }catch(e){ modalSuggest.style.display="none"; } },300); });
    
    document.querySelectorAll(".nav-icon").forEach(btn=>{ btn.addEventListener("click",()=>{ let t=btn.dataset.nav; if(t==="home") window.location.href="/"; else if(t==="qibla") window.location.href="/qibla-direction"; else if(t==="zakat") window.location.href="/Zakat-Calculator"; else if(t==="search") openModal(); }); });
    let mobileToggle=document.getElementById("mobileMenuToggle"), navLinks=document.getElementById("navLinks"), overlayMenu=document.getElementById("menuOverlay");
    mobileToggle.onclick=()=>{ navLinks.classList.toggle("open"); overlayMenu.classList.toggle("active"); mobileToggle.innerHTML=navLinks.classList.contains("open")?'<i class="fas fa-times"></i>':'<i class="fas fa-bars"></i>'; };
    overlayMenu.onclick=()=>{ navLinks.classList.remove("open"); overlayMenu.classList.remove("active"); mobileToggle.innerHTML='<i class="fas fa-bars"></i>'; };
    document.getElementById("goToPrayerBtn")?.addEventListener("click",()=>{ window.location.href="/prayer-times"; });
    document.getElementById("activateCompassBtn").addEventListener("click",activateCompass);
    document.getElementById("getMyLocationBtn").addEventListener("click",getUserLocation);
    
    buildPopularCities(); buildCityLists(); initMap(51.5074,-0.1278); getUserLocation();
    animationId=requestAnimationFrame(animateCompass);
    window.addEventListener('beforeunload',()=>{ if(videoStream) videoStream.getTracks().forEach(t=>t.stop()); if(animationId) cancelAnimationFrame(animationId); });
</script>
</body>
</html>
