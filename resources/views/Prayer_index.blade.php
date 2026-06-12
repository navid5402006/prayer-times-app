<!-- header include -->
@section('title', translate('Islamic Prayer Times | Accurate Islamic Salah Times Near You'))
@section('description', translate('Accurate Islamic prayer times (Salah times) for your location with beautiful Islamic design and features'))
@section('keywords', translate('next prayer times, salah times, islamic prayer, fajr prayer time, dhuhr prayer time, asr prayer time, maghrib prayer time, isha prayer time, muslim, islam'))
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@include('header')


    <!-- Bootstrap 5 CSS + Icons + Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --primary: #0f5c6b;
            --primary-soft: #208b7e;
            --primary-light: #e0f2f0;
            --accent: #f4a261;
            --accent-soft: #fef3e2;
            --bg: #fafbfc;
            --white: #ffffff;
            --text-dark: #1e2a3e;
            --text-muted: #6b7a8a;
            --shadow-sm: 0 10px 30px -12px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 20px 35px -12px rgba(0, 0, 0, 0.1);
            --radius-xl: 32px;
            --radius-lg: 24px;
            --radius-md: 18px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            line-height: 1.5;
        }
        
        /* Hero Section - Smooth Gradient */
        .hero {
            background: linear-gradient(135deg, #0f5c6b 0%, #1a7a6e 50%, #0f5c6b 100%);
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
        }
        
        .hero::before {
            content: "☾";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            font-size: 22rem;
            opacity: 0.04;
            bottom: -80px;
            right: -40px;
            color: white;
            transform: rotate(-15deg);
        }
        
        .hero::after {
            content: "★";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            font-size: 12rem;
            opacity: 0.04;
            top: -30px;
            left: -30px;
            color: white;
        }
        
        /* Current Time Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .time-display {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }
        
        /* Next Prayer Banner */
        .next-prayer-card {
            background: white;
            border-radius: 60px;
            padding: 1rem 1.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
            color:black;
        }
        
        .next-prayer-card.urgent {
            background: #fff1e0;
            border-left: 5px solid var(--accent);
        }
        
        .countdown-badge {
            background: var(--accent);
            color: white;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Search Card */
        .search-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-md);
        }
        
        /* Autocomplete */
        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            z-index: 1000;
            max-height: 280px;
            overflow-y: auto;
            margin-top: 4px;
        }
        
        .autocomplete-item {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s;
        }
        
        .autocomplete-item:hover {
            background: var(--primary-light);
        }
        
        /* Prayer Grid - Modern Cards */
        .prayer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .prayer-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem 1rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        
        .prayer-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }
        
        .prayer-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-light);
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            font-size: 1.8rem;
            color: var(--primary);
            transition: transform 0.2s;
        }
        
        .prayer-card:hover .prayer-icon {
            transform: scale(1.05);
        }
        
        .prayer-name {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
            color: var(--text-dark);
        }
        
        .prayer-time {
            font-size: 1.7rem;
            font-weight: 700;
            font-family: monospace;
            letter-spacing: 1px;
            color: var(--primary);
            margin: 0.5rem 0;
        }
        
        .iqamah-badge {
            font-size: 0.75rem;
            background: #f1f5f9;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 30px;
            color: #475569;
        }
        
        .highlight-prayer {
            background: linear-gradient(145deg, #e8f7f4, white);
            border: 2px solid var(--primary-soft);
            transform: scale(1.02);
        }
        
        /* City Tags */
        .city-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 20px;
            border-radius: 40px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
            margin: 0 8px 12px 0;
        }
        
        .city-tag:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Popular City Card */
        .city-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 1rem 1.2rem;
            transition: all 0.2s;
            border: 1px solid #eef2f6;
        }
        
        .city-card:hover {
            border-color: var(--primary-soft);
            background: var(--primary-light);
            transform: translateY(-3px);
        }
        
        /* Section Titles */
        .section-title {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
            color: var(--text-dark);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: var(--accent);
            border-radius: 3px;
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            height: 100%;
            text-align: center;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-soft);
            transform: translateY(-2px);
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .prayer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
            .prayer-time {
                font-size: 1.3rem;
            }
            .prayer-name {
                font-size: 1rem;
            }
            .prayer-icon {
                width: 50px;
                height: 50px;
                font-size: 1.4rem;
            }
            .time-display {
                font-size: 1.8rem;
                color: white !important;
            }
            .section-title {
                font-size: 1.5rem;
            }
            .next-prayer-card {
                flex-direction: column;
                text-align: center;
            }
        }
        
        footer {
            background: #0a2e2b;
            color: #cbd5e1;
        }
        
        .alert {
            border-radius: 20px;
        }
        
        .islamic-pattern {
            background: linear-gradient(to bottom, white, #fef8f0);
        }
    </style>
</head>
<body>

<div id="alarmBanner" class="container mt-3"></div>
<div id="app" style="min-height: 600px;"></div>

<!-- SEO Content -->
<section class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="text-center mb-5">
        <h1 class="fw-bold" style="color: var(--primary);">Islamic Prayer Times for Your Current Location</h1>
        <p class="text-muted">Get accurate Fajr, Dhuhr, Asr, Maghrib, and Isha timings based on where you are right now. Never miss your Salah with our reliable prayer time calculator.</p>
      </div>

      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h2 class="h4 mb-3" style="color: var(--primary);">Why Accurate Prayer Times Matter</h2>
          <p>Prayer times vary by location due to the sun's position relative to your city. Our service uses your current location to provide precise Islamic prayer times (Salah times) so you can observe Fajr, Dhuhr, Asr, Maghrib, and Isha at the correct moments. Whether at home or traveling, get reliable timings customized for your exact coordinates.</p>
        </div>
      </div>
      
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h2 class="h4 mb-3" style="color: var(--primary);">Trusted Calculation Methods</h2>
          <p>We use the Muslim World League (MWL) method, one of the most widely accepted standards for calculating prayer times worldwide. Our system adjusts for latitude, longitude, and seasonal variations to ensure you always have accurate Salah timings for your current city.</p>
        </div>
      </div>
      
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h2 class="h4 mb-3" style="color: var(--primary);">Frequently Asked Questions</h2>
          <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="faq1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">How do I get prayer times for my current location?</button>
              </h2>
              <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Simply allow location access when prompted, and our tool will automatically detect your city and display accurate prayer times. You can also search for any city manually.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">What is Fajr prayer time?</button>
              </h2>
              <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Fajr prayer time begins at dawn and ends at sunrise. It is the first prayer of the day.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="faq3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">Can I get prayer times for other cities?</button>
              </h2>
              <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Yes, simply search any city name in the search box to get prayer times for that location. Your recent searches will be saved for quick access.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@include('footer')

<script>
// translation helper
function trans(key, replacements = {}) {
    const translations = {
        'Prayer Times in': "Prayer Times in",
        'Next Prayer': "Next Prayer",
        'Accurate Islamic Prayer Times': "Accurate Islamic Prayer Times",
        'Never miss your Salah with precise prayer times based on your location.': "Never miss your Salah with precise prayer times based on your location.",
        'Find Prayer Times': "Find Prayer Times",
        'City or Location': "City or Location",
        'Search e.g: Dubai, Riyadh, Lahore': "Search e.g: Dubai, Riyadh, Lahore",
        'Get Prayer Times': "Get Prayer Times",
        'Popular Cities Worldwide': "Popular Cities Worldwide",
        'Popular Cities in': "Popular Cities in",
        'Enable Alarms': "Enable Alarms",
        'Disable Alarms': "Disable Alarms",
        'Calculation Method: Muslim World League': "Calculation Method: Muslim World League"
    };
    let text = translations[key] || key;
    for (const [k, val] of Object.entries(replacements)) text = text.replace(`:${k}`, val);
    return text;
}
window.lang = "{{ $lang ?? '' }}";

// Alarm State
const alarmState = { enabled: false, notifiedPrayers: {}, audio: null, checkInterval: null };
let countdownInterval = null;

function initAudio() { if (!alarmState.audio) { try { alarmState.audio = new Audio('https://www.islamcan.com/audio/adhan/azan1.mp3'); alarmState.audio.preload = 'auto'; alarmState.audio.volume = 0.8; } catch(e) {} } }
async function requestNotificationPermission() { if (!('Notification' in window)) return false; if (Notification.permission === 'granted') return true; if (Notification.permission !== 'denied') { const permission = await Notification.requestPermission(); return permission === 'granted'; } return false; }
async function toggleNotifications() {
    initAudio();
    if (alarmState.enabled) {
        alarmState.enabled = false; alarmState.notifiedPrayers = {}; updateNotificationButton(); localStorage.setItem('prayerAlarmsEnabled', 'false');
        if (alarmState.audio) { alarmState.audio.pause(); alarmState.audio.currentTime = 0; }
        showAlarmBanner('Alarms disabled', 'Prayer alarms turned off', 'info');
    } else {
        const hasPermission = await requestNotificationPermission();
        if (hasPermission) { alarmState.enabled = true; alarmState.notifiedPrayers = {}; updateNotificationButton(); localStorage.setItem('prayerAlarmsEnabled', 'true'); showAlarmBanner('Alarms enabled', 'You will be notified 1 min before each prayer', 'success'); setTimeout(() => checkPrayerAlarms(), 1000); } 
        else showAlarmBanner('Permission denied', 'Allow notifications to enable alarms', 'warning');
    }
}
function updateNotificationButton() { document.querySelectorAll('#notificationToggle').forEach(btn => { if (alarmState.enabled) { btn.innerHTML = '<i class="fas fa-bell-slash me-2"></i> Disable Alarms'; btn.classList.remove('btn-primary-custom'); btn.classList.add('btn-outline-custom'); } else { btn.innerHTML = '<i class="fas fa-bell me-2"></i> Enable Alarms'; btn.classList.remove('btn-outline-custom'); btn.classList.add('btn-primary-custom'); } }); }
function showAlarmBanner(title, message, type) { const banner = document.getElementById('alarmBanner'); if(banner) { banner.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show"><strong>${title}</strong> ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`; setTimeout(()=>{ if(banner.innerHTML.includes(title)) banner.innerHTML=''; },8000); } }
function playAdhanSound() { try { if(alarmState.audio) { alarmState.audio.currentTime=0; alarmState.audio.play().catch(e=>{}); } } catch(e){} }
function showPrayerAlarm(prayerName, prayerTime) { playAdhanSound(); if('Notification' in window && Notification.permission === 'granted') new Notification(`🕌 ${prayerName} Prayer Time`, { body: `${prayerName} starts in 1 minute at ${formatPrayerTime(prayerTime)}`, icon: 'https://cdn-icons-png.flaticon.com/512/559/559277.png' }); showAlarmBanner(`🕌 ${prayerName} in 1 minute!`, `Get ready for ${prayerName} at ${formatPrayerTime(prayerTime)}`, 'warning'); }
function checkPrayerAlarms() { if(!alarmState.enabled || !state.prayerTimes) return; const now = new Date(); const currentTotal = now.getHours()*60 + now.getMinutes(); const { timings } = state.prayerTimes; const prayers = [{ name:'Fajr', time:timings.Fajr },{ name:'Dhuhr', time:timings.Dhuhr },{ name:'Asr', time:timings.Asr },{ name:'Maghrib', time:timings.Maghrib },{ name:'Isha', time:timings.Isha }]; prayers.forEach(prayer => { const [h,m] = prayer.time.split(':').map(Number); const prayerTotal = h*60+m; if(currentTotal === prayerTotal-1 && now.getSeconds()<5) { const today = new Date().toDateString(); if(!alarmState.notifiedPrayers[today]) alarmState.notifiedPrayers[today]=[]; if(!alarmState.notifiedPrayers[today].includes(prayer.name)) { showPrayerAlarm(prayer.name, prayer.time); alarmState.notifiedPrayers[today].push(prayer.name); localStorage.setItem('prayerNotifiedToday', JSON.stringify(alarmState.notifiedPrayers)); } } }); }
function initAlarms() { if(alarmState.checkInterval) clearInterval(alarmState.checkInterval); alarmState.enabled = localStorage.getItem('prayerAlarmsEnabled') === 'true'; try { const saved = localStorage.getItem('prayerNotifiedToday'); if(saved) alarmState.notifiedPrayers = JSON.parse(saved); } catch(e){} initAudio(); updateNotificationButton(); document.querySelectorAll('#notificationToggle').forEach(btn => btn.removeEventListener('click', toggleNotifications)); document.querySelectorAll('#notificationToggle').forEach(btn => btn.addEventListener('click', toggleNotifications)); alarmState.checkInterval = setInterval(checkPrayerAlarms, 1000); }

// Global State
const state = { currentLocation: null, prayerTimes: null, timer: null, popularCities: [], recentSearches: [] };
const majorCitiesDatabase = [{ name:'Mecca', country:'Saudi Arabia'},{ name:'Medina', country:'Saudi Arabia'},{ name:'Dubai', country:'UAE'},{ name:'Cairo', country:'Egypt'},{ name:'Istanbul', country:'Turkey'},{ name:'Karachi', country:'Pakistan'},{ name:'London', country:'UK'},{ name:'New York', country:'USA'},{ name:'Kuala Lumpur', country:'Malaysia'},{ name:'Jakarta', country:'Indonesia'}];
const countryCitiesDatabase = { 'Saudi Arabia':['Mecca','Medina','Riyadh'], 'Pakistan':['Karachi','Lahore','Islamabad'], 'Egypt':['Cairo','Alexandria'], 'Turkey':['Istanbul','Ankara'], 'United States':['New York','Los Angeles','Chicago'] };

document.addEventListener('DOMContentLoaded', () => { 
    const path = window.location.pathname;
    const basePath = path.replace(/^\/[a-z]{2}(-[a-zA-Z]{2})?/, '');
    if (basePath === '/' || basePath === '') loadHomePage();
    else if (basePath.startsWith('/prayer-times-in-')) { const city = basePath.split('/prayer-times-in-')[1].replace(/-/g, ' '); loadCityPage(city); }
    else loadHomePage();
});

async function loadHomePage() { document.getElementById('app').innerHTML = templates.home; initHomePage(); }
async function loadCityPage(city) { document.getElementById('app').innerHTML = templates.city; await fetchPrayerTimes(city); initCityPage(city); storeSearch(city); }

async function initHomePage() {
    initAlarms();
    function updateTime() { const el = document.getElementById('currentTime'); if(el) el.textContent = new Date().toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true }); }
    updateTime(); if(state.timer) clearInterval(state.timer); state.timer = setInterval(updateTime,1000);
    if (navigator.geolocation) navigator.geolocation.getCurrentPosition(async pos => await getLocationFromCoordinates(pos.coords.latitude, pos.coords.longitude), async () => await getLocationFromIP(), { timeout:10000 });
    else await getLocationFromIP();
    const searchForm = document.getElementById('searchForm');
    if(searchForm) searchForm.addEventListener('submit', (e) => { e.preventDefault(); const city = document.getElementById('locationInput').value.trim(); if(city) window.location.href = `/${window.lang ? window.lang+'/' : ''}prayer-times-in-${city.toLowerCase().replace(/ /g,'-')}`; });
    initAutocomplete();
}

async function getLocationFromCoordinates(lat, lon) {
    try { const res = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=en`); const data = await res.json(); const city = data.city || data.locality || 'Unknown'; const country = data.countryName || ''; if(city !== 'Unknown') { updateLocationUI(city, country); await fetchPrayerTimes(city, country); await loadPopularCities(country); await loadRecentSearches(); return; } } catch(e) {} await getLocationFromIP();
}
async function getLocationFromIP() { 
    try { const res = await fetch('https://ipapi.co/json/'); const data = await res.json(); if(data.city) { updateLocationUI(data.city, data.country_name); await fetchPrayerTimes(data.city, data.country_name); await loadPopularCities(data.country_name); await loadRecentSearches(); return; } } catch(e){} 
    updateLocationUI('Search City', ''); await loadPopularCities(); await loadRecentSearches(); 
}
function updateLocationUI(city, country) { 
    const locationText = document.getElementById('locationText'); 
    const locationShort = document.getElementById('locationTextShort');
    if(locationText) locationText.textContent = `${city}, ${country || ''}`; 
    if(locationShort) locationShort.textContent = city; 
    state.currentLocation = { city, country }; 
}
function initAutocomplete() {
    const input = document.getElementById('locationInput'); if(!input) return; let timer;
    input.addEventListener('input', (e) => { clearTimeout(timer); const val = e.target.value.trim(); const container = document.getElementById('autocompleteResults'); if(val.length<2) { if(container) container.innerHTML=''; return; } timer = setTimeout(() => { const local = majorCitiesDatabase.filter(c => c.name.toLowerCase().includes(val.toLowerCase())).slice(0,6); if(container) { if(local.length) container.innerHTML = local.map(item => `<div class="autocomplete-item" onclick="selectCity('${item.name}','${item.country}')"><i class="fas fa-city"></i><div><strong>${item.name}</strong><small>${item.country}</small></div></div>`).join(''); else container.innerHTML = '<div class="autocomplete-item p-3 text-muted">Type city name...</div>'; } }, 250); });
    document.addEventListener('click', (e) => { const container = document.getElementById('autocompleteResults'); if(container && !container.contains(e.target) && e.target !== input) container.innerHTML = ''; });
}
window.selectCity = function(city, country) { const input = document.getElementById('locationInput'); if(input) input.value = city; const container = document.getElementById('autocompleteResults'); if(container) container.innerHTML = ''; window.location.href = `/${window.lang ? window.lang+'/' : ''}prayer-times-in-${city.toLowerCase().replace(/ /g,'-')}`; };

async function fetchPrayerTimes(city, country='') {
    try { 
        const response = await fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=3`); 
        const data = await response.json(); 
        if(data.code === 200) { state.prayerTimes = data.data; displayPrayerTimesModern(); updateNextPrayerWithCountdown(new Date()); checkPrayerAlarms(); } 
        else { throw new Error('API error'); }
    } catch(error) { 
        const container = document.getElementById('prayerTimesContainer');
        if(container) container.innerHTML = '<div class="text-center py-5 text-danger">Unable to load prayer times. Please check your connection or search for a city.</div>';
    }
}

function formatPrayerTime(timeString) { if(!timeString) return '--:-- --'; const [hours, minutes] = timeString.split(':'); const hourNum = parseInt(hours); const ampm = hourNum >=12 ? 'PM' : 'AM'; const hour12 = hourNum%12 || 12; return `${hour12}:${minutes} ${ampm}`; }
function calculateIqamah(timeString, minutesToAdd) { if(!timeString) return '--:-- --'; const [h,m] = timeString.split(':').map(Number); let total = h*60+m+minutesToAdd; if(total>=1440) total-=1440; const ih = Math.floor(total/60); const im = total%60; const ampm2 = ih>=12?'PM':'AM'; const h12 = ih%12||12; return `${h12}:${im.toString().padStart(2,'0')} ${ampm2}`; }

function displayPrayerTimesModern() {
    if(!state.prayerTimes) return;
    const { timings, date } = state.prayerTimes;
    const cityName = state.currentLocation?.city || 'Your City';
    const titleEl = document.getElementById('prayerTimesTitle');
    const currentCityEl = document.getElementById('currentCity');
    if(titleEl) titleEl.innerHTML = `${trans('Prayer Times in')} ${cityName}`;
    if(currentCityEl) currentCityEl.innerText = cityName;
    const dateEl = document.getElementById('prayerDate');
    if(dateEl && date.readable) dateEl.innerText = date.readable;
    
    const prayers = [
        { name:'Fajr', icon:'fas fa-cloud-moon', time: timings.Fajr, iqamahAdd:15 },
        { name:'Sunrise', icon:'fas fa-sunrise', time: timings.Sunrise, iqamahAdd:0, noIqamah:true },
        { name:'Dhuhr', icon:'fas fa-sun', time: timings.Dhuhr, iqamahAdd:10 },
        { name:'Asr', icon:'fas fa-cloud-sun', time: timings.Asr, iqamahAdd:10 },
        { name:'Maghrib', icon:'fas fa-moon', time: timings.Maghrib, iqamahAdd:5 },
        { name:'Isha', icon:'fas fa-star-and-crescent', time: timings.Isha, iqamahAdd:15 }
    ];
    const now = new Date(); const currentMin = now.getHours()*60+now.getMinutes();
    let activeId = null;
    for(let i=prayers.length-1; i>=0; i--) { 
        if(prayers[i].time) {
            const [h,mi]=prayers[i].time.split(':').map(Number);
            if(!isNaN(h) && !isNaN(mi) && currentMin >= h*60+mi) { activeId = prayers[i].name; break; }
        }
    }
    if(!activeId) activeId = 'Isha';
    
    const container = document.getElementById('prayerTimesContainer');
    if(!container) return;
    container.innerHTML = `<div class="prayer-grid" id="prayerGridDynamic"></div>`;
    const grid = document.getElementById('prayerGridDynamic');
    prayers.forEach(p => {
        if(!p.time) return;
        const isActive = (p.name === activeId && !p.noIqamah);
        const cardDiv = document.createElement('div');
        cardDiv.className = `prayer-card ${isActive ? 'highlight-prayer' : ''}`;
        cardDiv.innerHTML = `
            <div class="prayer-icon"><i class="${p.icon}"></i></div>
            <div class="prayer-name">${p.name}</div>
            <div class="prayer-time">${formatPrayerTime(p.time)}</div>
            ${!p.noIqamah ? `<div class="iqamah-badge">🕌 Iqamah: ${calculateIqamah(p.time, p.iqamahAdd)}</div>` : '<div class="iqamah-badge sunrise-badge">🌅 Start of Dawn</div>'}
        `;
        grid.appendChild(cardDiv);
    });
}

function updateNextPrayerWithCountdown(now) {
    if(!state.prayerTimes) return;
    const { timings } = state.prayerTimes;
    const currentTotal = now.getHours()*60 + now.getMinutes();
    const prayersList = ['Fajr','Dhuhr','Asr','Maghrib','Isha'].map(p => { 
        const [h,m] = (timings[p] || '00:00').split(':').map(Number); 
        return { name:p, minutes:h*60+m, display:formatPrayerTime(timings[p]) }; 
    });
    let next = prayersList.find(p => p.minutes > currentTotal);
    if(!next) next = { name:'Fajr (tomorrow)', minutes: prayersList[0].minutes + 1440, display:formatPrayerTime(timings.Fajr) };
    
    const banner = document.getElementById('nextPrayerBanner');
    const textSpan = document.getElementById('nextPrayerText');
    
    if(banner && textSpan) {
        if(countdownInterval) clearInterval(countdownInterval);
        function updateCountdown() {
            const currentNow = new Date();
            const currentTotalNow = currentNow.getHours()*60 + currentNow.getMinutes() + (currentNow.getSeconds()/60);
            let targetMinutes = next.minutes;
            let diffMinutes = targetMinutes - currentTotalNow;
            if(diffMinutes < 0) diffMinutes += 1440;
            const hoursLeft = Math.floor(diffMinutes / 60);
            const minsLeft = Math.floor(diffMinutes % 60);
            const secsLeft = Math.floor((diffMinutes * 60) % 60);
            const countdownText = `${hoursLeft.toString().padStart(2,'0')}:${minsLeft.toString().padStart(2,'0')}:${secsLeft.toString().padStart(2,'0')}`;
            textSpan.innerHTML = `<i class="fas fa-bell"></i> ${trans('Next Prayer')}: <strong>${next.name}</strong> at ${next.display} <span class="countdown-badge"><i class="fas fa-hourglass-half"></i> ${countdownText}</span>`;
            if(diffMinutes <= 30 && diffMinutes > 0) banner.classList.add('urgent'); 
            else banner.classList.remove('urgent');
        }
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    }
}

async function loadPopularCities(country) {
    let cities = [];
    if(country && countryCitiesDatabase[country]) cities = countryCitiesDatabase[country].map(c => ({ city:c, country }));
    else cities = [{ city:'Mecca', country:'Saudi Arabia'},{ city:'Medina', country:'Saudi Arabia'},{ city:'Dubai', country:'UAE'},{ city:'Istanbul', country:'Turkey'},{ city:'Cairo', country:'Egypt'},{ city:'Karachi', country:'Pakistan'}];
    state.popularCities = cities;
    const container = document.getElementById('popularCitiesContainer'); 
    if(container) container.innerHTML = cities.map(c => `<div class="col-md-4 col-sm-6 mb-3"><a href="/${window.lang ? window.lang+'/' : ''}prayer-times-in-${c.city.toLowerCase().replace(/ /g,'-')}" class="text-decoration-none"><div class="city-card"><i class="fas fa-mosque me-2" style="color:var(--primary)"></i> <strong>${c.city}</strong> <small class="text-muted">${c.country}</small></div></a></div>`).join('');
}
async function loadRecentSearches() { try { const searches = JSON.parse(localStorage.getItem('prayerTimeSearches')||'[]'); state.recentSearches = searches.slice(-5).reverse(); const cont = document.getElementById('recentSearchesContainer'); if(cont && state.recentSearches.length) cont.innerHTML = state.recentSearches.map(s => `<a href="/${window.lang?window.lang+'/':''}prayer-times-in-${s.city.toLowerCase().replace(/ /g,'-')}" class="city-tag"><i class="fas fa-history me-1"></i> ${s.city}</a>`).join(''); } catch(e){} }
function storeSearch(city) { let searches = JSON.parse(localStorage.getItem('prayerTimeSearches')||'[]'); if(!searches.some(s=>s.city.toLowerCase()===city.toLowerCase())) { searches.push({ city, timestamp:Date.now() }); localStorage.setItem('prayerTimeSearches', JSON.stringify(searches)); } }
function initCityPage(city) { initAlarms(); document.title = `${city} Prayer Times | Accurate Islamic Salah Times`; const el = document.getElementById('currentCity'); if(el) el.innerText = city; displayPrayerTimesModern(); updateNextPrayerWithCountdown(new Date()); }

// Templates
const templates = {
    home: `<section class="hero text-white"><div class="container py-5"><div class="row align-items-center g-4"><div class="col-lg-6"><h1 class="display-4 fw-bold mb-4">  Prayer Times</h1><p class="lead mb-4 opacity-90">Never miss your Salah with precise prayer times based on your location.</p><div class="glass-card"><div class="d-flex align-items-center gap-3 mb-3"><i class="fas fa-clock fa-2x" style="color:var(--accent)"></i><div><div class="small opacity-75">CURRENT TIME in <span id="locationTextShort">Your Location</span></div><div class="time-display" id="currentTime">--:-- --</div></div></div><div><i class="fas fa-map-marker-alt me-2"></i><span id="locationText">Detecting your location...</span></div></div><div class="mt-4 next-prayer-card" id="nextPrayerBanner"><span id="nextPrayerText">Loading next prayer...</span></div><div class="mt-4"><h5 class="mb-3"><i class="fas fa-history me-2"></i> Recent Searches</h5><div id="recentSearchesContainer"></div></div></div><div class="col-lg-6"><div class="search-card"><h3 class="mb-4 text-center" style="color:var(--primary)"><i class="fas fa-search-location me-2"></i>Find Prayer Times</h3><form id="searchForm"><div class="mb-4 position-relative"><label class="form-label fw-bold">City or Location</label><input type="text" id="locationInput" class="form-control form-control-lg" placeholder="Search e.g: Dubai, Riyadh, Lahore" autocomplete="off"><div id="autocompleteResults" class="autocomplete-results"></div></div><button type="submit" class="btn-primary-custom btn-lg w-100"><i class="fas fa-search me-2"></i> Get Prayer Times</button></form></div></div></div></div></section><section class="section islamic-pattern py-5" id="currentPrayerTimes"><div class="container"><h2 class="section-title text-center" id="prayerTimesTitle">Prayer Times in <span id="currentCity">Your Location</span></h2><div id="prayerTimesContainer"><div class="text-center py-5"><div class="spinner-border text-primary"></div><p>Loading prayer times...</p></div></div></div></section><section class="section py-5"><div class="container"><h2 class="section-title text-center"><i class="fas fa-globe me-2"></i> Popular Cities Worldwide</h2><div class="row" id="popularCitiesContainer"></div></div></section><section class="section py-5 bg-white"><div class="container"><h2 class="section-title text-center">Our Features</h2><div class="row g-4"><div class="col-md-4"><div class="feature-card"><i class="fas fa-clock fa-2x mb-3" style="color:var(--accent)"></i><h4>Accurate Times</h4><p>Precise prayer times calculated using authentic Islamic methods for your exact location.</p></div></div><div class="col-md-4"><div class="feature-card"><i class="fas fa-compass fa-2x mb-3" style="color:var(--accent)"></i><h4>Qibla Direction</h4><p>Find the exact Qibla direction from your current location with our compass tool.</p></div></div><div class="col-md-4"><div class="feature-card"><i class="fas fa-bell fa-2x mb-3" style="color:var(--accent)"></i><h4>Prayer Alarms</h4><p>Get notified 1 minute before each prayer time with Adhan. Never miss your Salah!</p><button id="notificationToggle" class="btn-primary-custom mt-2"><i class="fas fa-bell me-2"></i> Enable Alarms</button></div></div></div></div></section>`,
    city: `<section class="hero text-white" style="min-height:40vh"><div class="container py-5"><div class="row"><div class="col-12"><button id="backButton" class="btn btn-light mb-4 rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i> Back to Home</button><h1 class="display-4 fw-bold mb-3" id="currentCity">City</h1><p class="lead" id="prayerDate"></p></div></div></div></section><section class="section py-5"><div class="container"><div class="row mb-4"><div class="col-12"><div class="next-prayer-card" id="nextPrayerBanner"><span id="nextPrayerText">Loading next prayer...</span></div></div></div><div id="prayerTimesContainer"></div><div class="row mt-5"><div class="col-md-6 mb-4"><div class="feature-card"><h4><i class="fas fa-info-circle me-2"></i> About Prayer Times</h4><p class="mt-3">Prayer times are calculated based on your location using the Muslim World League method.</p></div></div><div class="col-md-6 mb-4"><div class="feature-card"><h4><i class="fas fa-bell me-2"></i> Prayer Alarms</h4><p>Enable notifications to get alerts 1 minute before each prayer time with Adhan.</p><button id="notificationToggle" class="btn-primary-custom mt-2"><i class="fas fa-bell me-2"></i> Enable Alarms</button></div></div></div></div></section>`
};
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>