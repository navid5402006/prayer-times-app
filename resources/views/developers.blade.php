@section('title', '1Prayer Times & Qibla Direction Widget - For Developers')
@section('description', 'Get embed code for accurate Prayer Times and Qibla Direction widgets. Simple, lightweight, and SEO-friendly. Perfect for Islamic websites and blogs.')
@section('keywords','prayer times widget, qibla direction widget, embed prayer times, islamic widgets, salah times embed')
@section('robot', 'noindex, nofollow')
@section('googlebot', 'noindex, nofollow')

@include('header')

<style>
    /* === CLEAN, MINIMAL, PROFESSIONAL === */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .dev-header {
        max-width: 1100px;
        margin: 0 auto 30px;
        padding: 0 20px;
    }

    .dev-header h1 {
        font-size: 2rem;
        color: #1e293b;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .dev-header p {
        color: #475569;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .features-grid {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .feature-tag {
        background: white;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.85rem;
        color: rgb(13 110 110);
        border: 1px solid #e2e8f0;
        font-weight: 500;
    }

    .widgets-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px 50px;
    }

    /* Tabs */
    .widget-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 15px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 10px 25px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        font-size: 1rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tab-btn.active {
        background: rgb(13 110 110 / 0.9) !important;
        color: white;
        border-color: rgb(13 110 110 / 0.9);
    }

    .tab-btn:hover {
        background: #f1f5f9;
    }

    .tab-btn.active:hover {
        background: rgb(13 110 110) !important;
    }

    .widget-content {
        display: none;
    }

    .widget-content.active {
        display: block;
    }

    /* Embed Wrapper */
    .embed-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* Preview Card */
    .preview-card {
        flex: 0 0 350px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eef2f6;
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    }

    .preview-header {
        padding: 16px 20px;
        background: rgb(13 110 110 / 0.05);
        border-bottom: 1px solid #eef2f6;
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-header i {
        color: rgb(13 110 110) !important;
        font-size: 1.2rem;
    }

    .preview-body {
        padding: 20px;
    }

    .city-select {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.95rem;
        color: #1e293b;
        background: white;
        cursor: pointer;
    }

    .city-select:focus {
        outline: none;
        border-color: rgb(13 110 110);
    }

    /* Prayer Times Table */
    .prayer-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .prayer-table tr {
        border-bottom: 1px solid #f0f3f7;
    }

    .prayer-table tr:last-child {
        border-bottom: none;
    }

    .prayer-table td {
        padding: 10px 0;
    }

    .prayer-table td:first-child {
        font-weight: 500;
        color: #334155;
    }

    .prayer-table td:last-child {
        font-family: monospace;
        color: rgb(13 110 110);
        text-align: right;
        font-weight: 600;
    }

    /* Quran Display */
    .surah-select, .ayah-select {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.95rem;
        color: #1e293b;
        background: white;
        cursor: pointer;
    }

    .surah-select:focus, .ayah-select:focus {
        outline: none;
        border-color: rgb(13 110 110);
    }

    .ayat-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        margin: 15px 0;
        border-right: 4px solid rgb(13 110 110);
        direction: rtl;
    }

    .ayat-arabic {
        font-size: 1.4rem;
        line-height: 2.2rem;
        font-family: 'Uthmanic', 'Traditional Arabic', serif;
        color: #0f172a;
        margin-bottom: 15px;
        font-weight: 500;
        word-break: break-word;
    }

    .ayat-translation {
        font-size: 0.95rem;
        color: #475569;
        line-height: 1.6;
        direction: ltr;
        text-align: left;
        padding-top: 10px;
        border-top: 1px dashed #d1d9e6;
    }

    .hadith-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        margin: 15px 0;
        border-left: 4px solid #f59e0b;
        direction: rtl;
    }

    .hadith-arabic {
        font-size: 1.3rem;
        line-height: 2rem;
        font-family: 'Uthmanic', 'Traditional Arabic', serif;
        color: #0f172a;
        margin-bottom: 15px;
        font-weight: 500;
        word-break: break-word;
    }

    .hadith-translation {
        font-size: 0.95rem;
        color: #475569;
        line-height: 1.6;
        direction: ltr;
        text-align: left;
        padding-top: 10px;
        border-top: 1px dashed #d1d9e6;
    }

    .hadith-reference {
        font-size: 0.8rem;
        color: #64748b;
        text-align: right;
        padding-top: 8px;
        border-top: 1px solid #e2e8f0;
        direction: ltr;
    }

    .refresh-btn {
        background: white;
        border: 1px solid #e2e8f0;
        color: rgb(13 110 110);
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .refresh-btn:hover {
        background: rgb(13 110 110 / 0.05);
        border-color: rgb(13 110 110);
    }

    .source-link {
        color: rgb(13 110 110);
        text-decoration: none;
        font-size: 0.75rem;
        display: inline-block;
        margin-top: 5px;
    }

    .source-link:hover {
        text-decoration: underline;
    }

    .content-type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .badge-quran {
        background: rgb(13 110 110 / 0.1);
        color: rgb(13 110 110);
    }

    .badge-hadith {
        background: #f59e0b20;
        color: #f59e0b;
    }

    /* Qibla Compass */
    .compass-container {
        position: relative;
        width: 160px;
        height: 160px;
        margin: 0 auto 20px;
    }

    .compass-circle {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #f8fafc;
        border: 3px solid rgb(13 110 110 / 0.3);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .direction-label {
        position: absolute;
        font-size: 0.7rem;
        font-weight: 600;
        color: rgb(13 110 110);
    }

    .kaaba-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: rgb(13 110 110);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 2px 10px rgba(13,110,110,0.3);
        z-index: 2;
    }

    .qibla-needle {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 4px;
        height: 70px;
        background: #ef4444;
        transform-origin: bottom center;
        transform: translate(-50%, -100%);
        border-radius: 4px 4px 0 0;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .qibla-needle::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        background: #ef4444;
        border-radius: 50%;
        bottom: -6px;
        left: -4px;
    }

    /* Embed Panel */
    .embed-panel {
        flex: 1;
        min-width: 300px;
    }

    .embed-panel h3 {
        font-size: 1.1rem;
        color: #0f172a;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .embed-code-area {
        background: #0b1c2b;
        color: #e2e8f0;
        padding: 20px;
        border-radius: 16px;
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 0.75rem;
        line-height: 1.6;
        white-space: pre-wrap;
        border: 1px solid #1e2a3a;
        margin-bottom: 15px;
        min-height: 250px;
        overflow: auto;
    }

    .copy-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 14px;
        background: rgb(13 110 110 / 0.9);
        color: white;
        border: none;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .copy-btn:hover {
        background: rgb(13 110 110);
    }

    .copy-btn:active {
        transform: scale(0.98);
    }

    .powered-link {
        color: rgb(13 110 110);
        text-decoration: none;
        font-weight: 600;
    }

    .powered-link:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .embed-wrapper {
            flex-direction: column;
        }
        
        .preview-card {
            flex: auto;
            width: 100%;
        }
        
        .widget-tabs {
            flex-direction: column;
        }
        
        .tab-btn {
            width: 100%;
            text-align: center;
        }
    }

    /* Loading States */
    .loading {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }

    .loading::after {
        content: '';
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-left: 10px;
        border: 2px solid #e2e8f0;
        border-top-color: rgb(13 110 110);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Footer note */
    .seo-note {
        max-width: 1100px;
        margin: 30px auto 0;
        padding: 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f6;
        font-size: 0.85rem;
        color: #475569;
    }

    .seo-note a {
        color: rgb(13 110 110);
        text-decoration: none;
    }

    .seo-note a:hover {
        text-decoration: underline;
    }

    /* Toast Notification */
    .toast-message {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgb(13 110 110);
        color: white;
        padding: 12px 24px;
        border-radius: 40px;
        font-size: 0.9rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<br><br>

<div class="dev-header">
    <h1>⚡ Prayer Times & Qibla Direction Widgets</h1>
    <p>Simple embed codes for your website. Lightweight, accurate, and SEO-friendly.</p>
    
    <div class="features-grid">
        <span class="feature-tag">✅ Vanilla JS</span>
        <span class="feature-tag">✅ No jQuery</span>
        <span class="feature-tag">✅ ~1.5KB gzipped</span>
        <span class="feature-tag">✅ Al-Adhan API</span>
        <span class="feature-tag">✅ Auto updates</span>
        <span class="feature-tag">✅ No cookies</span>
    </div>
</div>

<div class="widgets-container">
    <!-- Tabs -->
    <div class="widget-tabs">
        <button class="tab-btn active" onclick="switchTab('prayer')">🕌 Prayer Times</button>
        <button class="tab-btn" onclick="switchTab('qibla')">🧭 Qibla Direction</button>
        <button class="tab-btn" onclick="switchTab('daily')">📖 Daily Islam</button>
    </div>

    <!-- Prayer Times Widget -->
    <div id="prayer-widget" class="widget-content active">
        <div class="embed-wrapper">
            <!-- Preview -->
            <div class="preview-card">
                <div class="preview-header">
                    <i class="fas fa-mosque"></i>
                    <span id="prayer-heading">Prayer Times</span>
                </div>
                <div class="preview-body">
                    <select id="prayer-country" class="city-select">
                        <option value="">🌍 Select country</option>
                    </select>
                    
                    <select id="prayer-city" class="city-select">
                        <option value="">🏙️ Select city</option>
                    </select>
                    
                    <table class="prayer-table" id="prayer-times">
                        <tr><td colspan="2" style="text-align:center; color:#64748b; padding:20px;">Select location to view timings</td></tr>
                    </table>
                    
                    <div style="margin-top: 15px; text-align:center; font-size:0.8rem; color:#94a3b8;">
                        ⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" class="powered-link">nextprayertime.com</a>
                    </div>
                </div>
            </div>
            
            <!-- Embed Code -->
            <div class="embed-panel">
                <h3>📋 Embed Code (Copy & Paste)</h3>
                <div class="embed-code-area" id="prayer-embed-code">Select a city to generate embed code</div>
                <button class="copy-btn" onclick="copyCode('prayer')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Copy Embed Code
                </button>
            </div>
        </div>
    </div>

    <!-- Qibla Direction Widget -->
    <div id="qibla-widget" class="widget-content">
        <div class="embed-wrapper">
            <!-- Preview -->
            <div class="preview-card">
                <div class="preview-header">
                    <i class="fas fa-compass"></i>
                    <span id="qibla-heading">Qibla Direction</span>
                </div>
                <div class="preview-body">
                    <select id="qibla-country" class="city-select">
                        <option value="">🌍 Select country</option>
                    </select>
                    
                    <select id="qibla-city" class="city-select">
                        <option value="">🏙️ Select city</option>
                    </select>
                    
                    <div id="qibla-preview">
                        <div style="text-align:center; padding:20px; color:#64748b;">Select location to see Qibla direction</div>
                    </div>
                    
                    <div style="margin-top: 15px; text-align:center; font-size:0.8rem; color:#94a3b8;">
                        ⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" class="powered-link">nextprayertime.com</a>
                    </div>
                </div>
            </div>
            
            <!-- Embed Code -->
            <div class="embed-panel">
                <h3>📋 Embed Code (Copy & Paste)</h3>
                <div class="embed-code-area" id="qibla-embed-code">Select a city to generate embed code</div>
                <button class="copy-btn" onclick="copyCode('qibla')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Copy Embed Code
                </button>
            </div>
        </div>
    </div>

    <!-- Daily Islam Widget -->
    <div id="daily-widget" class="widget-content">
        <div class="embed-wrapper">
            <!-- Preview -->
            <div class="preview-card">
                <div class="preview-header">
                    <i class="fas fa-quran"></i>
                    <span>Quran & Hadith</span>
                </div>
                <div class="preview-body">
                    <!-- Simple Surah and Ayah Dropdowns -->
                    <div class="selection-group">
                        <select id="surah-select" class="surah-select" onchange="loadSurahAyahs()">
                            <option value="">📖 Select Surah</option>
                        </select>
                        
                        <select id="ayah-select" class="ayah-select" onchange="loadSelectedAyah()">
                            <option value="">🔢 Select Ayah</option>
                        </select>
                    </div>
                    
                    <!-- Random Button -->
                    <div style="text-align:center; margin:15px 0;">
                        <button class="refresh-btn" onclick="loadRandomContent()">
                            <i class="fas fa-random"></i> Random Ayah / Hadith
                        </button>
                    </div>
                    
                    <!-- Content Display -->
                    <div id="daily-preview" style="margin-top: 15px;">
                        <div style="text-align:center; padding:20px; color:#64748b;">Select a Surah and Ayah or click Random</div>
                    </div>
                    
                    <!-- Backlink -->
                    <div style="margin-top: 20px; text-align:center; font-size:0.8rem; color:#94a3b8;">
                        ⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" class="powered-link">nextprayertime.com</a>
                    </div>
                </div>
            </div>
            
            <!-- Embed Code -->
            <div class="embed-panel">
                <h3>📋 Embed Code (Copy & Paste)</h3>
                <div class="embed-code-area" id="daily-embed-code">Select content to generate embed code</div>
                <button class="copy-btn" onclick="copyCode('daily')">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Copy Embed Code
                </button>
            </div>
        </div>
    </div>
    
    <!-- SEO Note -->
    <!-- <div class="seo-note">
        <p><strong>🔍 SEO Note:</strong> All widgets include a "Powered by" link to <a href="https://nextprayertime.com" target="_blank" rel="follow" style="color:rgb(13 110 110);">nextprayertime.com</a> with <strong>follow</strong> attribute for SEO benefit. Widgets are lightweight (~1.5KB) and don't affect page speed. Daily Islamic content sourced from authentic APIs with proper attribution.</p>
    </div> -->
</div>

<script>
    const baseUrl = "https://nextprayertime.com";
    const domain = "nextprayertime.com";

    // City data
    const countries = {
        "Pakistan": ["Karachi", "Lahore", "Islamabad", "Peshawar", "Quetta"],
        "Saudi Arabia": ["Makkah", "Madina", "Riyadh", "Jeddah", "Dammam"],
        "UAE": ["Dubai", "Abu Dhabi", "Sharjah", "Ajman", "Ras Al Khaimah"],
        "USA": ["New York", "Los Angeles", "Chicago", "Houston", "Dallas"],
        "UK": ["London", "Manchester", "Birmingham", "Liverpool", "Leeds"],
        "India": ["Mumbai", "Delhi", "Bangalore", "Hyderabad", "Chennai"],
        "Turkey": ["Istanbul", "Ankara", "Izmir", "Bursa", "Antalya"],
        "Egypt": ["Cairo", "Alexandria", "Giza", "Shubra", "Port Said"],
        "Malaysia": ["Kuala Lumpur", "George Town", "Ipoh", "Shah Alam", "Johor Bahru"],
        "Indonesia": ["Jakarta", "Surabaya", "Bandung", "Medan", "Semarang"]
    };

    // API endpoints
    const QURAN_API = 'https://api.alquran.cloud/v1';
    
    // Sample Hadith collection (authentic)
    const hadithCollection = [
        {
            arabic: 'عَنْ أَبِي هُرَيْرَةَ رَضِيَ اللَّهُ عَنْهُ قَالَ: قَالَ رَسُولُ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ: "مَنْ نَفَّسَ عَنْ مُؤْمِنٍ كُرْبَةً مِنْ كُرَبِ الدُّنْيَا، نَفَّسَ اللَّهُ عَنْهُ كُرْبَةً مِنْ كُرَبِ يَوْمِ الْقِيَامَةِ..."',
            english: 'Whoever relieves a believer\'s distress of the distressing matters of the world, Allah will relieve him of some of the distressing matters of the Day of Resurrection...',
            narrator: 'Abu Hurairah',
            reference: 'Sahih Muslim 2699'
        },
        {
            arabic: 'عَنْ أَنَسِ بْنِ مَالِكٍ رَضِيَ اللَّهُ عَنْهُ قَالَ: قَالَ رَسُولُ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ: "لَا يُؤْمِنُ أَحَدُكُمْ حَتَّى يُحِبَّ لِأَخِيهِ مَا يُحِبُّ لِنَفْسِهِ"',
            english: 'None of you truly believes until he loves for his brother what he loves for himself',
            narrator: 'Anas ibn Malik',
            reference: 'Sahih Bukhari 13'
        },
        {
            arabic: 'عَنْ عُمَرَ بْنِ الْخَطَّابِ رَضِيَ اللَّهُ عَنْهُ قَالَ: قَالَ رَسُولُ اللَّهِ صَلَّى اللَّهُ عَلَيْهِ وَسَلَّمَ: "إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ"',
            english: 'Actions are judged by intentions',
            narrator: 'Umar ibn Al-Khattab',
            reference: 'Sahih Bukhari 1'
        }
    ];

    function populateCountries() {
        ['prayer-country', 'qibla-country'].forEach(id => {
            const select = document.getElementById(id);
            Object.keys(countries).forEach(c => {
                select.appendChild(new Option(c, c));
            });
        });
    }

    function switchTab(tab) {
        document.querySelectorAll('.tab-btn, .widget-content').forEach(el => el.classList.remove('active'));
        if(tab === 'prayer') {
            document.querySelectorAll('.tab-btn')[0].classList.add('active');
            document.getElementById('prayer-widget').classList.add('active');
        } else if(tab === 'qibla') {
            document.querySelectorAll('.tab-btn')[1].classList.add('active');
            document.getElementById('qibla-widget').classList.add('active');
        } else {
            document.querySelectorAll('.tab-btn')[2].classList.add('active');
            document.getElementById('daily-widget').classList.add('active');
        }
    }

    // Load Surah List
    async function loadSurahList() {
        try {
            const response = await fetch(`${QURAN_API}/surah`);
            const data = await response.json();
            
            const surahSelect = document.getElementById('surah-select');
            surahSelect.innerHTML = '<option value="">📖 Select Surah</option>';
            
            data.data.forEach(surah => {
                const option = document.createElement('option');
                option.value = surah.number;
                option.textContent = `${surah.number}. ${surah.englishName} (${surah.name})`;
                surahSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading surah list:', error);
            showToast('Failed to load surah list');
        }
    }

    // Load Ayahs for selected Surah
    async function loadSurahAyahs() {
        const surahNumber = document.getElementById('surah-select').value;
        if (!surahNumber) {
            document.getElementById('ayah-select').innerHTML = '<option value="">🔢 Select Ayah</option>';
            return;
        }
        
        try {
            const response = await fetch(`${QURAN_API}/surah/${surahNumber}`);
            const data = await response.json();
            const ayahs = data.data.ayahs;
            
            const ayahSelect = document.getElementById('ayah-select');
            ayahSelect.innerHTML = '<option value="">🔢 Select Ayah</option>';
            
            ayahs.forEach(ayah => {
                const option = document.createElement('option');
                option.value = ayah.numberInSurah;
                option.textContent = `Ayah ${ayah.numberInSurah}`;
                ayahSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading ayahs:', error);
            showToast('Failed to load ayahs');
        }
    }

    // Load Selected Ayah - FIXED
    async function loadSelectedAyah() {
        const surahNumber = document.getElementById('surah-select').value;
        const ayahNumber = document.getElementById('ayah-select').value;
        
        if (!surahNumber || !ayahNumber) return;
        
        document.getElementById('daily-preview').innerHTML = '<div class="loading">Loading...</div>';
        
        try {
            // Fixed API endpoint format
            const response = await fetch(`${QURAN_API}/ayah/${surahNumber}:${ayahNumber}/editions/quran-uthmani,en.sahih`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.code === 200 && data.data && data.data.length >= 2) {
                const arabicText = data.data[0].text;
                const englishText = data.data[1].text;
                const surahInfo = data.data[0].surah;
                
                const ayahData = {
                    arabic: arabicText,
                    english: englishText,
                    surah: surahInfo.englishName,
                    ayah: ayahNumber
                };
                
                displayQuran(ayahData);
                generateDailyEmbed('quran', ayahData);
            } else {
                throw new Error('Invalid response format');
            }
        } catch (error) {
            console.error('Error loading ayah:', error);
            document.getElementById('daily-preview').innerHTML = `
                <div style="text-align:center; padding:20px; color:#dc2626;">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Failed to load ayah. Please try again.</p>
                    <p style="font-size:0.8rem; margin-top:10px;">Surah ${surahNumber}, Ayah ${ayahNumber}</p>
                </div>
            `;
        }
    }

    // Load Random Content (Quran or Hadith)
    async function loadRandomContent() {
        const dailyPreview = document.getElementById('daily-preview');
        dailyPreview.innerHTML = '<div class="loading">Loading...</div>';
        
        try {
            const isQuran = Math.random() > 0.5;
            
            if (isQuran) {
                const randomAyah = Math.floor(Math.random() * 6236) + 1;
                const response = await fetch(`${QURAN_API}/ayah/${randomAyah}/editions/quran-uthmani,en.sahih`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.code === 200 && data.data && data.data.length >= 2) {
                    const arabicText = data.data[0].text;
                    const englishText = data.data[1].text;
                    const surahInfo = data.data[0].surah;
                    const ayahNumber = data.data[0].numberInSurah;
                    
                    const ayahData = {
                        arabic: arabicText,
                        english: englishText,
                        surah: surahInfo.englishName,
                        ayah: ayahNumber
                    };
                    
                    displayQuran(ayahData);
                    generateDailyEmbed('quran', ayahData);
                } else {
                    throw new Error('Invalid response format');
                }
            } else {
                const randomHadith = hadithCollection[Math.floor(Math.random() * hadithCollection.length)];
                displayHadith(randomHadith);
                generateDailyEmbed('hadith', randomHadith);
            }
        } catch (error) {
            console.error('Error:', error);
            dailyPreview.innerHTML = `
                <div style="text-align:center; padding:30px; color:#dc2626;">
                    <i class="fas fa-exclamation-circle" style="font-size:2rem; margin-bottom:10px;"></i>
                    <p>Failed to load content.</p>
                    <button class="refresh-btn" onclick="loadRandomContent()">Try Again</button>
                </div>
            `;
        }
    }

    function displayQuran(data) {
        const preview = document.getElementById('daily-preview');
        preview.innerHTML = `
            <div class="ayat-box">
                <div class="content-type-badge badge-quran">📖 Quran Verse</div>
                <div class="ayat-arabic">${data.arabic}</div>
                <div class="ayat-translation">${data.english}</div>
                <div style="margin-top: 15px; font-size:0.8rem; color:#94a3b8; display:flex; justify-content:space-between; align-items:center;">
                    <span>📚 Surah ${data.surah} (${data.ayah})</span>
                    <a href="https://quran.com" target="_blank" class="source-link">Source: Quran.com</a>
                </div>
            </div>
        `;
    }

    function displayHadith(data) {
        const preview = document.getElementById('daily-preview');
        preview.innerHTML = `
            <div class="hadith-box">
                <div class="content-type-badge badge-hadith">📚 Hadith</div>
                <div class="hadith-arabic">${data.arabic}</div>
                <div class="hadith-translation">${data.english}</div>
                <div class="hadith-reference">
                    <div>📚 ${data.reference}</div>
                    <div>🗣️ Narrated by: ${data.narrator}</div>
                    <div style="margin-top:5px;"><a href="https://sunnah.com" target="_blank" class="source-link">Source: sunnah.com</a></div>
                </div>
            </div>
        `;
    }

    function generateDailyEmbed(type, data) {
        const uniqueId = `di-${Date.now()}`;
        
        let embedContent = '';
        
        if (type === 'quran') {
            embedContent = `
                <div style="background:#f8fafc;border-radius:16px;padding:20px;margin-bottom:15px;border-right:4px solid rgb(13 110 110);direction:rtl;">
                    <div style="font-size:1.3rem;line-height:2rem;font-family:'Uthmanic',serif;color:#0f172a;margin-bottom:12px;">${data.arabic}</div>
                    <div style="font-size:0.9rem;color:#475569;direction:ltr;text-align:left;padding-top:8px;border-top:1px dashed #d1d9e6;">${data.english}</div>
                    <div style="margin-top:8px;font-size:0.7rem;color:#94a3b8;">📖 ${data.surah} (${data.ayah}) · <a href="https://quran.com" target="_blank" style="color:rgb(13 110 110);text-decoration:none;">Quran.com</a></div>
                </div>
            `;
        } else {
            embedContent = `
                <div style="background:#f8fafc;border-radius:16px;padding:20px;margin-bottom:15px;border-left:4px solid #f59e0b;direction:rtl;">
                    <div style="font-size:1.3rem;line-height:2rem;font-family:'Uthmanic',serif;color:#0f172a;margin-bottom:12px;">${data.arabic}</div>
                    <div style="font-size:0.9rem;color:#475569;direction:ltr;text-align:left;padding-top:8px;border-top:1px dashed #d1d9e6;">${data.english}</div>
                    <div style="font-size:0.75rem;color:#64748b;margin-top:8px;direction:ltr;">📚 ${data.reference} · 🗣️ ${data.narrator}</div>
                    <div style="margin-top:5px;font-size:0.7rem;"><a href="https://sunnah.com" target="_blank" style="color:rgb(13 110 110);text-decoration:none;">sunnah.com</a></div>
                </div>
            `;
        }
        
        const dailyEmbed = `<div style="font-family:sans-serif;max-width:300px;border:1px solid #eef2f6;border-radius:16px;padding:15px;background:white;" id="${uniqueId}">` +
            `<div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">` +
                `<span style="font-size:1.2rem;">📖</span>` +
                `<span style="font-weight:600;color:#0f172a;">Daily Islamic Wisdom</span>` +
            `</div>` +
            embedContent +
            `<div style="margin-top:12px;font-size:0.7rem;text-align:center;color:#94a3b8;">⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" style="color:rgb(13 110 110);text-decoration:none;">nextprayertime.com</a></div>` +
        `</div>`;
        
        document.getElementById('daily-embed-code').textContent = dailyEmbed;
    }

    // Prayer Times
    document.getElementById('prayer-country').addEventListener('change', function() {
        const citySelect = document.getElementById('prayer-city');
        citySelect.innerHTML = '<option value="">🏙️ Select city</option>';
        if(this.value && countries[this.value]) {
            countries[this.value].forEach(c => citySelect.appendChild(new Option(c, c)));
        }
        document.getElementById('prayer-times').innerHTML = '<tr><td colspan="2" style="text-align:center; color:#64748b; padding:20px;">Select city to view timings</td></tr>';
        document.getElementById('prayer-embed-code').textContent = 'Select a city to generate embed code';
    });

    document.getElementById('prayer-city').addEventListener('change', async function() {
        const city = this.value, country = document.getElementById('prayer-country').value;
        if(!city || !country) return;
        
        document.getElementById('prayer-heading').textContent = `${city} Prayer Times`;
        document.getElementById('prayer-times').innerHTML = '<tr><td colspan="2" style="text-align:center; padding:20px;">Loading...</td></tr>';
        
        try {
            const res = await fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&method=1`);
            const data = await res.json();
            const t = data.data.timings;
            
            document.getElementById('prayer-times').innerHTML = `
                <tr><td>Fajr</td><td>${t.Fajr}</td></tr>
                <tr><td>Dhuhr</td><td>${t.Dhuhr}</td></tr>
                <tr><td>Asr</td><td>${t.Asr}</td></tr>
                <tr><td>Maghrib</td><td>${t.Maghrib}</td></tr>
                <tr><td>Isha</td><td>${t.Isha}</td></tr>
            `;
            
            const embed = `<div style="font-family:sans-serif;max-width:300px;border:1px solid #eef2f6;border-radius:16px;padding:15px;background:white;" id="pt-${Date.now()}">` +
                `<div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;"><span style="font-size:1.2rem;">🕌</span><span style="font-weight:600;color:#0f172a;">${city} Prayer Times</span></div>` +
                `<div style="font-size:0.8rem;color:#64748b;margin-bottom:10px;text-align:center;">Loading...</div></div>` +
                `<script>` +
                    `(function(){` +
                        `const c='${city}',co='${country}';` +
                        `fetch('https://api.aladhan.com/v1/timingsByCity?city='+encodeURIComponent(c)+'&country='+encodeURIComponent(co)+'&method=1')` +
                        `.then(r=>r.json()).then(d=>{` +
                            `const t=d.data.timings;` +
                            `document.querySelector('#pt-${Date.now()}').innerHTML='` +
                                `<div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;"><span style="font-size:1.2rem;">🕌</span><span style="font-weight:600;color:#0f172a;">'+c+' Prayer Times</span></div>` +
                                `<table style="width:100%;border-collapse:collapse;">` +
                                    `<tr><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:#334155;">Fajr</td><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:rgb(13 110 110);font-family:monospace;font-weight:600;text-align:right;">'+t.Fajr+'</td></tr>` +
                                    `<tr><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:#334155;">Dhuhr</td><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:rgb(13 110 110);font-family:monospace;font-weight:600;text-align:right;">'+t.Dhuhr+'</td></tr>` +
                                    `<tr><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:#334155;">Asr</td><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:rgb(13 110 110);font-family:monospace;font-weight:600;text-align:right;">'+t.Asr+'</td></tr>` +
                                    `<tr><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:#334155;">Maghrib</td><td style="padding:8px 0;border-bottom:1px solid #f1f5f9;color:rgb(13 110 110);font-family:monospace;font-weight:600;text-align:right;">'+t.Maghrib+'</td></tr>` +
                                    `<tr><td style="padding:8px 0;color:#334155;">Isha</td><td style="padding:8px 0;color:rgb(13 110 110);font-family:monospace;font-weight:600;text-align:right;">'+t.Isha+'</td></tr>` +
                                `</table>` +
                                `<div style="margin-top:12px;font-size:0.7rem;text-align:center;color:#94a3b8;">⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" style="color:rgb(13 110 110);text-decoration:none;">nextprayertime.com</a></div>'` +
                        `});` +
                    `})();` +
                `<\/script>`;
            
            document.getElementById('prayer-embed-code').textContent = embed;
        } catch(e) {
            document.getElementById('prayer-times').innerHTML = '<tr><td colspan="2" style="text-align:center; color:#dc2626; padding:20px;">Failed to load times</td></tr>';
        }
    });

    // Qibla Direction
    document.getElementById('qibla-country').addEventListener('change', function() {
        const citySelect = document.getElementById('qibla-city');
        citySelect.innerHTML = '<option value="">🏙️ Select city</option>';
        if(this.value && countries[this.value]) {
            countries[this.value].forEach(c => citySelect.appendChild(new Option(c, c)));
        }
        document.getElementById('qibla-preview').innerHTML = '<div style="text-align:center; padding:20px; color:#64748b;">Select city to see Qibla direction</div>';
        document.getElementById('qibla-embed-code').textContent = 'Select a city to generate embed code';
    });

    document.getElementById('qibla-city').addEventListener('change', async function() {
        const city = this.value, country = document.getElementById('qibla-country').value;
        if(!city || !country) return;
        
        document.getElementById('qibla-heading').textContent = `${city} Qibla Direction`;
        document.getElementById('qibla-preview').innerHTML = '<div class="loading">Calculating direction</div>';
        
        try {
            const geo = await (await fetch(`https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(city)}&country=${encodeURIComponent(country)}&format=json&limit=1`)).json();
            if(geo.length) {
                const lat = parseFloat(geo[0].lat), lng = parseFloat(geo[0].lon);
                const lat1 = lat * Math.PI/180, lat2 = 21.4225 * Math.PI/180;
                const lngDiff = (39.8262 - lng) * Math.PI/180;
                let qibla = Math.atan2(Math.sin(lngDiff), Math.cos(lat1) * Math.tan(lat2) - Math.sin(lat1) * Math.cos(lngDiff)) * 180/Math.PI;
                const dir = Math.round((qibla + 360) % 360);
                
                document.getElementById('qibla-preview').innerHTML = `
                    <div style="text-align:center;">
                        <div class="compass-container">
                            <div class="compass-circle"></div>
                            <div class="direction-label" style="top:5px; left:50%; transform:translateX(-50%);">N</div>
                            <div class="direction-label" style="right:5px; top:50%; transform:translateY(-50%);">E</div>
                            <div class="direction-label" style="bottom:5px; left:50%; transform:translateX(-50%);">S</div>
                            <div class="direction-label" style="left:5px; top:50%; transform:translateY(-50%);">W</div>
                            <div class="kaaba-center">🕋</div>
                            <div class="qibla-needle" style="transform: translate(-50%, -100%) rotate(${dir}deg);"></div>
                        </div>
                        <div style="font-size:1.3rem; font-weight:700; color:#0f172a; margin:10px 0;">${dir}°</div>
                        <div style="background:#f8fafc; padding:10px; border-radius:10px;">Face ${dir}° toward Makkah</div>
                    </div>`;
                
                const embed = `<div style="font-family:sans-serif;max-width:300px;border:1px solid #eef2f6;border-radius:16px;padding:15px;background:white;text-align:center;" id="qb-${Date.now()}">` +
                    `<div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:10px;"><span style="font-size:1.2rem;">🧭</span><span style="font-weight:600;color:#0f172a;">${city} Qibla</span></div>` +
                    `<div style="font-size:0.8rem;color:#64748b;margin-bottom:10px;">Loading direction...</div></div>` +
                    `<script>` +
                        `(function(){` +
                            `const c='${city}',co='${country}';` +
                            `fetch('https://nominatim.openstreetmap.org/search?city='+encodeURIComponent(c)+'&country='+encodeURIComponent(co)+'&format=json&limit=1')` +
                            `.then(r=>r.json()).then(g=>{` +
                                `if(g.length){` +
                                    `const lat=g[0].lat,lng=g[0].lon;` +
                                    `const r1=lat*Math.PI/180,r2=21.4225*Math.PI/180;` +
                                    `const d=(39.8262-lng)*Math.PI/180;` +
                                    `let q=Math.atan2(Math.sin(d),Math.cos(r1)*Math.tan(r2)-Math.sin(r1)*Math.cos(d))*180/Math.PI;` +
                                    `const dir=Math.round((q+360)%360);` +
                                    `document.querySelector('#qb-${Date.now()}').innerHTML='` +
                                        `<div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:10px;"><span style="font-size:1.2rem;">🧭</span><span style="font-weight:600;color:#0f172a;">'+c+' Qibla</span></div>` +
                                        `<div style="position:relative; width:140px; height:140px; margin:0 auto 10px;">` +
                                            `<div style="position:absolute; width:100%; height:100%; border-radius:50%; border:3px solid rgb(13 110 110 / 0.3);"></div>` +
                                            `<div style="position:absolute; top:5px; left:50%; transform:translateX(-50%); font-size:0.7rem; font-weight:600; color:rgb(13 110 110);">N</div>` +
                                            `<div style="position:absolute; right:5px; top:50%; transform:translateY(-50%); font-size:0.7rem; font-weight:600; color:rgb(13 110 110);">E</div>` +
                                            `<div style="position:absolute; bottom:5px; left:50%; transform:translateX(-50%); font-size:0.7rem; font-weight:600; color:rgb(13 110 110);">S</div>` +
                                            `<div style="position:absolute; left:5px; top:50%; transform:translateY(-50%); font-size:0.7rem; font-weight:600; color:rgb(13 110 110);">W</div>` +
                                            `<div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); width:35px; height:35px; background:rgb(13 110 110); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:1rem;">🕋</div>` +
                                            `<div style="position:absolute; top:50%; left:50%; width:4px; height:60px; background:#ef4444; transform-origin:bottom center; transform:translate(-50%, -100%) rotate('+dir+'deg); border-radius:4px 4px 0 0;">` +
                                                `<div style="position:absolute; width:10px; height:10px; background:#ef4444; border-radius:50%; bottom:-5px; left:-3px;"></div>` +
                                            `</div>` +
                                        `</div>` +
                                        `<div style="font-size:1.2rem; font-weight:700; color:#0f172a; margin:10px 0;">'+dir+'°</div>` +
                                        `<div style="background:#f8fafc; padding:8px; border-radius:8px; margin:10px 0;"><span style="color:rgb(13 110 110);">'+c+', '+co+'</span></div>` +
                                        `<div style="font-size:0.7rem; color:#94a3b8;">⚡ Powered by <a href="https://nextprayertime.com" target="_blank" rel="follow" style="color:rgb(13 110 110);text-decoration:none;">nextprayertime.com</a></div>'` +
                                `}})` +
                        `})();` +
                    `<\/script>`;
                
                document.getElementById('qibla-embed-code').textContent = embed;
            }
        } catch(e) {
            document.getElementById('qibla-preview').innerHTML = '<div style="text-align:center; padding:20px; color:#dc2626;">Failed to calculate direction</div>';
        }
    });

    function copyCode(type) {
        const text = document.getElementById(`${type}-embed-code`).textContent;
        if(type === 'daily') {
            navigator.clipboard.writeText(text).then(() => showToast('✨ Daily Islam embed code copied!'));
        } else if(text.includes('Select a city')) {
            showToast('Please select a city first');
        } else {
            navigator.clipboard.writeText(text).then(() => showToast('✨ Embed code copied!'));
        }
    }

    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Initialize
    populateCountries();
    loadSurahList();
</script>

@include('footer')
</body>
</html>