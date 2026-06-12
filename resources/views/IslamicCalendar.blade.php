@section('title', translate('Islamic Calendar | Hijri Calendar With Important Dates - NextPrayerTime'))
@section('description', translate('Accurate Islamic calendar with Hijri dates, prayer times, and important Islamic events.')) 
@section('keywords', 'islamic calendar, hijri calendar, muslim dates, ramadan dates, eid dates, ramadan calendar 2026, prayer times, iftar time, sehri time, islamic events, nextprayertime')
@include('header')

<style>
/* Using specified color #0d6e6ee6 */
:root {
    --primary-color: #0d6e6e;
    --primary-light: #0d6e6ecc;
    --primary-dark: #0a5a5a;
}

.location-details {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    font-size: 0.9rem;
    color: #666;
}

.location-details i {
    color: var(--primary-color);
    margin-right: 8px;
}

.ramadan-special {
    background: var(--primary-color);
    color: white;
    padding: 20px;
    border-radius: 15px;
    margin: 20px 0;
}

.ramadan-countdown {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
}

/* FAQ Section Styles */
.faq-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    padding: 60px 0;
}

.faq-item {
    background: white;
    border-radius: 15px;
    margin-bottom: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid rgba(13, 110, 110, 0.1);
}

.faq-item:hover {
    box-shadow: 0 8px 25px rgba(13, 110, 110, 0.15);
    transform: translateY(-2px);
}

.faq-question {
    padding: 20px 25px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: var(--primary-color);
    font-size: 1.1rem;
}

.faq-question i {
    transition: transform 0.3s ease;
    color: var(--primary-color);
}

.faq-question.active i {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 25px;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    color: #666;
    line-height: 1.8;
    border-top: 0px solid rgba(13, 110, 110, 0.1);
}

.faq-answer.show {
    padding: 0 25px 20px 25px;
    max-height: 500px;
    border-top-width: 1px;
}

.faq-answer p {
    margin-bottom: 10px;
}

.faq-answer ul, .faq-answer ol {
    padding-left: 20px;
    margin-bottom: 10px;
}

.faq-answer li {
    margin-bottom: 5px;
}
</style>

  <!-- Main Content -->
  <div id="app">
    <!-- Content will be dynamically loaded here -->
  </div>

  <!-- Footer -->
  @include('footer')
  <script type="application/ld+json" id="faq-schema">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": []
    }
  </script>
  <script>
    // Main Application
    document.addEventListener('DOMContentLoaded', function() {
      // Set current year in footer
      document.getElementById('currentYear').textContent = new Date().getFullYear();
      
      // Get user location first
      getUserLocation().then(() => {
        // Load Islamic Calendar page
        loadIslamicCalendarPage();
        
        // Get current Hijri date
        getCurrentHijriDate().then(hijriDate => {
          document.getElementById('hijriDate').textContent = hijriDate;
        });
      });
    });

    // Global state
    const state = {
      currentDate: new Date(),
      currentHijriDate: null,
      islamicEvents: [],
      userLocation: {
        city: 'Loading...',
        country: 'Loading...',
        latitude: null,
        longitude: null,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        timestamp: new Date().toISOString()
      },
      hijriMonths: [
        'Muharram', 'Safar', 'Rabi al-Awwal', 'Rabi al-Thani', 
        'Jumada al-Awwal', 'Jumada al-Thani', 'Rajab', 'Sha\'ban', 
        'Ramadan', 'Shawwal', 'Dhu al-Qi\'dah', 'Dhu al-Hijjah'
      ],
      gregorianMonths: [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ],
      calendarCache: {}, // Cache for calendar data
      importantDates: {} // Will store dynamically calculated important dates
    };

    // Get user location
    async function getUserLocation() {
      return new Promise((resolve) => {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            async (position) => {
              state.userLocation.latitude = position.coords.latitude;
              state.userLocation.longitude = position.coords.longitude;
              
              // Get city and country from coordinates
              try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`);
                const data = await response.json();
                
                if (data.address) {
                  state.userLocation.city = data.address.city || data.address.town || data.address.village || 'Unknown';
                  state.userLocation.country = data.address.country || 'Unknown';
                  state.userLocation.state = data.address.state || '';
                }
              } catch (error) {
                console.error('Error getting location details:', error);
              }
              
              resolve();
            },
            (error) => {
              console.error('Error getting location:', error);
              state.userLocation.city = 'Location access denied';
              state.userLocation.country = '';
              resolve();
            }
          );
        } else {
          state.userLocation.city = 'Geolocation not supported';
          resolve();
        }
      });
    }

    // Get current Hijri date from API
    async function getCurrentHijriDate() {
      try {
        const response = await fetch(`https://api.aladhan.com/v1/gToH/${formatDateForAPI(new Date())}`);
        const data = await response.json();
        
        if (data.code === 200) {
          const hijri = data.data.hijri;
          state.currentHijriDate = hijri;
          return `${hijri.day} ${hijri.month.en}, ${hijri.year} AH`;
        }
      } catch (error) {
        console.error('Error fetching Hijri date:', error);
      }
      return 'Loading...';
    }

    // Format date for API (DD-MM-YYYY)
    function formatDateForAPI(date) {
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
    }

    // Format date for display (DD/MM/YYYY)
    function formatDateForDisplay(date) {
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }

    // Format date for display with month name (DD Month YYYY)
    function formatDateLong(date) {
      return date.toLocaleDateString('en-US', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
      });
    }

    // Calculate important Islamic dates dynamically for the current year
    async function calculateImportantDates() {
      const currentYear = new Date().getFullYear();
      const hijriYear = state.currentHijriDate ? state.currentHijriDate.year : 1447;
      
      // Calculate approximate Gregorian dates for Islamic events
      // These will be refined with actual API calls
      const importantDates = {
        ramadanStart: await getGregorianDate(9, 1, hijriYear),
        ramadanEnd: await getGregorianDate(9, 30, hijriYear),
        eidFitr: await getGregorianDate(10, 1, hijriYear),
        arafah: await getGregorianDate(12, 9, hijriYear),
        eidAdha: await getGregorianDate(12, 10, hijriYear),
        islamicNewYear: await getGregorianDate(1, 1, parseInt(hijriYear) + 1),
        ashura: await getGregorianDate(1, 10, hijriYear),
        mawlid: await getGregorianDate(3, 12, hijriYear),
        israMiraj: await getGregorianDate(7, 27, hijriYear),
        shabEBarat: await getGregorianDate(8, 15, hijriYear)
      };
      
      return importantDates;
    }

    // Generate dynamic FAQ data based on current year and dates
    async function generateDynamicFaqData() {
      const dates = await calculateImportantDates();
      const currentYear = new Date().getFullYear();
      const nextYear = currentYear + 1;
      
      const formatDate = (dateStr) => {
        if (!dateStr) return 'TBD';
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
      };
      
      return [
        {
          question: "What is the Islamic Calendar (Hijri Calendar)?",
          answer: `<p>The Islamic calendar, also known as the Hijri calendar, is a lunar calendar consisting of 12 months in a year of 354 or 355 days. It is used by Muslims worldwide to determine the dates of religious events and observances including Ramadan, Eid al-Fitr, Eid al-Adha, and Hajj. The calendar begins from the year of the Hijra (Migration) of Prophet Muhammad (PBUH) from Mecca to Medina in 622 CE. The current Hijri year is ${state.currentHijriDate?.year || '1447'} AH.</p>`
        },
        {
          question: `What is the date of Ramadan ${currentYear}?`,
          answer: `<p>Ramadan ${currentYear} is expected to begin on approximately <strong>${formatDate(dates.ramadanStart)}</strong> and end on approximately <strong>${formatDate(dates.ramadanEnd)}</strong>, depending on the moon sighting. The exact dates may vary by country based on lunar observations. Eid al-Fitr, marking the end of Ramadan, will be celebrated around <strong>${formatDate(dates.eidFitr)}</strong>.</p><p>Ramadan is the 9th month of the Islamic calendar and is considered the holiest month for Muslims, during which fasting from dawn to sunset is obligatory.</p>`
        },
        {
          question: `What are the important Islamic events in ${currentYear}?`,
          answer: `<p>Key Islamic events in ${currentYear} include:</p><ul>
            <li><strong>Ramadan:</strong> Month of fasting (${formatDate(dates.ramadanStart)} - ${formatDate(dates.ramadanEnd)})</li>
            <li><strong>Eid al-Fitr:</strong> Festival of breaking fast (${formatDate(dates.eidFitr)})</li>
            <li><strong>Day of Arafah:</strong> (${formatDate(dates.arafah)})</li>
            <li><strong>Eid al-Adha:</strong> Festival of sacrifice (${formatDate(dates.eidAdha)})</li>
            <li><strong>Islamic New Year ${parseInt(state.currentHijriDate?.year || '1447') + 1} AH:</strong> (${formatDate(dates.islamicNewYear)})</li>
            <li><strong>Ashura:</strong> (${formatDate(dates.ashura)})</li>
            <li><strong>Mawlid al-Nabi:</strong> Birth of Prophet Muhammad (PBUH) (${formatDate(dates.mawlid)})</li>
            <li><strong>Isra and Miraj:</strong> (${formatDate(dates.israMiraj)})</li>
            <li><strong>Shab-e-Barat:</strong> Night of Forgiveness (${formatDate(dates.shabEBarat)})</li>
          </ul><p>Note: These dates are approximations based on astronomical calculations and may vary by a day depending on actual moon sighting in your region.</p>`
        },
        {
          question: "How is the Hijri date calculated?",
          answer: `<p>The Hijri date is calculated based on the lunar cycle. Each month begins with the sighting of the new moon crescent. The Islamic calendar months alternate between 29 and 30 days:</p>
          <ul>
            <li><strong>Muharram</strong> (30 days) - Sacred month</li>
            <li><strong>Safar</strong> (29 days)</li>
            <li><strong>Rabi al-Awwal</strong> (30 days) - Birth month of Prophet Muhammad (PBUH)</li>
            <li><strong>Rabi al-Thani</strong> (29 days)</li>
            <li><strong>Jumada al-Awwal</strong> (30 days)</li>
            <li><strong>Jumada al-Thani</strong> (29 days)</li>
            <li><strong>Rajab</strong> (30 days) - Sacred month, Isra and Miraj</li>
            <li><strong>Sha'ban</strong> (29 days) - Month of preparation for Ramadan</li>
            <li><strong>Ramadan</strong> (30 days) - Month of fasting</li>
            <li><strong>Shawwal</strong> (29 days) - Month of Eid al-Fitr</li>
            <li><strong>Dhu al-Qi'dah</strong> (30 days) - Sacred month</li>
            <li><strong>Dhu al-Hijjah</strong> (29 or 30 days) - Sacred month, month of Hajj</li>
          </ul><p>The actual start of each month may vary by a day depending on moon sighting in different regions.</p>`
        },
        {
          question: "How to convert Gregorian date to Hijri date?",
          answer: `<p>To convert a Gregorian date to Hijri date:</p>
          <ol>
            <li>Use our date converter tool at the top of this page</li>
            <li>Select your Gregorian date in the first field (or enter manually)</li>
            <li>Click the 'Convert Date' button</li>
            <li>The corresponding Hijri date will be displayed instantly with the weekday</li>
          </ol>
          <p>You can also convert Hijri dates to Gregorian by:</p>
          <ol>
            <li>Selecting the Hijri day, month, and year in the second field</li>
            <li>Clicking 'Convert Date'</li>
            <li>The equivalent Gregorian date will be shown</li>
          </ol>
          <p>Our converter uses the Umm al-Qura calendar system for accurate calculations.</p>`
        },
        {
          question: "Why does the Hijri date differ in some countries?",
          answer: `<p>The Hijri date may differ between countries due to several factors:</p>
          <ul>
            <li><strong>Moon sighting methodology:</strong> Some regions rely on physical moon sighting with the naked eye, while others use astronomical calculations or telescopes</li>
            <li><strong>Geographical location:</strong> The moon becomes visible at different times in different parts of the world due to the earth's curvature and atmospheric conditions</li>
            <li><strong>Local religious authorities:</strong> Each country's official moon sighting committee or religious authority makes independent decisions based on their preferred methodology</li>
            <li><strong>Followed conventions:</strong> Some countries follow Saudi Arabia's announcements, others follow local sightings, and some follow global calculations</li>
            <li><strong>Time zone differences:</strong> The Islamic date changes at sunset, which occurs at different absolute times globally</li>
          </ul><p>This is why Ramadan, Eid, and other Islamic events may be celebrated on different days in different countries. It's recommended to follow your local religious authority's announcement.</p>`
        },
        {
          question: "What is the significance of Islamic months?",
          answer: `<p>Each Islamic month has special religious significance:</p>
          <ul>
            <li><strong>Muharram:</strong> First month, sacred month; 10th Muharram (Ashura) is a day of fasting commemorating Prophet Musa's (Moses) victory</li>
            <li><strong>Safar:</strong> Second month; historically a month of trials, but no specific religious obligations</li>
            <li><strong>Rabi al-Awwal:</strong> Third month; birth month of Prophet Muhammad (PBUH) - Mawlid celebrated on 12th</li>
            <li><strong>Rajab:</strong> Seventh month, sacred month; Isra and Miraj (Night Journey) occurred on 27th</li>
            <li><strong>Sha'ban:</strong> Eighth month; month of preparation for Ramadan; 15th is Shab-e-Barat (Night of Forgiveness)</li>
            <li><strong>Ramadan:</strong> Ninth month; month of fasting and Quran revelation; Laylat al-Qadr in last 10 days</li>
            <li><strong>Shawwal:</strong> Tenth month; month of Eid al-Fitr; 6 days of fasting recommended after Eid</li>
            <li><strong>Dhul Qa'dah:</strong> Eleventh month, sacred month; month of preparation for Hajj</li>
            <li><strong>Dhul Hijjah:</strong> Twelfth month, sacred month; month of Hajj and Eid al-Adha; first 10 days are most virtuous</li>
          </ul>`
        },
        {
          question: "What is the difference between Hijri and Gregorian calendar?",
          answer: `<p>Key differences between Hijri and Gregorian calendars:</p>
          <ul>
            <li><strong>Calendar type:</strong> Hijri is purely lunar (based on moon cycles), Gregorian is solar (based on earth's orbit around sun)</li>
            <li><strong>Year length:</strong> Hijri year has 354-355 days (about 10-12 days shorter), Gregorian has 365-366 days</li>
            <li><strong>Epoch (starting year):</strong> Hijri begins from 622 CE (Hijra - Prophet's migration to Medina), Gregorian from 1 CE (birth of Christ)</li>
            <li><strong>Month lengths:</strong> Hijri months alternate 29-30 days, Gregorian months vary 28-31 days</li>
            <li><strong>Date calculation:</strong> Hijri dates depend on moon sighting and can vary by region, Gregorian dates are fixed mathematically</li>
            <li><strong>Current year difference:</strong> Hijri year is approximately 579-580 years behind Gregorian year (${currentYear} CE ≈ ${state.currentHijriDate?.year || '1447'} AH)</li>
            <li><strong>Seasonal drift:</strong> Hijri months shift through seasons (about 11 days earlier each Gregorian year), Gregorian months are fixed to seasons</li>
          </ul>`
        }
      ];
    }

    // Initialize FAQ section with dynamic data
    async function initFaqSection() {
      const faqData = await generateDynamicFaqData();
      const faqContainer = document.querySelector('.faq-container');
      
      if (faqContainer) {
        faqContainer.innerHTML = faqData.map(faq => `
          <div class="faq-item">
            <div class="faq-question">
              ${faq.question}
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
              ${faq.answer}
            </div>
          </div>
        `).join('');
      }
      
      // Initialize FAQ interactions
      const faqItems = document.querySelectorAll('.faq-item');
      
      faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        question.addEventListener('click', () => {
          const isActive = question.classList.contains('active');
          
          // Close all FAQs
          document.querySelectorAll('.faq-question').forEach(q => {
            q.classList.remove('active');
          });
          document.querySelectorAll('.faq-answer').forEach(a => {
            a.classList.remove('show');
          });
          
          // Open clicked FAQ if it wasn't active
          if (!isActive) {
            question.classList.add('active');
            answer.classList.add('show');
          }
        });
      });
      
      // Generate FAQ schema
      generateFaqSchema(faqData);
    }
    
    // Generate FAQ Schema for SEO
    function generateFaqSchema(faqData) {
      const schemaScript = document.getElementById('faq-schema');
      const faqSchema = {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": faqData.map(faq => ({
          "@type": "Question",
          "name": faq.question,
          "acceptedAnswer": {
            "@type": "Answer",
            "text": faq.answer.replace(/<[^>]*>/g, '') // Strip HTML tags for schema
          }
        }))
      };
      
      schemaScript.textContent = JSON.stringify(faqSchema);
    }

    // Load Islamic Calendar page
    function loadIslamicCalendarPage() {
      document.getElementById('app').innerHTML = `
        <!-- Hero Section -->
        <section class="hero text-white" style="background: var(--primary-color);">
          <div class="container py-5">
            <div class="row align-items-center">
              <div class="col-lg-6 mb-5 mb-lg-0">
              <h1 class="display-4 fw-bold mb-4"> @trans('Islamic Hijri Calendar') {{ now()->year }} </h1>
                <p class="lead mb-5">@trans('View important Islamic dates and events according to the Hijri calendar.')</p>
                <p>
Welcome to the Islamic Calendar {{ now()->year }}. Here you can check today's Hijri date, view the complete Islamic calendar, explore upcoming Islamic events, and learn about all Hijri months in one place.
</p>
                <!-- Current Date Card with Location -->
                <div class="current-date-card">
                  <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-calendar-alt me-3" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <div>
                      <div class="text-muted small">@trans('TODAY\'S DATE')</div>
                      <div class="date-display" id="currentDate">-- --, ----</div>
                      <div class="hijri-display mt-2">
                        <i class="fas fa-moon me-2"></i>
                        <span id="hijriDateDisplay">@trans('Loading...')</span>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Location Details inside current-date-card -->
                  <div class="location-details">
                    <div class="row">
                      <div class="col-md-6">
                        <i class="fas fa-map-marker-alt"></i>
                        <span id="userLocation">${state.userLocation.city}, ${state.userLocation.country}</span>
                      </div>
                      <div class="col-md-6">
                        <i class="fas fa-globe"></i>
                        <span id="userTimezone">${state.userLocation.timezone}</span>
                      </div>
                      <div class="col-md-6 mt-2">
                        <i class="fas fa-clock"></i>
                        <span id="localTime">${new Date().toLocaleTimeString()}</span>
                      </div>
                      <div class="col-md-6 mt-2">
                        <i class="fas fa-map-pin"></i>
                        <span>Lat: ${state.userLocation.latitude?.toFixed(4) || '--'}, Long: ${state.userLocation.longitude?.toFixed(4) || '--'}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-6">
                <div class="search-card">
                  <h3 class="mb-4 text-center" style="color: var(--primary-color);">
                    <i class="fas fa-calendar-check me-2"></i> @trans('Convert Date')
                  </h3>
                  
                  <form id="dateConvertForm">
                    <div class="mb-4">
                      <label for="gregorianDate" class="form-label fw-bold">@trans('Gregorian Date')</label>
                      <input type="date" 
                             id="gregorianDate"
                             class="form-control form-control-lg">
                    </div>
                    <div class="mb-4">
                      <label class="form-label fw-bold">@trans('Hijri Date')</label>
                      <div class="row g-2">
                        <div class="col-4">
                          <select id="hijriDay" class="form-select form-select-lg">
                            <option value="">@trans('Day')</option>
                            ${Array.from({length: 30}, (_, i) => `<option value="${i+1}">${i+1}</option>`).join('')}
                          </select>
                        </div>
                        <div class="col-5">
                          <select id="hijriMonth" class="form-select form-select-lg">
                            ${state.hijriMonths.map((month, i) => 
                              `<option value="${i+1}">${month}</option>`
                            ).join('')}
                          </select>
                        </div>
                        <div class="col-3">
                          <select id="hijriYear" class="form-select form-select-lg">
                            <option value="1444">1444</option>
                            <option value="1445" selected>1445</option>
                            <option value="1446">1446</option>
                            <option value="1447">1447</option>
                            <option value="1448">1448</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-lg w-100" style="background: var(--primary-color); color: white;">
                      <i class="fas fa-exchange-alt me-2"></i> @trans('Convert Date')
                    </button>
                    <div id="conversionResult" class="conversion-result mt-3" style="display: none;">
                      <div id="gregorianResult" class="mb-2"></div>
                      <div id="hijriResult"></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Ramadan Special Section (visible only in Ramadan) -->
        <div id="ramadanSpecialSection" style="display: none;">
          <section class="ramadan-special">
            <div class="container">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h2><i class="fas fa-moon me-2"></i> Ramadan Mubarak!</h2>
                  <p class="mb-0">Ramadan Mubarak! May this holy month bring peace and blessings.</p>
                </div>
                <div class="col-md-4 text-end">
                  <div class="ramadan-countdown" id="ramadanCountdown"></div>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Upcoming Events Section -->
        <section class="section bg-white">
          <div class="container">
            <h2 class="section-title text-center">@trans('Upcoming Islamic Events') {{ now()->year }}</h2>
            <p>
Stay updated with upcoming Islamic events in {{ now()->year }} including Ramadan, Eid ul Fitr, Eid ul Adha, Islamic New Year, and other important Hijri dates.
</p>

<p>
Our Islamic events calendar is regularly updated to reflect moon sighting announcements and global Islamic observances. 
Bookmark this page to stay informed about the next major Islamic event in {{ now()->year }}.
</p>
<p>
Below is a list of important upcoming Islamic events based on the Hijri calendar {{ now()->year }}.
</p>
            <div class="row" id="upcomingEventsContainer">
              <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">@trans('Loading...')</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Calendar Section -->
        <section class="section islamic-pattern" id="calendarSection">
        <h2 class="section-title text-center"> Islamic Calendar Today {{ now()->year }}</h2>
          <div class="container">
          <p>
The Islamic Calendar Today {{ now()->year }} provides accurate Hijri dates based on the lunar system used by Muslims worldwide. 
Our updated Islamic calendar helps you check today's Hijri date, current Islamic month, and important religious days in {{ now()->year }}.
</p>

<p>
The Islamic calendar (Hijri calendar) follows the moon sighting system and consists of 12 lunar months. 
Unlike the Gregorian calendar, the Hijri year is approximately 354 days long. 
Use this Islamic calendar to track Ramadan, Hajj, Muharram, Eid ul Fitr, and Eid ul Adha in {{ now()->year }}.
</p>
            <div class="month-selector">
              <button id="prevMonth" class="btn btn-outline-primary">
                <i class="fas fa-chevron-left me-2"></i> Previous
              </button>
              <div class="text-center">
                <div class="month-title" id="currentMonth">Month</div>
                <div class="year-title" id="currentYearDisplay">Year</div>
                <div class="hijri-display" id="hijriMonthDisplay">Loading...</div>
              </div>
              <button id="nextMonth" class="btn btn-outline-primary">
                Next <i class="fas fa-chevron-right ms-2"></i>
              </button>
            </div>
            
            <div class="calendar-header">
              <div class="row g-0 text-center w-100">
                <div class="col calendar-day-header">Sun</div>
                <div class="col calendar-day-header">Mon</div>
                <div class="col calendar-day-header">Tue</div>
                <div class="col calendar-day-header">Wed</div>
                <div class="col calendar-day-header">Thu</div>
                <div class="col calendar-day-header">Fri</div>
                <div class="col calendar-day-header">Sat</div>
              </div>
            </div>
            
            <div id="calendarDays">
              <div class="row">
                <div class="col-12 text-center py-5">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="text-center mt-4">
              <button id="todayButton" class="btn" style="background: var(--primary-color); color: white;">
                <i class="fas fa-calendar-day me-2"></i> Go to Today
              </button>
            </div>
          </div>
        </section>
        
        <!-- Islamic Months Section -->
        <section class="section bg-white">
          <div class="container">
            <h2 class="section-title text-center">Islamic Hijri Months {{ now()->year }}</h2>
            <p>
The Islamic calendar consists of 12 Hijri months: Muharram, Safar, Rabi al-Awwal, Rabi al-Thani, Jumada al-Awwal, Jumada al-Thani, Rajab, Shaban, Ramadan, Shawwal, Dhul Qadah, and Dhul Hijjah.
</p>

<p>
Each Hijri month has religious significance in Islam. Ramadan is the month of fasting, Dhul Hijjah is the month of Hajj, and Muharram marks the Islamic New Year. 
Learn about all Islamic months and their importance in {{ now()->year }}.
</p>
            <div class="row" id="islamicMonthsContainer">
              ${state.hijriMonths.map((month, index) => `
                <div class="col-md-3 col-sm-6 mb-4">
                  <div class="islamic-month-card" id="month-${index + 1}">
                    <div class="islamic-month-number">${index + 1}</div>
                    <div class="islamic-month-content">
                      <div class="islamic-month-name">${month}</div>
                      <div class="islamic-month-desc">${getMonthDescription(index + 1)}</div>
                    </div>
                  </div>
                </div>
              `).join('')}
            </div>
          </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section">
          <div class="container">
            <h2 class="section-title text-center">Frequently Asked Questions About Islamic Calendar</h2>
            <p class="text-center mb-5" style="color: #666; max-width: 800px; margin: 0 auto 40px;">
              Find answers to common questions about the Islamic Hijri calendar, important dates, and how to convert between Gregorian and Hijri dates. All dates are dynamically updated for the current year.
            </p>
            
            <div class="row justify-content-center">
              <div class="col-lg-8 faq-container">
                <!-- FAQ items will be dynamically inserted here -->
                <div class="text-center py-5">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading FAQs...</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      `;
      
      // Initialize the page
      initIslamicCalendarPage();
      
      // Update location display
      updateLocationDisplay();
      
      // Update local time every second
      setInterval(updateLocalTime, 1000);
    }

    // Update location display
    function updateLocationDisplay() {
      const locationEl = document.getElementById('userLocation');
      if (locationEl) {
        locationEl.textContent = `${state.userLocation.city}, ${state.userLocation.country}`;
      }
    }

    // Update local time
    function updateLocalTime() {
      const timeEl = document.getElementById('localTime');
      if (timeEl) {
        timeEl.textContent = new Date().toLocaleTimeString();
      }
    }

    // Initialize Islamic Calendar page
    async function initIslamicCalendarPage() {
      // Set page title
      document.title = `Islamic Calendar | Hijri Calendar with Important Dates - NextPrayerTime`;
      
      // Get current Hijri date
      await updateCurrentDateDisplay();
      
      // Generate calendar for current month
      await generateCalendar(state.currentDate);
      
      // Load Islamic events
      await loadIslamicEvents();
      
      // Initialize month navigation
      initMonthNavigation();
      
      // Initialize today button
      const todayButton = document.getElementById('todayButton');
      if (todayButton) {
        todayButton.addEventListener('click', function() {
          state.currentDate = new Date();
          generateCalendar(state.currentDate);
          updateCurrentDateDisplay();
        });
      }
      
      // Initialize date conversion form
      const dateConvertForm = document.getElementById('dateConvertForm');
      if (dateConvertForm) {
        dateConvertForm.addEventListener('submit', function(e) {
          e.preventDefault();
          convertDate();
        });
      }
      
      // Check if current month is Ramadan
      checkIfRamadan();
      
      // Initialize FAQ section with dynamic data
      await initFaqSection();
    }

    // Check if current month is Ramadan
    async function checkIfRamadan() {
      if (state.currentHijriDate && state.currentHijriDate.month.number === 9) {
        document.getElementById('ramadanSpecialSection').style.display = 'block';
        updateRamadanCountdown();
      }
    }

    // Update Ramadan countdown
    async function updateRamadanCountdown() {
      const now = new Date();
      
      // Get end of Ramadan date
      const endOfRamadan = await getGregorianDate(9, 30, state.currentHijriDate?.year || 1447);
      if (endOfRamadan) {
        const endDate = new Date(endOfRamadan);
        const daysLeft = Math.ceil((endDate - now) / (1000 * 60 * 60 * 24));
        document.getElementById('ramadanCountdown').innerHTML = `${daysLeft} days remaining`;
      }
    }

    // Update current date display
    async function updateCurrentDateDisplay() {
      const now = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const dateString = now.toLocaleDateString('en-US', options);
      
      document.getElementById('currentDate').textContent = dateString;
      
      try {
        const response = await fetch(`https://api.aladhan.com/v1/gToH/${formatDateForAPI(now)}`);
        const data = await response.json();
        
        if (data.code === 200) {
          const hijri = data.data.hijri;
          const hijriDateString = `${hijri.day} ${hijri.month.en}, ${hijri.year} AH`;
          document.getElementById('hijriDateDisplay').textContent = hijriDateString;
          state.currentHijriDate = hijri;
          
          // Update active month in Islamic months section
          const monthCards = document.querySelectorAll('.islamic-month-card');
          monthCards.forEach(card => card.classList.remove('active'));
          if (monthCards[hijri.month.number - 1]) {
            monthCards[hijri.month.number - 1].classList.add('active');
          }
        }
      } catch (error) {
        console.error('Error fetching Hijri date:', error);
        document.getElementById('hijriDateDisplay').textContent = 'Error loading date';
      }
    }

    // Load Islamic events with accurate dates
    async function loadIslamicEvents() {
      const container = document.getElementById('upcomingEventsContainer');
      if (!container) return;
      
      // Show loading spinner
      container.innerHTML = `
        <div class="col-12 text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">@trans('Loading...')</span>
          </div>
        </div>
      `;
      
      // Get upcoming events with accurate dates
      const upcomingEvents = await getUpcomingIslamicEvents();
      
      if (upcomingEvents.length === 0) {
        container.innerHTML = `
          <div class="col-12 text-center py-5">
            <p class="text-muted">@trans('No upcoming events found')</p>
          </div>
        `;
        return;
      }
      
      container.innerHTML = upcomingEvents.map((event, index) => `
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="event-card">
            <div class="event-card-image" style="background-image: url('${event.image}')">
              <div class="event-countdown">
                <i class="fas fa-clock me-1"></i> ${event.daysUntil} days
              </div>
              <div class="event-overlay-content">
                <h3 class="event-overlay-title">${event.title}</h3>
                <div class="event-overlay-date">
                  ${event.hijriDate}
                </div>
                <div class="event-overlay-gregorian small">
                  ${event.gregorianDate}
                </div>
              </div>
            </div>
            <div class="event-card-content">
              <div class="event-date">
                <i class="fas fa-calendar-day"></i>
                ${event.hijriDate}
              </div>
              <h3 class="event-title">${event.title}</h3>
              <p class="event-desc">${event.description}</p>
              <div class="event-gregorian small text-muted">
                ${event.gregorianDate}
              </div>
            </div>
          </div>
        </div>
      `).join('');
    }

    // Get upcoming Islamic events with accurate dates
    async function getUpcomingIslamicEvents() {
      const events = [];
      const now = new Date();
      const hijriYear = state.currentHijriDate?.year || 1447;
      
      // Get accurate dates for each event
      for (const event of islamicEventsDatabase) {
        try {
          let gregorianDate = await getGregorianDate(event.month, event.day, hijriYear);
          if (!gregorianDate) continue;
          
          let eventDate = new Date(gregorianDate);
          
          // Calculate days until event
          const daysUntil = Math.ceil((eventDate - now) / (1000 * 60 * 60 * 24));
          
          if (daysUntil > 0) {
            // Get Hijri date string
            const hijriResponse = await fetch(`https://api.aladhan.com/v1/gToH/${formatDateForAPI(eventDate)}`);
            const hijriData = await hijriResponse.json();
            
            if (hijriData.code === 200) {
              const hijri = hijriData.data.hijri;
              const hijriDateStr = `${hijri.day} ${hijri.month.en} ${hijri.year} AH`;
              
              events.push({
                ...event,
                daysUntil: daysUntil,
                hijriDate: hijriDateStr,
                gregorianDate: formatDateForDisplay(eventDate)
              });
            }
          }
        } catch (error) {
          console.error('Error processing event:', event.title, error);
        }
      }
      
      // Sort by days until and return top 4
      return events.sort((a, b) => a.daysUntil - b.daysUntil).slice(0, 4);
    }

    // Convert Hijri to Gregorian accurately
    async function getGregorianDate(hijriMonth, hijriDay, hijriYear) {
      try {
        const response = await fetch(`https://api.aladhan.com/v1/hToG/${hijriDay}-${hijriMonth}-${hijriYear}`);
        const data = await response.json();
        
        if (data.code === 200) {
          const gregorian = data.data.gregorian;
          return `${gregorian.year}-${String(gregorian.month.number).padStart(2, '0')}-${String(gregorian.day).padStart(2, '0')}`;
        }
      } catch (error) {
        console.error('Error converting Hijri to Gregorian:', error);
      }
      return null;
    }

    // Convert date between Gregorian and Hijri
    async function convertDate() {
      const gregorianDate = document.getElementById('gregorianDate').value;
      const hijriDay = document.getElementById('hijriDay').value;
      const hijriMonth = document.getElementById('hijriMonth').value;
      const hijriYear = document.getElementById('hijriYear').value;
      
      const resultDiv = document.getElementById('conversionResult');
      const gregorianResult = document.getElementById('gregorianResult');
      const hijriResult = document.getElementById('hijriResult');
      
      if (gregorianDate) {
        try {
          const [year, month, day] = gregorianDate.split('-');
          const response = await fetch(`https://api.aladhan.com/v1/gToH/${day}-${month}-${year}`);
          const data = await response.json();
          
          if (data.code === 200) {
            const hijri = data.data.hijri;
            const date = new Date(gregorianDate);
            
            gregorianResult.innerHTML = `<strong>Gregorian:</strong> ${formatDateForDisplay(date)}`;
            hijriResult.innerHTML = `<strong>Hijri:</strong> ${hijri.day} ${hijri.month.en}, ${hijri.year} AH (${hijri.weekday.en})<br><small class="text-muted">Source: Aladhan API</small>`;
            
            resultDiv.style.display = 'block';
          }
        } catch (error) {
          console.error('Error converting date:', error);
          alert('Error converting date. Please try again.');
        }
      } else if (hijriDay && hijriMonth && hijriYear) {
        try {
          const response = await fetch(`https://api.aladhan.com/v1/hToG/${hijriDay}-${hijriMonth}-${hijriYear}`);
          const data = await response.json();
          
          if (data.code === 200) {
            const gregorian = data.data.gregorian;
            const date = new Date(`${gregorian.year}-${String(gregorian.month.number).padStart(2, '0')}-${String(gregorian.day).padStart(2, '0')}`);
            const monthName = state.hijriMonths[parseInt(hijriMonth) - 1];
            
            gregorianResult.innerHTML = `<strong>Gregorian:</strong> ${formatDateForDisplay(date)}`;
            hijriResult.innerHTML = `<strong>Hijri:</strong> ${hijriDay} ${monthName}, ${hijriYear} AH (${data.data.hijri.weekday.en})<br><small class="text-muted">Source: Aladhan API</small>`;
            
            resultDiv.style.display = 'block';
          }
        } catch (error) {
          console.error('Error converting date:', error);
          alert('Error converting date. Please try again.');
        }
      } else {
        alert('Please enter either a Gregorian date or select a complete Hijri date');
      }
    }

    // Generate calendar for a specific month with 100% accurate dates and highlight today
    async function generateCalendar(date) {
      const year = date.getFullYear();
      const month = date.getMonth();
      const today = new Date();
      const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;
      
      document.getElementById('currentMonth').textContent = state.gregorianMonths[month];
      document.getElementById('currentYearDisplay').textContent = year;
      
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const prevMonthDays = new Date(year, month, 0).getDate();
      let prevMonthShow = firstDay;
      
      let calendarHTML = '';
      let dayCount = 1;
      let nextMonthDay = 1;
      
      const cacheKey = `${year}-${month}`;
      let hijriDates;
      
      if (state.calendarCache[cacheKey]) {
        hijriDates = state.calendarCache[cacheKey];
      } else {
        hijriDates = await getAccurateHijriDatesForMonth(year, month + 1);
        state.calendarCache[cacheKey] = hijriDates;
      }
      
      for (let i = 0; i < 6; i++) {
        calendarHTML += '<div class="row g-0">';
        
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            const day = prevMonthDays - (prevMonthShow - j - 1);
            calendarHTML += `
              <div class="col calendar-day text-muted">
                <div class="calendar-day-number">${day}</div>
              </div>
            `;
          } else if (dayCount <= daysInMonth) {
            const hijriDate = hijriDates[dayCount - 1] || {};
            const events = hijriDate.day ? getEventsForHijriDate({
              month: hijriDate.month?.number,
              day: hijriDate.day
            }) : [];
            
            // Check if this is today's date
            const isToday = isCurrentMonth && dayCount === today.getDate();
            
            calendarHTML += `
              <div class="col calendar-day ${isToday ? 'today' : ''}">
                <div class="calendar-day-number">${dayCount}</div>
                ${hijriDate.day ? `
                  <div class="date-info" title="${hijriDate.month?.en} ${hijriDate.day}, ${hijriDate.year} AH">
                    ${hijriDate.day} ${hijriDate.month?.en?.substring(0, 3)}
                  </div>
                ` : ''}
                ${events.map(event => `
                  <div class="islamic-event ${event.important ? 'important-event' : ''}" 
                       title="${event.description} - ${hijriDate.month?.en} ${hijriDate.day}">${event.title}</div>
                `).join('')}
              </div>
            `;
            dayCount++;
          } else {
            calendarHTML += `
              <div class="col calendar-day text-muted">
                <div class="calendar-day-number">${nextMonthDay}</div>
              </div>
            `;
            nextMonthDay++;
          }
        }
        
        calendarHTML += '</div>';
        if (dayCount > daysInMonth && nextMonthDay > 7) break;
      }
      
      document.getElementById('calendarDays').innerHTML = calendarHTML;
      
      if (hijriDates.length > 0 && hijriDates[0]) {
        document.getElementById('hijriMonthDisplay').textContent = 
          `${hijriDates[0].month?.en || ''} ${hijriDates[0].year || ''} AH`;
      }
    }

    // Get accurate Hijri dates for a Gregorian month by fetching each day individually
    async function getAccurateHijriDatesForMonth(year, month) {
      try {
        const daysInMonth = new Date(year, month, 0).getDate();
        const hijriDates = [];
        
        for (let day = 1; day <= daysInMonth; day++) {
          try {
            const response = await fetch(`https://api.aladhan.com/v1/gToH/${String(day).padStart(2, '0')}-${String(month).padStart(2, '0')}-${year}`);
            const data = await response.json();
            
            if (data.code === 200) {
              hijriDates.push(data.data.hijri);
            } else {
              hijriDates.push(null);
            }
            
            await new Promise(resolve => setTimeout(resolve, 100));
          } catch (error) {
            console.error(`Error fetching date for ${day}-${month}-${year}:`, error);
            hijriDates.push(null);
          }
        }
        
        return hijriDates;
      } catch (error) {
        console.error('Error fetching Hijri dates for month:', error);
        return [];
      }
    }

    // Get events for a specific Hijri date
    function getEventsForHijriDate(hijriDate) {
      if (!hijriDate || !hijriDate.day || !hijriDate.month) return [];
      return islamicEventsDatabase.filter(event => 
        event.month === parseInt(hijriDate.month) && 
        event.day === parseInt(hijriDate.day)
      );
    }

    // Initialize month navigation
    function initMonthNavigation() {
      const prevMonthButton = document.getElementById('prevMonth');
      const nextMonthButton = document.getElementById('nextMonth');
      
      if (prevMonthButton) {
        prevMonthButton.addEventListener('click', async function() {
          state.currentDate = new Date(
            state.currentDate.getFullYear(),
            state.currentDate.getMonth() - 1,
            1
          );
          
          document.getElementById('calendarDays').innerHTML = `
            <div class="row">
              <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          `;
          
          await generateCalendar(state.currentDate);
        });
      }
      
      if (nextMonthButton) {
        nextMonthButton.addEventListener('click', async function() {
          state.currentDate = new Date(
            state.currentDate.getFullYear(),
            state.currentDate.getMonth() + 1,
            1
          );
          
          document.getElementById('calendarDays').innerHTML = `
            <div class="row">
              <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          `;
          
          await generateCalendar(state.currentDate);
        });
      }
    }

    const islamicEventsDatabase = [
      { 
        month: 1, 
        day: 10, 
        title: 'Ashura', 
        description: 'Day of Ashura - 10th Muharram', 
        important: true,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      },
      { 
        month: 3, 
        day: 12, 
        title: 'Mawlid', 
        description: 'Birth of Prophet Muhammad (PBUH)', 
        important: true,
        image: 'https://images.unsplash.com/photo-1596093019686-550d740a2870?q=80&w=1370&auto=format&fit=crop'
      },
      { 
        month: 7, 
        day: 27, 
        title: 'Isra Miraj', 
        description: 'Night Journey and Ascension', 
        important: true,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      },
      { 
        month: 8, 
        day: 15, 
        title: 'Bara\'ah', 
        description: 'Night of Forgiveness', 
        important: false,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      },
      { 
        month: 9, 
        day: 1, 
        title: 'Ramadan', 
        description: 'Start of Ramadan', 
        important: true,
        image: 'https://images.unsplash.com/photo-1596093019686-550d740a2870?q=80&w=1370&auto=format&fit=crop'
      },
      { 
        month: 9, 
        day: 27, 
        title: 'Qadr', 
        description: 'Laylat al-Qadr', 
        important: true,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      },
      { 
        month: 10, 
        day: 1, 
        title: 'Eid Fitr', 
        description: 'Eid al-Fitr', 
        important: true,
        image: 'https://images.unsplash.com/photo-1743450675048-03e0c6b13720?q=80&w=1374&auto=format&fit=crop'
      },
      { 
        month: 12, 
        day: 8, 
        title: 'Hajj', 
        description: 'Start of Hajj', 
        important: true,
        image: 'https://images.unsplash.com/photo-1716361897615-08458b7b3078?q=80&w=1527&auto=format&fit=crop'
      },
      { 
        month: 12, 
        day: 9, 
        title: 'Arafah', 
        description: 'Day of Arafah', 
        important: true,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      },
      { 
        month: 12, 
        day: 10, 
        title: 'Eid Adha', 
        description: 'Eid al-Adha', 
        important: true,
        image: 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop'
      }
    ];

    // Helper function to get month description
    function getMonthDescription(month) {
      const descriptions = {
        1: "Sacred month, start of Hijri year",
        2: "Second month of the Islamic calendar",
        3: "Birth month of Prophet Muhammad (PBUH)",
        4: "Second Rabi month",
        5: "First Jumada month",
        6: "Second Jumada month",
        7: "Sacred month, month of Isra and Miraj",
        8: "Month before Ramadan",
        9: "Month of fasting and Quran revelation",
        10: "Month of Eid al-Fitr",
        11: "Sacred month, month of Hajj preparation",
        12: "Sacred month, month of Hajj and Eid al-Adha"
      };
      return descriptions[month] || "Islamic month";
    }
  </script>
</body>
</html>