
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=yes">
    <title>Islamic Prayer Times | Accurate Islamic Salah Times Near You</title>
    <meta name="description" content="Accurate prayer times, Qibla direction, Hijri calendar and Islamic tools. Professional interface with advanced features.">
    <meta name="keywords" content="next prayer times, salah times, islamic prayer, fajr prayer time, dhuhr prayer time, asr prayer time, maghrib prayer time, isha prayer time, muslim, islam">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            --shadow-sm: 0 4px 14px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 28px rgba(0,0,0,0.08);
            --radius-lg: 1.5rem;
            --radius-md: 1rem;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-primary); line-height: 1.5; }
        #alarmBanner { position: fixed; top: 70px; left: 0; right: 0; z-index: 999; padding: 0 20px; pointer-events: none; }
        #alarmBanner .alert { pointer-events: auto; max-width: 500px; margin: 0 auto; border-radius: 60px; box-shadow: var(--shadow-md); }
        .app-wrapper { display: flex; max-width: 1400px; margin: 0 auto; gap: 28px; padding: 0 24px; }
        .main-content { flex: 1; min-width: 0; }
        .right-sidebar { width: 320px; flex-shrink: 0; margin-top: 28px; position: sticky; top: 24px; height: fit-content; }
        
        .skeleton { background: linear-gradient(90deg, #e0e5e0 25%, #f0f5f0 50%, #e0e5e0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: var(--radius-md); }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .prayer-grid-skeleton { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 28px 0; }
        .skeleton-card { height: 140px; border-radius: var(--radius-md); }
        
        .header { background: var(--bg-card); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.98); backdrop-filter: blur(8px); }
        .nav-bar { display: flex; justify-content: space-between; align-items: center; padding: 14px 24px; max-width: 1400px; margin: 0 auto; }
        .logo h1 { font-size: 1.4rem; font-weight: 700; letter-spacing: -0.3px; }
        .logo span { color: var(--primary); }
        .logo p { font-size: 0.7rem; color: var(--text-muted); }
        .nav-links { display: flex; gap: 24px; align-items: center; flex-wrap: wrap; }
        .nav-links a { text-decoration: none; font-size: 0.85rem; font-weight: 500; color: var(--text-secondary); transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary); }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-toggle { cursor: pointer; }
        .dropdown-menu { position: absolute; top: 100%; left: 0; background: var(--bg-card); border-radius: 1rem; box-shadow: var(--shadow-md); min-width: 200px; padding: 8px 0; opacity: 0; visibility: hidden; transition: 0.2s; z-index: 100; border: 1px solid var(--border); }
        .dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; }
        .dropdown-menu a { display: block; padding: 10px 20px; font-size: 0.8rem; }
        .dropdown-menu a:hover { background: var(--bg-main); }
        .btn-outline-nav, .btn-primary-nav { padding: 6px 20px; border-radius: 40px; font-weight: 500; }
        .btn-outline-nav { border: 1.5px solid var(--border); background: transparent; }
        .btn-primary-nav { background: var(--primary); color: white !important; }
        .mobile-menu-toggle { display: none; background: none; border: none; font-size: 1.6rem; color: var(--primary); cursor: pointer; }
        
        .hero-card { background: var(--bg-card); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); margin-top: 30px; }
        .time-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 2px solid var(--border); }
        .current-time-box .label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .current-time-box .time-value { font-size: 2.2rem; font-weight: 700; color: var(--primary); font-family: monospace; }
        .next-badge { background: #eef5ea; padding: 12px 28px; border-radius: 60px; font-weight: 600; font-size: 0.9rem; color: var(--primary-dark); }
        .search-wrapper { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .search-input-wrapper { flex: 1; position: relative; min-width: 240px; }
        #locationInput { width: 100%; padding: 14px 20px 14px 48px; border: 1.5px solid var(--border); border-radius: 60px; font-size: 0.95rem; background: white; }
        #locationInput:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(42,127,78,0.1); }
        .search-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .btn-primary, .btn-secondary { padding: 0 32px; border-radius: 60px; font-weight: 600; cursor: pointer; border: none; height: 52px; font-size: 0.9rem; transition: 0.2s; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn-secondary { background: white; border: 1.5px solid var(--border); color: var(--text-primary); }
        .btn-secondary:hover { border-color: var(--primary); background: #f9fdf8; }
        .suggestions-list { position: absolute; background: white; border: 1px solid var(--border); border-radius: 20px; width: 100%; max-height: 280px; overflow-y: auto; z-index: 60; margin-top: 8px; box-shadow: var(--shadow-md); }
        .suggestion-item { padding: 12px 20px; cursor: pointer; font-size: 0.9rem; border-bottom: 1px solid #f0f0f0; }
        .suggestion-item:hover { background: var(--bg-main); }
        
        .prayer-section { background: var(--bg-card); border-radius: var(--radius-md); padding: 28px; margin-bottom: 24px; border: 1px solid var(--border); }
        .prayer-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 28px 0; }
        .prayer-card { border-radius: var(--radius-md); padding: 24px 12px; text-align: center; background-size: cover; background-position: center; position: relative; overflow: hidden; min-height: 140px; cursor: pointer; transition: all 0.3s ease; }
        .prayer-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); border-radius: var(--radius-md); z-index: 0; }
        .prayer-card.fajr-card::before { background: rgba(0,0,0,0.25); }
        .prayer-card.sunrise-card::before { background: rgba(0,0,0,0.2); }
        .prayer-card.isha-card::before { background: rgba(0,0,0,0.55); }
        .prayer-card > * { position: relative; z-index: 1; }
        .prayer-card.active-prayer { border: 3px solid var(--primary); transform: scale(1.02); box-shadow: var(--shadow-md); }
        .prayer-name { font-size: 0.85rem; font-weight: 800; text-transform: uppercase; color: white; background: rgba(0,0,0,0.5); display: inline-block; padding: 5px 14px; border-radius: 40px; letter-spacing: 1px; }
        .prayer-time { font-size: 1.7rem; font-weight: 800; font-family: monospace; color: white; margin-top: 12px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .prayer-card.fajr-card .prayer-name, .prayer-card.sunrise-card .prayer-name { color: #2d3e2b; background: rgba(255,255,255,0.8); }
        .upcoming-alert { background: #eef5ea; border-radius: 1rem; padding: 16px; text-align: center; font-weight: 500; }
        
        .tools-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 16px; margin: 20px 0; }
        .tool-item { background: linear-gradient(135deg, #fafdf8, #f2f7ef); border-radius: 1rem; padding: 20px 12px; text-align: center; border: 1px solid var(--border); cursor: pointer; transition: 0.2s; text-decoration: none; display: block; color: var(--text-primary); }
        .tool-item:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--primary-light); }
        .tool-item i { font-size: 2rem; color: var(--primary); margin-bottom: 12px; }
        .tool-item h4 { font-size: 0.9rem; font-weight: 600; margin-bottom: 5px; }
        .tool-item p { font-size: 0.7rem; color: var(--text-muted); }
        
        .description-section, .faq-item { background: var(--bg-card); border-radius: var(--radius-md); padding: 28px; margin-bottom: 24px; border: 1px solid var(--border); }
        .description-section h3 { color: var(--primary); margin-bottom: 16px; font-size: 1.25rem; }
        .methods-list { display: flex; flex-wrap: wrap; gap: 12px; margin: 20px 0; }
        .method-badge { background: #e8f3e5; padding: 6px 16px; border-radius: 40px; font-size: 0.75rem; font-weight: 500; color: var(--primary-dark); }
        .map-cities { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .city-quick { background: rgba(42,127,78,0.12); padding: 7px 18px; border-radius: 40px; cursor: pointer; font-size: 0.85rem; transition: 0.2s; display: inline-block; }
        .city-quick:hover { background: var(--primary); color: white; }
        
        .sidebar-card { background: var(--bg-card); border-radius: var(--radius-md); padding: 22px; margin-bottom: 24px; border: 1px solid var(--border); }
        .toggle-switch { width: 52px; height: 26px; background: #ccc; border-radius: 30px; position: relative; cursor: pointer; }
        .toggle-switch.active { background: var(--primary); }
        .toggle-switch::after { content: ''; width: 22px; height: 22px; background: white; border-radius: 50%; position: absolute; top: 2px; left: 4px; transition: 0.2s; }
        .toggle-switch.active::after { left: 26px; }
        .city-link { padding: 10px 0; border-bottom: 1px solid var(--border); cursor: pointer; transition: 0.1s; }
        .city-link:hover { color: var(--primary); padding-left: 6px; }
        
        .footer { background: #112e1f; color: #d4e0d4; margin-top: 48px; padding: 48px 0 28px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; max-width: 1400px; margin: 0 auto; padding: 0 24px; }
        .footer-col h4 { color: white; margin-bottom: 16px; font-size: 1rem; }
        .footer-col p, .footer-col a { font-size: 0.8rem; color: #c0d4c0; text-decoration: none; display: block; margin-bottom: 8px; }
        .footer-col a:hover { color: white; padding-left: 4px; }
        .social-icons { display: flex; gap: 18px; margin-top: 12px; }
        
        .mobile-bottom-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: rgba(255,255,255,0.96); backdrop-filter: blur(20px); border-top: 1px solid rgba(226,234,224,0.8); padding: 10px 20px 12px; z-index: 200; justify-content: space-around; align-items: center; }
        .nav-icon { display: flex; flex-direction: column; align-items: center; gap: 4px; background: none; border: none; font-size: 1.3rem; color: var(--text-muted); cursor: pointer; transition: 0.2s; padding: 6px 12px; border-radius: 40px; }
        .nav-icon span { font-size: 0.65rem; font-weight: 500; }
        .nav-icon.active { color: var(--primary); background: rgba(42,127,78,0.1); }
        
        .mobile-search-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(12px); z-index: 300; display: flex; align-items: center; justify-content: center; }
        .modal-container { background: var(--bg-card); border-radius: 32px; width: 90%; max-width: 450px; padding: 28px 24px 32px; box-shadow: var(--shadow-md); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .modal-header h3 { font-size: 1.3rem; color: var(--primary); font-weight: 700; }
        .close-modal-btn { background: #f0f0f0; border: none; width: 36px; height: 36px; border-radius: 30px; cursor: pointer; }
        .mobile-search-input-wrapper { position: relative; width: 100%; margin-bottom: 20px; }
        .mobile-search-input-wrapper input { width: 100%; padding: 14px 20px 14px 48px; border: 1.5px solid var(--border); border-radius: 60px; font-size: 0.95rem; }
        .mobile-search-input-wrapper i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); }
        .modal-buttons { display: flex; flex-direction: column; gap: 12px; }
        .modal-buttons button { width: 100%; padding: 12px; font-size: 0.9rem; }
        
        @media (max-width: 1024px) {
            .app-wrapper { flex-direction: column; padding: 0 16px; gap: 20px; }
            .right-sidebar { width: 100%; position: static; margin-top: 0; }
            .hero-card, .prayer-section, .description-section, .faq-item { padding: 20px; }
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: block; }
            .nav-links { position: fixed; top: 0; left: -100%; width: 75%; max-width: 280px; height: 100vh; background: var(--bg-card); flex-direction: column; align-items: flex-start; padding: 80px 24px 32px; gap: 16px; z-index: 105; border-right: 1px solid var(--border); transition: left 0.3s; }
            .nav-links.open { left: 0; }
            .menu-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 104; opacity: 0; visibility: hidden; }
            .menu-overlay.active { opacity: 1; visibility: visible; }
            .prayer-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; margin: 20px 0; }
            .prayer-card { padding: 16px 8px; min-height: 110px; }
            .prayer-time { font-size: 1rem; }
            .prayer-name { font-size: 0.7rem; padding: 4px 10px; }
            .hero-card { padding: 16px; margin-top: 16px; }
            .time-row { gap: 12px; margin-bottom: 16px; }
            .current-time-box .time-value { font-size: 1.4rem; }
            .next-badge { font-size: 0.7rem; padding: 6px 14px; }
            .btn-primary, .btn-secondary { height: 44px; padding: 0 20px; font-size: 0.8rem; }
            .tools-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .tool-item { padding: 12px 8px; }
            .tool-item i { font-size: 1.5rem; }
            .tool-item h4 { font-size: 0.75rem; }
            .tool-item p { font-size: 0.6rem; }
            .description-section h3, .faq-item strong { font-size: 1rem; }
            .description-section p, .faq-item { font-size: 0.8rem; padding: 16px; }
            .method-badge { font-size: 0.65rem; padding: 4px 12px; }
            .city-quick { font-size: 0.7rem; padding: 5px 12px; }
            .footer-grid { gap: 20px; text-align: center; }
            .footer-col h4 { font-size: 0.9rem; }
            .footer-col p, .footer-col a { font-size: 0.7rem; }
            .social-icons { justify-content: center; }
            .mobile-bottom-nav { display: flex; }
            .hero-card .search-wrapper .btn-primary,
            .hero-card .search-wrapper .btn-secondary { display: none; }
            .hero-card .search-input-wrapper { width: 100%; }
            body { padding-bottom: 70px; }
            .sidebar-card { padding: 16px; margin-bottom: 16px; }
            .sidebar-card h3 { font-size: 1rem; }
            .right-sidebar { margin-top: 0; }
        }
        @media (max-width: 480px) {
            .app-wrapper { padding: 0 12px; }
            .prayer-grid { gap: 8px; }
            .prayer-card { min-height: 95px; }
            .prayer-time { font-size: 0.85rem; margin-top: 6px; }
            .upcoming-alert { font-size: 0.75rem; padding: 10px; }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="nav-bar">
        <a class="logo" href="/" style="text-decoration:none;"><h1>Next<span>PrayerTime</span></h1><p>Precision Salah Times & Islamic Tools</p></a>
        <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
        <div class="nav-links" id="navLinks">
            <a href="/">Home</a>
            <a href="/qibla-direction">Qibla Finder</a>
            <a href="/ramadan-timing">Ramadan Timings</a>
            <a href="/prayer-times">Prayer Times</a>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle">Islamic Tools <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-menu">
                    <a href="/islamic-calendar">Islamic Calendar</a>
                    <a href="/Tasbeeh-counter">Dua & Azkar</a>
                    <a href="/zakat-calculator">Zakat Calculator</a>
                    <a href="/mosque-near-me">Mosque Finder</a>
                </div>
            </div>
            <a href="/blogs">Blogs</a>
            <a href="/developers">Developers</a>
            <a href="/user/login" class="btn-outline-nav"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="/user/register" class="btn-primary-nav"><i class="fas fa-user-plus"></i> Register</a>
        </div>
    </div>
    <div id="menuOverlay" class="menu-overlay"></div>
</div>

<div id="alarmBanner"></div>

<div class="app-wrapper">
    <div class="main-content">
        <div class="hero-card">
            <div class="time-row">
                <div class="current-time-box"><div class="label">Current Local Time</div><div class="time-value" id="liveClock">--:--:--</div></div>
                <div class="next-badge" id="nextPrayerWidget">--</div>
            </div>
            <div class="search-container">
                <div class="search-wrapper">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="locationInput" placeholder="Search any city worldwide... London, Dubai, New York">
                        <div id="suggestionsBox" class="suggestions-list" style="display:none;"></div>
                    </div>
                    <button id="searchBtn" class="btn-primary">Get Times</button>
                    <button id="liveLocationBtn" class="btn-secondary"><i class="fas fa-location-dot"></i> Use My Location</button>
                </div>
                <div id="locationStatus" style="margin-top: 12px; font-size:0.7rem; color:var(--primary-dark);"></div>
            </div>
        </div>

        <div class="prayer-section">
            <h2 style="font-size:1.2rem;">Prayer Times in <span id="cityNameDisplay" style="color:var(--primary); font-weight:700;">--</span></h2>
            <div id="prayerTimesGridContainer"><div class="prayer-grid-skeleton"><div class="skeleton-card skeleton"></div><div class="skeleton-card skeleton"></div><div class="skeleton-card skeleton"></div><div class="skeleton-card skeleton"></div><div class="skeleton-card skeleton"></div><div class="skeleton-card skeleton"></div></div></div>
            <div class="upcoming-alert" id="nextPrayerBanner"><strong>Upcoming Prayer:</strong> <span id="upcomingPrayerName">—</span> at <span id="upcomingPrayerTime">--:--</span></div>
        </div>

        <div class="hero-card">
            <i class="fas fa-globe-asia" style="font-size:1.4rem; color:var(--primary);"></i>
            <h3 style="margin:10px 0 6px; font-size:1.2rem;">World Prayer Times</h3>
            <p style="font-size:0.75rem;">Click any city for instant prayer times</p>
            <div class="map-cities" id="worldCitiesList"></div>
        </div>

        <div class="description-section">
            <h3>Next Prayer Times – Accurate Salah Timings Worldwide</h3>
            <p>Find daily Salah schedules, Hijri dates, and prayer reminders — trusted by Muslims worldwide.</p>
            <p><strong>Stay Connected with Daily Salah Timings</strong><br>Prayer (Salah) is one of the most important pillars of Islam, observed five times a day.</p>
            <div class="methods-list">
                <span class="method-badge">University of Islamic Sciences, Karachi</span>
                <span class="method-badge">Muslim World League</span>
                <span class="method-badge">Umm al-Qura, Makkah</span>
                <span class="method-badge">Egyptian General Authority</span>
            </div>
        </div>

        <div class="hero-card">
            <h3 style="font-size:1.2rem;"><i class="fas fa-toolbox" style="color:var(--primary);"></i> Islamic Tools</h3>
            <div class="tools-grid">
                <a href="/islamic-calendar" class="tool-item"><i class="fas fa-calendar-alt"></i><h4>Islamic Calendar</h4><p>Hijri & Gregorian</p></a>
                <a href="/Tasbeeh-counter" class="tool-item"><i class="fas fa-hands-praying"></i><h4>Dua & Azkar</h4><p>Daily supplications</p></a>
                <a href="/zakat-calculator" class="tool-item"><i class="fas fa-coins"></i><h4>Zakat Calculator</h4><p>Calculate your Zakat</p></a>
                <a href="/mosque-near-me" class="tool-item"><i class="fas fa-mosque"></i><h4>Mosque Finder</h4><p>Nearby mosques</p></a>
                <a href="/qibla-direction" class="tool-item"><i class="fas fa-compass"></i><h4>Qibla Finder</h4><p>Direction to Makkah</p></a>
            </div>
        </div>

        <div class="faq-item"><strong>What is Fajr prayer time?</strong><br>Fajr begins at dawn and ends at sunrise.</div>
        <div class="faq-item"><strong>How are Islamic prayer times calculated?</strong><br>Based on sun angles and location using recognized methods.</div>
        <div class="faq-item"><strong>Can I get prayer times for my city?</strong><br>Yes, search your city above or use live location.</div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-card"><h3><i class="fas fa-compass"></i> Qibla Direction</h3><p>Accurate direction to Makkah.</p><a href="/qibla-direction" style="background:var(--primary); border:none; padding:10px; border-radius:40px; color:white; width:100%; display:inline-block; text-align:center; text-decoration:none; font-size:0.85rem;">Find Qibla</a></div>
        <div class="sidebar-card"><h3><i class="fas fa-bell"></i> Prayer Alarms</h3><div style="display:flex; justify-content:space-between; align-items:center;"><span>Adhan Notifications</span><div id="notificationToggle" class="toggle-switch"></div></div><p style="font-size:0.65rem; margin-top:8px;">Enable alerts 1 min before prayer</p></div>
        <div class="sidebar-card"><h3><i class="fas fa-calendar-alt"></i> Islamic Calendar</h3><div id="hijriDateDisplay" style="font-weight:500; font-size:0.9rem;"></div><a href="/islamic-calendar" style="margin-top:12px; background:transparent; border:1px solid var(--border); padding:8px; border-radius:40px; width:100%; display:inline-block; text-align:center; text-decoration:none; font-size:0.8rem;">View Calendar</a></div>
        <div class="sidebar-card"><h3><i class="fas fa-city"></i> Quick Cities</h3><div id="sidebarCityList"></div></div>
    </div>
</div>

<div class="mobile-bottom-nav" id="mobileBottomNav">
    <button class="nav-icon" data-nav="home"><i class="fas fa-home"></i><span>Home</span></button>
    <button class="nav-icon" data-nav="qibla"><i class="fas fa-compass"></i><span>Qibla</span></button>
    <button class="nav-icon" data-nav="zakat"><i class="fas fa-coins"></i><span>Tasbih</span></button>
    <button class="nav-icon" data-nav="search"><i class="fas fa-search"></i><span>Search</span></button>
</div>

<div id="mobileSearchModal" class="mobile-search-modal" style="display: none;">
    <div class="modal-container">
        <div class="modal-header"><h3><i class="fas fa-map-marker-alt"></i> Search City</h3><button class="close-modal-btn" id="closeModalBtn"><i class="fas fa-times"></i></button></div>
        <div class="mobile-search-input-wrapper"><i class="fas fa-search"></i><input type="text" id="modalLocationInput" placeholder="e.g., London, Dubai, Karachi"><div id="modalSuggestionsBox" class="suggestions-list" style="display:none;"></div></div>
        <div class="modal-buttons"><button id="modalSearchBtn" class="btn-primary">Get Prayer Times</button><button id="modalLiveBtn" class="btn-secondary">Use My Location</button></div>
    </div>
</div>

<footer class="footer">
    <div class="footer-grid">
        <div class="footer-col"><h4>NextPrayerTime</h4><p>Providing accurate prayer times since 2023.</p><div class="social-icons"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
        <div class="footer-col"><h4>Quick Links</h4><a href="/">Home</a><a href="/blogs">Blogs</a><a href="/developers">Developers</a><a href="/user/login">Login</a><a href="/user/register">Register</a></div>
        <div class="footer-col"><h4>Islamic Tools</h4><a href="/islamic-calendar">Hijri Calendar</a><a href="/ramadan-timing">Ramadan Timings</a><a href="/qibla-direction">Qibla Finder</a><a href="/Tasbeeh-counter">Tasbih Counter</a></div>
        <div class="footer-col"><h4>Connect</h4><a href="#">Facebook</a><a href="#">Twitter</a><a href="#">Instagram</a><p style="margin-top:12px; font-size:0.7rem;">Shawwal 29, 1447 AH</p></div>
    </div>
    <hr style="margin:32px 24px 16px; border-color:#2c4b38;">
    <div style="text-align:center; font-size:0.7rem;">© 2026 NextPrayerTimes. All Rights Reserved.</div>
</footer>

<script>
    const prayerDB = { "Lahore": { Fajr: "4:42 AM", Sunrise: "6:10 AM", Dhuhr: "12:08 PM", Asr: "3:31 PM", Maghrib: "6:04 PM", Isha: "7:32 PM" }, "Dubai": { Fajr: "5:05 AM", Sunrise: "6:25 AM", Dhuhr: "12:32 PM", Asr: "4:00 PM", Maghrib: "6:39 PM", Isha: "7:59 PM" }, "Riyadh": { Fajr: "4:45 AM", Sunrise: "6:05 AM", Dhuhr: "12:00 PM", Asr: "3:25 PM", Maghrib: "5:55 PM", Isha: "7:15 PM" }, "London": { Fajr: "5:15 AM", Sunrise: "6:52 AM", Dhuhr: "12:58 PM", Asr: "4:20 PM", Maghrib: "7:05 PM", Isha: "8:38 PM" }, "Karachi": { Fajr: "5:10 AM", Sunrise: "6:30 AM", Dhuhr: "12:38 PM", Asr: "4:05 PM", Maghrib: "6:45 PM", Isha: "8:05 PM" }, "New York": { Fajr: "5:52 AM", Sunrise: "7:20 AM", Dhuhr: "1:00 PM", Asr: "4:24 PM", Maghrib: "6:41 PM", Isha: "8:09 PM" }, "Istanbul": { Fajr: "5:22 AM", Sunrise: "6:48 AM", Dhuhr: "1:08 PM", Asr: "4:33 PM", Maghrib: "7:28 PM", Isha: "8:52 PM" }, "Mecca": { Fajr: "5:12 AM", Sunrise: "6:28 AM", Dhuhr: "12:28 PM", Asr: "3:52 PM", Maghrib: "6:26 PM", Isha: "7:42 PM" }, "Jakarta": { Fajr: "4:43 AM", Sunrise: "5:55 AM", Dhuhr: "12:00 PM", Asr: "3:04 PM", Maghrib: "6:03 PM", Isha: "7:11 PM" }, "Cairo": { Fajr: "5:00 AM", Sunrise: "6:20 AM", Dhuhr: "12:04 PM", Asr: "3:30 PM", Maghrib: "5:48 PM", Isha: "7:08 PM" }, "Medina": { Fajr: "5:00 AM", Sunrise: "6:20 AM", Dhuhr: "12:20 PM", Asr: "3:45 PM", Maghrib: "6:18 PM", Isha: "7:38 PM" } };
    const defaultPrayers = { Fajr: "5:15 AM", Sunrise: "6:35 AM", Dhuhr: "12:25 PM", Asr: "3:55 PM", Maghrib: "6:35 PM", Isha: "7:55 PM" };
    let currentCity = null;
    const prayerBgImages = { Fajr: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOMDQHO2NxhpPiQvwW-JV7nHQQherXJ4odXw&s')", Sunrise: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTvrCQlMeLcw6lWfHBO0IjZAocWE5GX5c4fA&s')", Dhuhr: "url('https://images.pexels.com/photos/268533/pexels-photo-268533.jpeg?auto=compress&cs=tinysrgb&w=600')", Asr: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTosAxuqNUMTDU4uYOb8SJMdCS7q0agIk_5AQ&s')", Maghrib: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7nFhAORW1hswyFYLNhufAz98AanE_FodeMA&s')", Isha: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTklQtlojikQuNOkDOwVJRRv1TZGT2bE8YbZQ&s')" };
    function getPrayers(city) { return prayerDB[city] || defaultPrayers; }
    function toMinutes(timeStr) { let [h,m,mod] = timeStr.split(/:| /); let hour = parseInt(h), min = parseInt(m); if(mod === "PM" && hour !== 12) hour += 12; if(mod === "AM" && hour === 12) hour = 0; return hour*60+min; }
    function redirectToCityPage(city) { window.location.href = `/prayer-times-in-${city.toLowerCase().replace(/ /g, '-')}`; }
    function renderPrayerTimes(city) {
        if(!city) return;
        const prayers = getPrayers(city);
        const order = ["Fajr","Sunrise","Dhuhr","Asr","Maghrib","Isha"];
        const now = new Date().getHours()*60+new Date().getMinutes();
        let activeIdx = 0;
        for(let i=0;i<order.length;i++) if(toMinutes(prayers[order[i]]) > now) { activeIdx = i; break; }
        const grid = document.getElementById("prayerTimesGrid");
        if(!grid) return;
        grid.innerHTML = "";
        order.forEach((name, idx) => {
            const card = document.createElement("div");
            card.className = `prayer-card ${idx === activeIdx ? 'active-prayer' : ''}`;
            if(name === "Fajr") card.classList.add("fajr-card");
            if(name === "Sunrise") card.classList.add("sunrise-card");
            if(name === "Isha") card.classList.add("isha-card");
            card.innerHTML = `<div class="prayer-name">${name}</div><div class="prayer-time">${prayers[name]}</div>`;
            card.style.backgroundImage = prayerBgImages[name];
            card.style.backgroundSize = "cover";
            card.onclick = () => alert(`${name} prayer time: ${prayers[name]}`);
            grid.appendChild(card);
        });
        document.getElementById("cityNameDisplay").innerText = city;
        let upcoming = null;
        for(let p of order) if(toMinutes(prayers[p]) > now) { upcoming = {name:p, time:prayers[p]}; break; }
        if(!upcoming) upcoming = {name:order[0], time:prayers[order[0]]};
        document.getElementById("upcomingPrayerName").innerText = upcoming.name;
        document.getElementById("upcomingPrayerTime").innerText = upcoming.time;
        document.getElementById("nextPrayerWidget").innerHTML = `Next Prayer: ${upcoming.name} at ${upcoming.time}`;
    }
    function updateCityAndRender(city) { currentCity = city; renderPrayerTimes(city); document.getElementById("locationStatus").innerHTML = `📍 Prayer times for ${city}`; }
    
    // Auto-location on page load - browser popup will appear automatically
    function autoGetUserLocation() {
        if(!("geolocation" in navigator)) {
            document.getElementById("locationStatus").innerHTML = "⚠️ Geolocation not supported. Please search manually.";
            return;
        }
        
        document.getElementById("prayerTimesGridContainer").innerHTML = `<div class="prayer-grid-skeleton">${Array(6).fill('<div class="skeleton-card skeleton"></div>').join('')}</div>`;
        document.getElementById("cityNameDisplay").innerText = "Requesting location...";
        document.getElementById("nextPrayerWidget").innerHTML = "Loading...";
        document.getElementById("locationStatus").innerHTML = "📍 Please allow location access for accurate prayer times";
        
        navigator.geolocation.getCurrentPosition(
            async (position) => {
                const lat = position.coords.latitude, lon = position.coords.longitude;
                document.getElementById("locationStatus").innerHTML = "📍 Detecting your city...";
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=en`);
                    const data = await res.json();
                    let city = data.address?.city || data.address?.town || data.address?.village || data.address?.county;
                    if(city) {
                        document.getElementById("prayerTimesGridContainer").innerHTML = `<div class="prayer-grid" id="prayerTimesGrid"></div>`;
                        updateCityAndRender(city);
                    } else {
                        document.getElementById("prayerTimesGridContainer").innerHTML = `<div class="prayer-grid-skeleton">${Array(6).fill('<div class="skeleton-card skeleton"></div>').join('')}</div>`;
                        document.getElementById("locationStatus").innerHTML = "⚠️ Could not detect city. Please search manually.";
                        document.getElementById("cityNameDisplay").innerText = "--";
                    }
                } catch(e) {
                    document.getElementById("prayerTimesGridContainer").innerHTML = `<div class="prayer-grid-skeleton">${Array(6).fill('<div class="skeleton-card skeleton"></div>').join('')}</div>`;
                    document.getElementById("locationStatus").innerHTML = "⚠️ Location error. Please search manually.";
                }
            },
            (error) => {
                console.log("Geolocation error:", error);
                document.getElementById("prayerTimesGridContainer").innerHTML = `<div class="prayer-grid-skeleton">${Array(6).fill('<div class="skeleton-card skeleton"></div>').join('')}</div>`;
                if(error.code === 1) {
                    document.getElementById("locationStatus").innerHTML = "📍 Location denied. Please search manually or click 'Use My Location' to allow.";
                } else {
                    document.getElementById("locationStatus").innerHTML = "⚠️ Could not get location. Please search manually.";
                }
                document.getElementById("cityNameDisplay").innerText = "--";
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }
    
    async function fetchSuggestions(query, box, inputEl) {
        if(query.length<2) { box.style.display="none"; return; }
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=5&featureclass=city`);
            const data = await res.json();
            if(data.length) {
                box.innerHTML = data.map(p => `<div class="suggestion-item" data-suggest="${p.display_name.split(',')[0]}">${p.display_name.split(',')[0]}, ${p.address?.country || ''}</div>`).join('');
                box.style.display="block";
                box.querySelectorAll(".suggestion-item").forEach(el => el.addEventListener("click", () => { redirectToCityPage(el.dataset.suggest); }));
            } else box.style.display="none";
        } catch(e) { box.style.display="none"; }
    }
    const locInput = document.getElementById("locationInput"), suggestBox = document.getElementById("suggestionsBox");
    let timer; locInput.addEventListener("input", (e) => { clearTimeout(timer); timer = setTimeout(() => fetchSuggestions(e.target.value, suggestBox, locInput), 400); });
    document.getElementById("searchBtn").onclick = () => { if(locInput.value.trim()) redirectToCityPage(locInput.value.trim()); };
    document.getElementById("liveLocationBtn").onclick = autoGetUserLocation;
    const modal = document.getElementById("mobileSearchModal"), modalInput = document.getElementById("modalLocationInput"), modalSuggest = document.getElementById("modalSuggestionsBox");
    document.querySelectorAll(".nav-icon[data-nav='search']").forEach(btn => btn.addEventListener("click", () => { modal.style.display = "flex"; modalInput.focus(); }));
    document.getElementById("closeModalBtn").onclick = () => { modal.style.display = "none"; };
    document.getElementById("modalSearchBtn").onclick = () => { if(modalInput.value.trim()) redirectToCityPage(modalInput.value.trim()); };
    document.getElementById("modalLiveBtn").onclick = () => { autoGetUserLocation(); modal.style.display = "none"; };
    let mTimer; modalInput.addEventListener("input", (e) => { clearTimeout(mTimer); mTimer = setTimeout(() => fetchSuggestions(e.target.value, modalSuggest, modalInput), 400); });
    const worldCities = ["New York","London","Mecca","Karachi","Jakarta","Istanbul","Cairo","Riyadh","Dubai","Medina"];
    document.getElementById("worldCitiesList").innerHTML = worldCities.map(c => `<span class="city-quick" data-city="${c}">${c}</span>`).join('');
    const popCities = ["Mecca","Medina","Dubai","London","Karachi","Istanbul","Cairo","Riyadh"];
    document.getElementById("sidebarCityList").innerHTML = popCities.map(c => `<div class="city-link" data-city="${c}">${c}</div>`).join('');
    document.querySelectorAll(".city-quick, .city-link").forEach(el => el.addEventListener("click", (e) => { redirectToCityPage(el.dataset.city); }));
    let alarmEnabled = false, notifiedPrayers = {}, audio = null, alarmInterval = null;
    function initAudio() { if(!audio) { audio = new Audio('https://www.islamcan.com/audio/adhan/azan1.mp3'); audio.preload = 'auto'; } }
    function requestNotificationPermission() { if(Notification.permission !== 'granted') Notification.requestPermission(); return Notification.permission === 'granted'; }
    function showAlarmBanner(title, message, type) { const banner = document.getElementById("alarmBanner"); if(banner) banner.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show"><strong>${title}</strong> ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`; setTimeout(()=> banner.innerHTML="", 8000); }
    function playAdhan() { if(audio) { audio.currentTime=0; audio.play().catch(e=>console.log); } }
    function showPrayerAlarm(name, time) { playAdhan(); if(Notification.permission==='granted') new Notification(`🕌 ${name} Prayer Time`, {body:`${name} starts in 1 minute at ${time}`}); showAlarmBanner(`🕌 ${name} in 1 minute!`, `Get ready for ${name} at ${time}`, "warning"); }
    function checkAlarms() { if(!alarmEnabled || !currentCity) return; const prayers = getPrayers(currentCity); const order = ["Fajr","Dhuhr","Asr","Maghrib","Isha"]; const now = new Date(); const currentMin = now.getHours()*60+now.getMinutes(); const today = new Date().toDateString(); order.forEach(p => { let [h,m,mod] = prayers[p].split(/:| /); let hour = parseInt(h); if(mod==="PM" && hour!==12) hour+=12; if(mod==="AM" && hour===12) hour=0; let prayerMin = hour*60+parseInt(m); if(currentMin === prayerMin-1 && now.getSeconds()<5) { if(!notifiedPrayers[today]) notifiedPrayers[today]=[]; if(!notifiedPrayers[today].includes(p)) { showPrayerAlarm(p, prayers[p]); notifiedPrayers[today].push(p); } } }); }
    const toggleBtn = document.getElementById("notificationToggle");
    if(toggleBtn) toggleBtn.addEventListener("click", () => { if(!alarmEnabled) { requestNotificationPermission(); initAudio(); alarmEnabled=true; toggleBtn.classList.add("active"); showAlarmBanner("Alarms enabled","You'll be notified 1 min before prayer","success"); if(alarmInterval) clearInterval(alarmInterval); alarmInterval = setInterval(checkAlarms,1000); } else { alarmEnabled=false; toggleBtn.classList.remove("active"); showAlarmBanner("Alarms disabled","","info"); if(alarmInterval) clearInterval(alarmInterval); } });
    function startClock() { setInterval(() => { document.getElementById("liveClock").innerText = new Date().toLocaleTimeString('en-US', { hour12: true }); }, 1000); }
    async function fetchHijri() { try { let r=await fetch('https://api.aladhan.com/v1/gToH?date='+new Date().toISOString().slice(0,10)); let d=await r.json(); if(d.data) document.getElementById("hijriDateDisplay").innerHTML = `${d.data.hijri.day} ${d.data.hijri.month.en} ${d.data.hijri.year} AH`; } catch(e) {} }
    document.querySelectorAll(".nav-icon[data-nav='home']").forEach(btn => btn.addEventListener("click", () => window.scrollTo({top:0})));
    document.querySelectorAll(".nav-icon[data-nav='qibla']").forEach(btn => btn.addEventListener("click", () => window.location.href="/qibla-direction"));
    document.querySelectorAll(".nav-icon[data-nav='zakat']").forEach(btn => btn.addEventListener("click", () => window.location.href="/Tasbeeh-counter"));
    const mobileToggle = document.getElementById("mobileMenuToggle"), navLinks = document.getElementById("navLinks"), overlay = document.getElementById("menuOverlay");
    if(mobileToggle) mobileToggle.onclick = () => { navLinks.classList.toggle("open"); overlay.classList.toggle("active"); mobileToggle.innerHTML = navLinks.classList.contains("open") ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>'; };
    if(overlay) overlay.onclick = () => { navLinks.classList.remove("open"); overlay.classList.remove("active"); mobileToggle.innerHTML = '<i class="fas fa-bars"></i>'; };
    
    startClock(); fetchHijri();
    // Auto trigger location permission popup on page load
    autoGetUserLocation();
</script>
</body>
</html>
