@section('title', "Today Ramadan Timings " . date('Y'))
@section('description',"Today Ramadan Timings " . date('Y'))
@section('keywords',"Today Ramadan Timings " . date('Y'))
@include('header')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Main Content -->
<div id="app">
    <!-- Hero Section -->
    <section class="hero text-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Today Ramadan Timings</h1>
                    <p class="lead mb-5">Find accurate Iftar and Sehri times for your location during the holy month of Ramadan.</p>
                    
                    <!-- Today's Highlight with Countdown & Alarm -->
                    <div class="today-highlight">
                        <div class="current-city mb-3" id="currentCityDisplay">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span id="locationText">Detecting your location...</span>
                        </div>
                        
                        <!-- Alarm Control Panel - Only Here -->
                        <div class="alarm-control-panel mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <button class="btn-alarm" id="btnSehriAlarm" data-prayer="sehri" title="Set Sehri Alarm">
                                        <i class="fas fa-bell"></i>
                                        <span class="ms-2">Sehri Alarm</span>
                                    </button>
                                    <button class="btn-alarm" id="btnIftarAlarm" data-prayer="iftar" title="Set Iftar Alarm">
                                        <i class="fas fa-bell"></i>
                                        <span class="ms-2">Iftar Alarm</span>
                                    </button>
                                </div>
                                <button id="stopAllAlarms" class="btn-stop-alarm" title="Stop All Alarms">
                                    <i class="fas fa-bell-slash"></i>
                                </button>
                            </div>
                            <div id="alarmStatusText" class="alarm-status-text mt-2">
                                <!-- Active alarm status will show here -->
                            </div>
                        </div>
                        
                        <!-- Current Time & Countdown -->
                        <div class="time-display-container">
                            <div class="current-time-box">
                                <div class="current-time-label">Current Time</div>
                                <div class="current-time" id="currentTime">--:--:-- --</div>
                            </div>
                            <div class="countdown-container">
                                <div class="countdown-label">Time Until</div>
                                <div class="countdown-timer" id="countdownTimer">--:--:--</div>
                                <div class="countdown-prayer" id="countdownPrayer">Iftar/Sehri</div>
                            </div>
                        </div>
                        
                        <!-- Today's Timings - Dynamic from API -->
                        <div class="today-timings-grid mt-4">
                            <div class="timing-card">
                                <div class="timing-icon">
                                    <i class="fas fa-moon"></i>
                                </div>
                                <div class="timing-details">
                                    <span class="timing-label">Sehri (Start)</span>
                                    <span class="timing-time" id="todaySehriStart">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timing-details">
                                    <span class="timing-label">Sehri (Ends)</span>
                                    <span class="timing-time" id="todaySehri">--:-- --</span>
                                </div>
                            </div>
                            <div class="timing-card">
                                <div class="timing-icon">
                                    <i class="fas fa-sun"></i>
                                </div>
                                <div class="timing-details">
                                    <span class="timing-label">Iftar Time</span>
                                    <span class="timing-time" id="todayIftar">--:-- --</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="search-card">
                        <h3 class="mb-4 text-center" style="color: var(--primary-color);">
                            <i class="fas fa-search-location me-2"></i> Find Ramadan Timings
                        </h3>
                        
                        <form id="searchForm">
                            <div class="mb-4 position-relative">
                                <label for="locationInput" class="form-label fw-bold">City or Location</label>
                                <input type="text" 
                                       id="locationInput"
                                       class="form-control form-control-lg" 
                                       placeholder="e.g. Dubai, Riyadh, Lahore" 
                                       autocomplete="off">
                                <div id="autocompleteResults" class="autocomplete-results"></div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i> Find Timings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ramadan Calendar Section -->
    <section class="ramadan-calendar-section">
        <div class="container">
            <div class="month-navigation">
                <button id="prevMonthBtn" class="month-btn">
                    <i class="fas fa-chevron-left me-1"></i> Previous
                </button>
                <h2 class="month-title" id="currentMonthTitle">Ramadan 1445 AH</h2>
                <button id="nextMonthBtn" class="month-btn">
                    Next <i class="fas fa-chevron-right ms-1"></i>
                </button>
            </div>
            
            <div class="ramadan-calendar" id="ramadanCalendar">
                <!-- Ramadan days will be dynamically added here -->
            </div>
        </div>
    </section>

    <!-- Dua Section -->
    <section class="dua-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="dua-card">
                        <div class="audio-player" data-audio="https://mehboob-e-elahi.com/Audio/Others/Ramadan-fasting-dua-Roza-rakhen-ki-dua-in-sehri.mp3">
                            <i class="fas fa-play"></i>
                            <audio preload="none"></audio>
                        </div>
                        <h3 class="dua-title">
                            <i class="fas fa-moon"></i> Sehri Dua
                        </h3>
                        <div class="dua-arabic arabic-font">
                            Wa bisawmi ghadin nawaitu min shahri Ramadan
                        </div>
                        <div class="dua-translation">
                            "I intend to keep the fast for tomorrow in the month of Ramadan"
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
                            <i class="fas fa-sun"></i> Iftar Dua
                        </h3>
                        <div class="dua-arabic arabic-font">
                            Allahumma inni laka sumtu wa ala rizqika aftartu
                        </div>
                        <div class="dua-translation">
                            "O Allah! I fasted for You and I break my fast with Your sustenance"
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ramadan Map Section -->
    <section class="section islamic-pattern">
        <div class="container">
            <h2 class="section-title text-center">Nearby Mosques</h2>
            <div class="map-container">
                <div class="loader">
                    <div class="spinner"></div>
                </div>
                <div id="ramadanMap"></div>
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
    <section class="section bg-white">
        <div class="container">
            <h2 class="section-title text-center">
                <i class="fas fa-map-marker-alt me-2"></i> Nearby Cities
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
                        <i class="fas fa-clock"></i>
                        <h4>Accurate Times</h4>
                        <p>Get precise Sehri and Iftar times for your location based on authentic calculation methods.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>Full Month Calendar</h4>
                        <p>View the complete Ramadan calendar with daily prayer times for the entire holy month.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fas fa-bell"></i>
                        <h4>Prayer Alerts</h4>
                        <p>Set reminders for Sehri and Iftar times to never miss these important moments.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('footer')

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ============ API CONFIGURATION ============
    const ALADHAN_API = 'https://api.aladhan.com/v1';
    const OVERPASS_API = 'https://overpass-api.de/api/interpreter';
    const NOMINATIM_API = 'https://nominatim.openstreetmap.org';
    let prayerTimings = null;
    let currentLocation = {
        city: 'Loading...',
        country: '',
        latitude: 0,
        longitude: 0
    };
    let audioPlayers = [];

    // ============ TIME FORMAT UTILITY ============
    function formatTo12Hour(time24) {
        if (!time24 || time24 === '--:--') return '--:-- --';
        const [hours, minutes] = time24.split(':');
        const h = parseInt(hours);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        return `${h12.toString().padStart(2, '0')}:${minutes} ${ampm}`;
    }

    function subtractMinutes(timeStr, minutes) {
        if (!timeStr) return '05:00';
        const [hours, mins] = timeStr.split(':').map(Number);
        const date = new Date();
        date.setHours(hours, mins - minutes, 0);
        return `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
    }

    // ============ FETCH PRAYER TIMES VIA COORDINATES ============
    async function fetchPrayerTimesByCoordinates(lat, lng) {
        try {
            const url = `${ALADHAN_API}/timings?latitude=${lat}&longitude=${lng}&method=2`;
            console.log('Fetching by coordinates:', url);
            
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.code === 200) {
                prayerTimings = {
                    fajr: data.data.timings.Fajr,
                    maghrib: data.data.timings.Maghrib,
                    imsak: data.data.timings.Imsak
                };
                
                updateTimingsDisplay();
                generateRamadanCalendar();
                return true;
            }
            return false;
        } catch (error) {
            console.error('Error fetching by coordinates:', error);
            return false;
        }
    }

    // ============ UPDATE TIMINGS DISPLAY ============
    function updateTimingsDisplay() {
        if (!prayerTimings) return;
        
        const sehriStartTime = prayerTimings.imsak || subtractMinutes(prayerTimings.fajr, 15);
        
        const sehriStartEl = document.getElementById('todaySehriStart');
        const sehriEndEl = document.getElementById('todaySehri');
        const iftarEl = document.getElementById('todayIftar');
        
        if (sehriStartEl) sehriStartEl.textContent = formatTo12Hour(sehriStartTime);
        if (sehriEndEl) sehriEndEl.textContent = formatTo12Hour(prayerTimings.fajr);
        if (iftarEl) iftarEl.textContent = formatTo12Hour(prayerTimings.maghrib);
    }

    // ============ CURRENT TIME DISPLAY ============
    class CurrentTimeDisplay {
        constructor() {
            this.startTimer();
        }

        startTimer() {
            setInterval(() => this.updateTime(), 1000);
        }

        updateTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const hours12 = hours % 12 || 12;
            
            const timeString = `${hours12.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} ${ampm}`;
            const element = document.getElementById('currentTime');
            if (element) element.textContent = timeString;
        }
    }

    // ============ COUNTDOWN TIMER ============
    class CountdownTimer {
        constructor() {
            this.timerInterval = null;
            this.startTimer();
        }

        startTimer() {
            this.timerInterval = setInterval(() => this.updateCountdown(), 1000);
        }

        updateCountdown() {
            if (!prayerTimings) return;
            
            const now = new Date();
            const today = now.toDateString();
            
            const sehriStartTime = new Date(`${today} ${prayerTimings.imsak || subtractMinutes(prayerTimings.fajr, 15)}`);
            const sehriEndTime = new Date(`${today} ${prayerTimings.fajr}`);
            const iftarTime = new Date(`${today} ${prayerTimings.maghrib}`);
            
            let nextPrayer = null;
            let nextPrayerName = '';
            
            if (now < sehriStartTime) {
                nextPrayer = sehriStartTime;
                nextPrayerName = 'Sehri Starts';
            } else if (now < sehriEndTime) {
                nextPrayer = sehriEndTime;
                nextPrayerName = 'Sehri Ends';
            } else if (now < iftarTime) {
                nextPrayer = iftarTime;
                nextPrayerName = 'Iftar Time';
            } else {
                const tomorrow = new Date(now);
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowSehriStart = new Date(`${tomorrow.toDateString()} ${prayerTimings.imsak || subtractMinutes(prayerTimings.fajr, 15)}`);
                nextPrayer = tomorrowSehriStart;
                nextPrayerName = 'Sehri Starts (Tomorrow)';
            }
            
            if (nextPrayer) {
                const diff = nextPrayer - now;
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                
                const timerElement = document.getElementById('countdownTimer');
                const prayerElement = document.getElementById('countdownPrayer');
                
                if (timerElement) timerElement.textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (prayerElement) prayerElement.textContent = nextPrayerName;
            }
        }
    }

    // ============ ALARM MANAGER - FIXED ============
    class AlarmManager {
        constructor() {
            this.activeAlarms = [];
            this.notificationPermission = false;
            this.currentAudio = null;
            this.init();
        }

        async init() {
            this.waitForElements();
            
            if ('Notification' in window) {
                this.notificationPermission = Notification.permission;
                if (this.notificationPermission !== 'granted') {
                    this.notificationPermission = await Notification.requestPermission();
                }
            }
            
            this.loadAlarms();
            this.updateAlarmStatus();
            
            // Check alarms every second
            setInterval(() => this.checkAlarms(), 1000);
            
            // Check for missed alarms every minute
            setInterval(() => this.checkMissedAlarms(), 60000);
            this.checkMissedAlarms();
        }

        waitForElements() {
            const checkElements = setInterval(() => {
                const sehriBtn = document.getElementById('btnSehriAlarm');
                const iftarBtn = document.getElementById('btnIftarAlarm');
                if (sehriBtn && iftarBtn) {
                    clearInterval(checkElements);
                    console.log('✅ DOM elements loaded');
                }
            }, 100);
        }

        checkMissedAlarms() {
            const scheduled = localStorage.getItem('scheduledAlarms');
            if (!scheduled) return;
            
            try {
                const alarms = JSON.parse(scheduled);
                const now = new Date();
                
                alarms.forEach(alarm => {
                    if (alarm.sent) return;
                    
                    const alarmTime = new Date(alarm.alarmTime);
                    if (alarmTime <= now && now - alarmTime < 300000) {
                        this.sendNotification(
                            `🌙 ${alarm.prayerType} Time Now`,
                            `${alarm.city}: ${alarm.time}`,
                            alarm.prayerType
                        );
                        alarm.sent = true;
                    }
                });
                
                localStorage.setItem('scheduledAlarms', JSON.stringify(alarms.filter(a => !a.sent)));
            } catch (e) {
                console.error('Error checking missed alarms:', e);
            }
        }

        setAlarm(prayerType, time24, city) {
            const alarmTime = new Date();
            const [hours, minutes] = time24.split(':');
            alarmTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            
            if (new Date() > alarmTime) {
                alarmTime.setDate(alarmTime.getDate() + 1);
            }
            
            const alarm = {
                id: Date.now(),
                prayerType,
                time: formatTo12Hour(time24),
                time24,
                alarmTime: alarmTime.toISOString(),
                city,
                active: true,
                triggered: false,
                sent: false
            };

            this.activeAlarms = this.activeAlarms.filter(a => a.prayerType !== prayerType);
            this.activeAlarms.push(alarm);
            
            this.saveAlarms();
            this.saveScheduled();
            this.updateButtonState(prayerType, true);
            this.updateAlarmStatus();
            
            this.sendNotification(
                `🔔 ${prayerType} Alarm Set`,
                `Alarm for ${formatTo12Hour(time24)}`,
                prayerType
            );
        }

        saveScheduled() {
            const scheduled = this.activeAlarms.map(a => ({
                prayerType: a.prayerType,
                time: a.time,
                city: a.city,
                alarmTime: a.alarmTime,
                sent: false
            }));
            localStorage.setItem('scheduledAlarms', JSON.stringify(scheduled));
        }

        cancelAlarm(prayerType) {
            this.activeAlarms = this.activeAlarms.filter(a => a.prayerType !== prayerType);
            this.saveAlarms();
            this.saveScheduled();
            this.updateButtonState(prayerType, false);
            this.updateAlarmStatus();
        }

        cancelAllAlarms() {
            this.activeAlarms = [];
            this.saveAlarms();
            localStorage.removeItem('scheduledAlarms');
            this.updateButtonState('sehri', false);
            this.updateButtonState('iftar', false);
            this.updateAlarmStatus();
            if (this.currentAudio) this.currentAudio.pause();
        }

        checkAlarms() {
            const now = new Date();
            
            this.activeAlarms.forEach(alarm => {
                if (!alarm.active || alarm.triggered) return;
                
                const alarmTime = new Date(alarm.alarmTime);
                if (now >= alarmTime && now - alarmTime < 1000) {
                    this.triggerAlarm(alarm);
                    alarm.triggered = true;
                    
                    setTimeout(() => {
                        alarm.triggered = false;
                        const next = new Date(alarm.alarmTime);
                        next.setDate(next.getDate() + 1);
                        alarm.alarmTime = next.toISOString();
                        this.saveAlarms();
                        this.saveScheduled();
                    }, 2000);
                }
            });
        }

        triggerAlarm(alarm) {
            const url = alarm.prayerType === 'sehri' 
                ? 'https://mehboob-e-elahi.com/Audio/Others/Ramadan-fasting-dua-Roza-rakhen-ki-dua-in-sehri.mp3'
                : 'https://www.nooresunnat.com/Audio/Others/Iftar%20Dua%20-%20Allahumma%20Laka%20Sumtu%20Wa%20Ala%20Rizqika%20Aftartu.mp3';
            
            if (this.currentAudio) this.currentAudio.pause();
            this.currentAudio = new Audio(url);
            this.currentAudio.volume = 0.8;
            this.currentAudio.play().catch(e => console.log('Audio error:', e));
            
            this.sendNotification(
                `🌙 ${alarm.prayerType} Time Now`,
                `${alarm.city}: ${alarm.time}`,
                alarm.prayerType
            );
            
            this.showToast(`🌙 ${alarm.prayerType} Time Now`, `${alarm.city}: ${alarm.time}`);
        }

        sendNotification(title, body, type) {
            this.showToast(title, body, type);
            
            if (this.notificationPermission === 'granted') {
                try {
                    new Notification(title, {
                        body,
                        icon: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234a90e2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>',
                        requireInteraction: true
                    });
                } catch (e) {}
            }
        }

        showToast(title, msg) {
            const toast = document.createElement('div');
            toast.className = 'alarm-toast';
            toast.innerHTML = `<strong>${title}</strong><br><small>${msg}</small>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        updateButtonState(prayerType, isActive) {
            const btn = document.getElementById(`btn${prayerType.charAt(0).toUpperCase() + prayerType.slice(1)}Alarm`);
            if (btn) {
                btn.classList.toggle('active', isActive);
                btn.innerHTML = `<i class="fas fa-bell"></i><span class="ms-2">${prayerType} Alarm ${isActive ? 'ON' : ''}</span>`;
            }
        }

        updateAlarmStatus() {
            const statusEl = document.getElementById('alarmStatusText');
            if (!statusEl || !prayerTimings) return;
            
            const sehri = this.activeAlarms.find(a => a.prayerType === 'sehri');
            const iftar = this.activeAlarms.find(a => a.prayerType === 'iftar');
            
            let status = '';
            if (sehri) status += `Sehri alarm: ${sehri.time}`;
            if (iftar) status += (status ? ' • ' : '') + `Iftar alarm: ${iftar.time}`;
            
            statusEl.textContent = status || 'No active alarms';
            statusEl.style.color = status ? '#4caf50' : 'rgba(255,255,255,0.7)';
        }

        saveAlarms() {
            localStorage.setItem('ramadanAlarms', JSON.stringify(this.activeAlarms));
        }

        loadAlarms() {
            const saved = localStorage.getItem('ramadanAlarms');
            if (saved) {
                try {
                    this.activeAlarms = JSON.parse(saved);
                    this.updateButtonState('sehri', this.activeAlarms.some(a => a.prayerType === 'sehri'));
                    this.updateButtonState('iftar', this.activeAlarms.some(a => a.prayerType === 'iftar'));
                    this.updateAlarmStatus();
                } catch (e) {}
            }
        }
    }

    // ============ SEARCH LOCATION AND REDIRECT ============
    async function searchLocation(city) {
        try {
            const loader = document.querySelector('.loader');
            if (loader) loader.style.display = 'block';
            
            const response = await fetch(`${NOMINATIM_API}/search?format=json&q=${encodeURIComponent(city)}&limit=1`);
            const data = await response.json();
            
            if (data.length > 0) {
                const result = data[0];
                const cityName = result.display_name.split(',')[0];
                
                // Redirect to the city-specific Ramadan page
                const citySlug = cityName.toLowerCase().replace(/ /g, '-');
                window.location.href = `/${citySlug}-ramadan-timings`;
            } else {
                alert('Location not found. Please try another city.');
            }
        } catch (error) {
            console.error('Error searching location:', error);
            alert('Error searching for location. Please try again.');
        } finally {
            const loader = document.querySelector('.loader');
            if (loader) loader.style.display = 'none';
        }
    }

    // ============ INITIALIZE AUTOCOMPLETE ============
    function initAutocomplete() {
        const input = document.getElementById('locationInput');
        if (!input) return;
        
        let timeoutId;
        
        input.addEventListener('input', function(e) {
            const value = e.target.value.trim();
            const resultsContainer = document.getElementById('autocompleteResults');
            
            if (!value || value.length < 2) {
                if (resultsContainer) resultsContainer.innerHTML = '';
                return;
            }
            
            // Clear previous timeout
            clearTimeout(timeoutId);
            
            // Set new timeout to debounce the API call
            timeoutId = setTimeout(async () => {
                try {
                    const response = await fetch(`${NOMINATIM_API}/search?format=json&q=${encodeURIComponent(value)}&limit=5&addressdetails=1`);
                    const data = await response.json();
                    
                    if (resultsContainer) {
                        if (data.length > 0) {
                            resultsContainer.innerHTML = data.map(item => {
                                const address = item.address || {};
                                const displayName = [
                                    address.road,
                                    address.neighbourhood,
                                    address.suburb,
                                    address.city,
                                    address.state,
                                    address.country
                                ].filter(Boolean).join(', ');
                                
                                return `
                                    <div class="autocomplete-item" onclick="selectAutocompleteItem('${item.display_name.replace(/'/g, "\\'")}')">
                                        <i class="fas fa-map-marker-alt me-2" style="color:rgb(0, 0, 0) !important;"></i>
                                        <div>
                                            <div class="fw-bold" style="color: #d4af37 !important;">${item.display_name.split(',')[0]}</div>
                                            <small class="text-muted">${displayName || item.display_name}</small>
                                        </div>
                                    </div>
                                `;
                            }).join('');
                        } else {
                            resultsContainer.innerHTML = '<div class="autocomplete-item p-3 text-muted">No matching cities found</div>';
                        }
                    }
                } catch (error) {
                    console.error('Error fetching city suggestions:', error);
                }
            }, 300); // 300ms debounce delay
        });
        
        // Close autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== input) {
                const resultsContainer = document.getElementById('autocompleteResults');
                if (resultsContainer) resultsContainer.innerHTML = '';
            }
        });
    }

    // ============ SELECT AUTOCOMPLETE ITEM ============
    function selectAutocompleteItem(displayName) {
        const input = document.getElementById('locationInput');
        if (input) input.value = displayName.split(',')[0];
        
        const resultsContainer = document.getElementById('autocompleteResults');
        if (resultsContainer) resultsContainer.innerHTML = '';
        
        // Trigger search
        searchLocation(displayName);
    }

    // ============ GENERATE RAMADAN CALENDAR ============
    function generateRamadanCalendar() {
        const calendarContainer = document.getElementById('ramadanCalendar');
        if (!calendarContainer || !prayerTimings) return;
        
        calendarContainer.innerHTML = '';
        
        const currentMonth = new Date().getMonth() + 1;
        const currentYear = new Date().getFullYear();
        const gregorianMonths = ['January', 'February', 'March', 'April', 'May', 'June', 
                               'July', 'August', 'September', 'October', 'November', 'December'];
        
        const monthTitle = document.getElementById('currentMonthTitle');
        if (monthTitle) {
            monthTitle.textContent = `${gregorianMonths[currentMonth - 1]} ${currentYear} / Ramadan 1445 AH`;
        }
        
        const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
        
        for (let i = 1; i <= daysInMonth; i++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'ramadan-day';
            
            dayElement.innerHTML = `
                <div class="ramadan-day-date">Day ${i}</div>
                <div class="ramadan-day-hijri">${i} Ramadan, 1445 AH</div>
                <div class="ramadan-day-times">
                    <div class="ramadan-day-time">
                        <span class="ramadan-day-time-label">Sehri Start</span>
                        <span class="ramadan-day-time-value">${formatTo12Hour(prayerTimings.imsak || subtractMinutes(prayerTimings.fajr, 15))}</span>
                    </div>
                    <div class="ramadan-day-time ramadan-day-sehri">
                        <span class="ramadan-day-time-label">Sehri Ends</span>
                        <span class="ramadan-day-time-value">${formatTo12Hour(prayerTimings.fajr)}</span>
                    </div>
                    <div class="ramadan-day-time ramadan-day-iftar">
                        <span class="ramadan-day-time-label">Iftar</span>
                        <span class="ramadan-day-time-value">${formatTo12Hour(prayerTimings.maghrib)}</span>
                    </div>
                </div>
            `;
            
            calendarContainer.appendChild(dayElement);
        }
    }

    // ============ GET CITY NAME FROM COORDINATES ============
    async function getCityFromCoordinates(lat, lng) {
        try {
            const response = await fetch(
                `${NOMINATIM_API}/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=en`
            );
            const data = await response.json();
            const address = data.address || {};
            let city = address.city || address.town || address.village || address.state || address.country || 'Your Location';
            city = city.split(' ')[0];
            return { city, country: address.country || '' };
        } catch (error) {
            return { city: 'Lahore', country: 'Pakistan' };
        }
    }

    // ============ NEARBY CITIES FUNCTION ============
    async function fetchNearbyCities(lat, lng) {
        const container = document.getElementById('nearbyCitiesContainer');
        if (!container) return;
        
        try {
            // Try to get country first
            const country = await getCountryFromCoordinates(lat, lng);
            
            // Overpass API query to find nearby cities
            const query = `
                [out:json];
                (
                    node["place"="city"](around:100000,${lat},${lng});
                    node["place"="town"](around:50000,${lat},${lng});
                );
                out body;
            `;
            
            const response = await fetch(OVERPASS_API, {
                method: 'POST',
                body: query
            });
            
            const data = await response.json();
            
            if (data.elements && data.elements.length > 0) {
                // Get unique cities
                const cities = [];
                const seen = new Set();
                
                data.elements.forEach(element => {
                    let cityName = element.tags?.['int_name'] || 
                                  element.tags?.['name:en'] || 
                                  element.tags?.name || 
                                  'Unknown';
                    
                    cityName = cityName.replace(/[^\x00-\x7F]/g, '').trim();
                    
                    if (!cityName || seen.has(cityName) || 
                        cityName.toLowerCase() === currentLocation.city.toLowerCase()) {
                        return;
                    }
                    
                    seen.add(cityName);
                    cities.push({
                        name: cityName,
                        lat: element.lat,
                        lon: element.lon,
                        distance: calculateDistance(lat, lng, element.lat, element.lon)
                    });
                });
                
                // Sort by distance
                cities.sort((a, b) => a.distance - b.distance);
                
                if (cities.length === 0) {
                    const fallbackCities = getFallbackCities(country);
                    displayFallbackCities(fallbackCities, country);
                } else {
                    // Display top 6 cities
                    container.innerHTML = cities.slice(0, 6).map(city => `
                        <div class="col-md-4 col-sm-6 mb-3">
                            <a href="/${city.name.toLowerCase().replace(/ /g, '-')}-ramadan-timings" class="text-decoration-none">
                                <div class="city-card p-3 border rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-city me-3" style="color: var(--primary-color);"></i>
                                        <div>
                                            <div class="fw-bold">${city.name}</div>
                                            <small class="text-muted">${city.distance.toFixed(1)} km away</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `).join('');
                }
            } else {
                const fallbackCities = getFallbackCities(country);
                displayFallbackCities(fallbackCities, country);
            }
        } catch (error) {
            console.error('Error fetching nearby cities:', error);
            const country = await getCountryFromCoordinates(lat, lng);
            const fallbackCities = getFallbackCities(country);
            displayFallbackCities(fallbackCities, country);
        }
    }

    // Helper function to display fallback cities
    function displayFallbackCities(cities, country) {
        const container = document.getElementById('nearbyCitiesContainer');
        container.innerHTML = cities.map(city => `
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="/${city.toLowerCase().replace(/ /g, '-')}-ramadan-timings" class="text-decoration-none">
                    <div class="city-card p-3 border rounded bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-city me-3" style="color: var(--primary-color);"></i>
                            <div>
                                <div class="fw-bold">${city}</div>
                                <small class="text-muted">${country}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `).join('');
    }

    // Helper function to get country from coordinates
    async function getCountryFromCoordinates(lat, lng) {
        try {
            const response = await fetch(
                `${NOMINATIM_API}/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=en`
            );
            const data = await response.json();
            return data.address?.country || 'Pakistan';
        } catch {
            return 'Pakistan';
        }
    }

    // Fallback cities by country
    function getFallbackCities(country) {
        const citiesByCountry = {
            'Pakistan': ['Lahore', 'Karachi', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan'],
            'India': ['Delhi', 'Mumbai', 'Kolkata', 'Chennai', 'Bangalore', 'Hyderabad'],
            'UAE': ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah'],
            'Saudi Arabia': ['Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam', 'Taif'],
            'United Kingdom': ['London', 'Birmingham', 'Manchester', 'Liverpool', 'Leeds', 'Glasgow'],
            'USA': ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia'],
            'Turkey': ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Antalya', 'Konya'],
            'Egypt': ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima', 'Port Said', 'Suez'],
            'Malaysia': ['Kuala Lumpur', 'George Town', 'Ipoh', 'Shah Alam', 'Petaling Jaya', 'Johor Bahru'],
            'Indonesia': ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar'],
            'Bangladesh': ['Dhaka', 'Chittagong', 'Khulna', 'Rajshahi', 'Sylhet', 'Barisal'],
            'Afghanistan': ['Kabul', 'Kandahar', 'Herat', 'Mazar-i-Sharif', 'Jalalabad', 'Kunduz']
        };
        
        return citiesByCountry[country] || citiesByCountry['Pakistan'];
    }

    // Calculate distance between two coordinates
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth's radius in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // ============ INITIALIZE AUDIO PLAYERS ============
    function initAudioPlayers() {
        const players = document.querySelectorAll('.audio-player');
        
        players.forEach(player => {
            const audioUrl = player.getAttribute('data-audio');
            const audio = player.querySelector('audio');
            const icon = player.querySelector('i');
            
            audio.src = audioUrl;
            
            player.addEventListener('click', function() {
                // Pause all other audio players
                audioPlayers.forEach(ap => {
                    if (ap !== audio) {
                        ap.pause();
                        ap.currentTime = 0;
                        ap.parentElement.classList.remove('playing');
                        ap.parentElement.querySelector('i').className = 'fas fa-play';
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
        });
    }

    // ============ MAP FUNCTIONS ============
    let map, userMarker;
    
    function initMap() {
        const loader = document.querySelector('.loader');
        if (loader) loader.style.display = 'block';
        
        map = L.map('ramadanMap', { center: [31.5204, 74.3587], zoom: 10, zoomControl: false });
        L.control.zoom({ position: 'topright' }).addTo(map);
        
        const baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        
        baseLayer.on('load', function() {
            if (loader) loader.style.display = 'none';
        });
    }

    function updateMap(lat, lng) {
        if (!map) return;
        
        if (userMarker && map.hasLayer(userMarker)) map.removeLayer(userMarker);
        
        userMarker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: '<div style="position:relative"><i class="fas fa-map-marker-alt" style="color: red; font-size: 28px;"></i><div class="pulse-marker"></div></div>',
                iconSize: [28, 28],
                className: 'user-marker'
            })
        }).addTo(map);
        
        userMarker.bindPopup(`
            <b>Your Location</b><br>
            ${currentLocation.city || 'Unknown City'}, ${currentLocation.country || 'Unknown Country'}<br>
            Lat: ${lat.toFixed(4)}°, Lng: ${lng.toFixed(4)}°
        `).openPopup();
        
        map.setView([lat, lng], 12);
        
        // Add nearby mosques (simulated)
        addNearbyMosques(lat, lng);
    }
    
    function addNearbyMosques(lat, lng) {
        map.eachLayer(layer => {
            if (layer instanceof L.Marker && layer !== userMarker) {
                map.removeLayer(layer);
            }
        });
        
        const mosqueNames = [
            "Masjid Al-Haram", "Masjid An-Nabawi", "Masjid Al-Aqsa", 
            "Masjid Sultan Ahmed", "Masjid Al-Fateh", "Masjid Putra",
            "Masjid Istiqlal", "Masjid Hassan II", "Masjid Badshahi", "Masjid Faisal"
        ];
        
        for (let i = 0; i < 5; i++) {
            const offsetLat = (Math.random() - 0.5) * 0.05;
            const offsetLng = (Math.random() - 0.5) * 0.05;
            
            const distance = calculateDistance(
                lat, lng,
                lat + offsetLat, lng + offsetLng
            );
            
            const mosqueName = mosqueNames[Math.floor(Math.random() * mosqueNames.length)];
            
            L.marker([lat + offsetLat, lng + offsetLng], {
                icon: L.divIcon({
                    html: '<i class="fas fa-mosque" style="color: var(--primary-color); font-size: 24px;"></i>',
                    iconSize: [24, 24],
                    className: 'mosque-marker'
                })
            }).addTo(map).bindPopup(`
                <b>${mosqueName}</b><br>
                Distance: ${distance.toFixed(1)} km<br>
                <small>${(lat + offsetLat).toFixed(4)}°, ${(lng + offsetLng).toFixed(4)}°</small>
            `);
        }
    }

    // ============ INIT ============
    const alarmManager = new AlarmManager();
    new CurrentTimeDisplay();
    new CountdownTimer();
    window.alarmManager = alarmManager;
    window.selectAutocompleteItem = selectAutocompleteItem;

    document.addEventListener('DOMContentLoaded', async () => {
        initMap();
        initAutocomplete();
        initAudioPlayers();
        
        // Alarm buttons
        document.getElementById('btnSehriAlarm').onclick = () => {
            if (!prayerTimings) return alert('Loading timings...');
            const existing = alarmManager.activeAlarms.find(a => a.prayerType === 'sehri');
            existing ? alarmManager.cancelAlarm('sehri') : alarmManager.setAlarm('sehri', prayerTimings.imsak, currentLocation.city);
        };
        
        document.getElementById('btnIftarAlarm').onclick = () => {
            if (!prayerTimings) return alert('Loading timings...');
            const existing = alarmManager.activeAlarms.find(a => a.prayerType === 'iftar');
            existing ? alarmManager.cancelAlarm('iftar') : alarmManager.setAlarm('iftar', prayerTimings.maghrib, currentLocation.city);
        };
        
        document.getElementById('stopAllAlarms').onclick = () => alarmManager.cancelAllAlarms();
        
        // Month navigation
        document.getElementById('prevMonthBtn').onclick = () => generateRamadanCalendar();
        document.getElementById('nextMonthBtn').onclick = () => generateRamadanCalendar();
        
        // Search form
        document.getElementById('searchForm').onsubmit = (e) => {
            e.preventDefault();
            const city = document.getElementById('locationInput').value.trim();
            if (city) {
                searchLocation(city);
            }
        };
        
        // Get location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async (pos) => {
                    const { city, country } = await getCityFromCoordinates(pos.coords.latitude, pos.coords.longitude);
                    currentLocation = { city, country, latitude: pos.coords.latitude, longitude: pos.coords.longitude };
                    document.getElementById('locationText').textContent = `${city}, ${country}`;
                    document.getElementById('currentCityDisplay').innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>${city}, ${country}</span>`;
                    await fetchPrayerTimesByCoordinates(pos.coords.latitude, pos.coords.longitude);
                    await fetchNearbyCities(pos.coords.latitude, pos.coords.longitude);
                    updateMap(pos.coords.latitude, pos.coords.longitude);
                },
                async () => {
                    currentLocation = { city: 'Lahore', country: 'Pakistan', latitude: 31.5204, longitude: 74.3587 };
                    document.getElementById('locationText').textContent = 'Lahore, Pakistan';
                    document.getElementById('currentCityDisplay').innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>Lahore, Pakistan</span>`;
                    await fetchPrayerTimesByCoordinates(31.5204, 74.3587);
                    await fetchNearbyCities(31.5204, 74.3587);
                    updateMap(31.5204, 74.3587);
                }
            );
        } else {
            currentLocation = { city: 'Lahore', country: 'Pakistan', latitude: 31.5204, longitude: 74.3587 };
            document.getElementById('locationText').textContent = 'Lahore, Pakistan';
            document.getElementById('currentCityDisplay').innerHTML = `<i class="fas fa-map-marker-alt me-2"></i><span>Lahore, Pakistan</span>`;
            fetchPrayerTimesByCoordinates(31.5204, 74.3587);
            fetchNearbyCities(31.5204, 74.3587);
            updateMap(31.5204, 74.3587);
        }
    });
</script>

<style>
    /* Alarm System Styles */
    .alarm-control-panel { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; padding: 15px 20px; border: 1px solid rgba(255,255,255,0.2); }
    .btn-alarm { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 30px; padding: 8px 20px; cursor: pointer; transition: all 0.3s; }
    .btn-alarm:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }
    .btn-alarm.active { background: #dc3545; border-color: #dc3545; animation: pulse 2s infinite; }
    .btn-stop-alarm { background: rgba(220,53,69,0.3); border: 1px solid rgba(220,53,69,0.5); color: white; border-radius: 30px; padding: 8px 20px; cursor: pointer; }
    .alarm-status-text { font-size: 0.9rem; padding: 5px 10px; border-radius: 20px; background: rgba(0,0,0,0.2); text-align: center; }
    .time-display-container { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
    .current-time-box, .countdown-container { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 20px; padding: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.3); }
    .current-time, .countdown-timer { font-size: 1.8rem; font-weight: 700; font-family: monospace; color: white; text-shadow: 0 0 10px rgba(255,255,255,0.5); }
    .today-timings-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
    .timing-card { background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px; padding: 15px; display: flex; align-items: center; gap: 10px; border: 1px solid rgba(255,255,255,0.2); }
    .timing-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .alarm-toast { position: fixed; top: 20px; right: 20px; background: white; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding: 15px 20px; z-index: 9999; animation: slideIn 0.3s; max-width: 350px; border-left: 5px solid #4a90e2; }
    
    /* Autocomplete Styles */
    .autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        color: var(--primary-color) !important;
    }
    
    .autocomplete-item .fw-bold {
        color: #333 !important;
    }
    
    .autocomplete-item small {
        color: #666 !important;
    }
    
    /* City Card Styles */
    .city-card {
        transition: all 0.3s;
        background: white;
        border: 1px solid #eee;
    }
    
    .city-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: var(--primary-color);
    }
    
    /* Ramadan Calendar Styles */
    .ramadan-calendar {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .ramadan-day {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .ramadan-day:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .ramadan-day.active {
        border: 2px solid var(--primary-color);
        box-shadow: 0 0 20px rgba(74, 144, 226, 0.2);
    }
    
    .ramadan-day-date {
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .ramadan-day-hijri {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .ramadan-day-time {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .ramadan-day-time-label {
        font-size: 0.8rem;
        color: #666;
    }
    
    .ramadan-day-time-value {
        font-weight: bold;
    }
    
    .ramadan-day-sehri .ramadan-day-time-value {
        color: #4a90e2;
    }
    
    .ramadan-day-iftar .ramadan-day-time-value {
        color: #f39c12;
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220,53,69,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(220,53,69,0); }
        100% { box-shadow: 0 0 0 0; }
    }
    
    @media (max-width: 768px) {
        .time-display-container, .today-timings-grid {
            grid-template-columns: 1fr;
        }
        .alarm-control-panel .d-flex {
            flex-direction: column;
            gap: 10px;
        }
        .btn-alarm, .btn-stop-alarm {
            width: 100%;
        }
    }
</style>

</body>
</html>