@section('title','Dhikr and Dua | Digital Tasbeeh Counter')
@section('description','Keep track of your dhikr and supplications with this beautiful digital counter')
@section('keywords','Dhikr and Dua,Digital Tasbeeh Counter,Dua & Azkar')
@include('header')

  <!-- Main Content -->
  <div id="app">
    <!-- Hero Section -->
    <section class="hero text-white">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">Digital Tasbeeh Counter</h1>
            <p class="lead mb-5">Keep track of your dhikr and supplications with this beautiful digital counter</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Tasbeeh Counter Section -->
    <section class="section">
      <div class="container">
        <div class="tasbeeh-counter-container">
          <h2 class="section-title text-center">Tasbeeh Counter</h2>
          
          <div class="tasbeeh-card">
            <div class="dhikr-text" id="currentDhikr">سُبْحَانَ اللَّهِ</div>
            <div class="counter-display" id="counter">0</div>
            
            <div class="counter-controls">
              <button class="counter-btn decrement-btn" id="decrementBtn">
                <i class="fas fa-minus"></i>
              </button>
              <button class="counter-btn reset-btn" id="resetBtn">
                <i class="fas fa-redo"></i>
              </button>
              <button class="counter-btn increment-btn" id="incrementBtn">
                <i class="fas fa-plus"></i>
              </button>
            </div>
            
            <div class="text-center">
              <button class="btn btn-primary btn-lg" id="saveBtn">
                <i class="fas fa-save me-2"></i> Save Count
              </button>
            </div>
          </div>
          
          <div class="tasbeeh-card dhikr-selector">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 style="color: var(--primary-color); margin: 0;">
                <i class="fas fa-list-ul me-2"></i> Select Dhikr
              </h3>
              <button class="btn btn-sm btn-outline-danger" id="clearAllDhikrBtn">
                <i class="fas fa-trash-alt me-1"></i> Clear All
              </button>
            </div>
            
            <div id="dhikrOptions">
              <!-- Dhikr options will be loaded here -->
            </div>
          </div>
          
          <div class="tasbeeh-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 style="color: var(--primary-color); margin: 0;">
                <i class="fas fa-history me-2"></i> Your Dhikr History
              </h3>
              <button class="btn btn-sm btn-outline-danger" id="clearHistoryBtn">
                <i class="fas fa-trash-alt me-1"></i> Clear History
              </button>
            </div>
            
            <div id="dhikrHistory">
              <p class="text-center text-muted">Your dhikr history will appear here</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
 @include('footer')
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Set current year in footer
      document.getElementById('currentYear').textContent = new Date().getFullYear();
      
      // Initialize Tasbeeh Counter
      initTasbeehCounter();
    });

    // Tasbeeh Counter Application
    const tasbeehCounter = {
      count: 0,
      currentDhikr: null,
      history: [],
      dhikrOptions: [
        {
          id: 1,
          arabic: 'سُبْحَانَ اللَّهِ',
          english: 'Subhan Allah (Glory be to Allah)',
          translation: 'Glory be to Allah',
          count: 0
        },
        {
          id: 2,
          arabic: 'الْحَمْدُ لِلَّهِ',
          english: 'Alhamdulillah (Praise be to Allah)',
          translation: 'Praise be to Allah',
          count: 0
        },
        {
          id: 3,
          arabic: 'اللَّهُ أَكْبَرُ',
          english: 'Allahu Akbar (Allah is the Greatest)',
          translation: 'Allah is the Greatest',
          count: 0
        },
        {
          id: 4,
          arabic: 'لَا إِلَهَ إِلَّا اللَّهُ',
          english: 'La ilaha illallah (There is no god but Allah)',
          translation: 'There is no god but Allah',
          count: 0
        },
        {
          id: 5,
          arabic: 'أَسْتَغْفِرُ اللَّهَ',
          english: 'Astaghfirullah (I seek forgiveness from Allah)',
          translation: 'I seek forgiveness from Allah',
          count: 0
        },
        {
          id: 6,
          arabic: 'سُبْحَانَ اللَّهِ وَبِحَمْدِهِ',
          english: 'Subhan Allah wa bihamdihi (Glory be to Allah and Praise Him)',
          translation: 'Glory be to Allah and Praise Him',
          count: 0
        }
      ],
      
      init: function() {
        // Load saved data from localStorage
        this.loadData();
        
        // Set first dhikr as default
        if (this.dhikrOptions.length > 0) {
          this.currentDhikr = this.dhikrOptions[0];
          this.updateDhikrDisplay();
        }
        
        // Initialize buttons
        document.getElementById('incrementBtn').addEventListener('click', () => this.increment());
        document.getElementById('decrementBtn').addEventListener('click', () => this.decrement());
        document.getElementById('resetBtn').addEventListener('click', () => this.reset());
        document.getElementById('saveBtn').addEventListener('click', () => this.saveCount());
        document.getElementById('clearHistoryBtn').addEventListener('click', () => this.clearHistory());
        document.getElementById('clearAllDhikrBtn').addEventListener('click', () => this.clearAllDhikrCounts());
        
        // Load dhikr options
        this.loadDhikrOptions();
        
        // Load history
        this.loadHistory();
      },
      
      increment: function() {
        this.count++;
        this.updateCounterDisplay();
        document.getElementById('counter').classList.add('pulse');
        setTimeout(() => {
          document.getElementById('counter').classList.remove('pulse');
        }, 500);
      },
      
      decrement: function() {
        if (this.count > 0) {
          this.count--;
          this.updateCounterDisplay();
        }
      },
      
      reset: function() {
        this.count = 0;
        this.updateCounterDisplay();
      },
      
      updateCounterDisplay: function() {
        document.getElementById('counter').textContent = this.count;
      },
      
      updateDhikrDisplay: function() {
        if (this.currentDhikr) {
          document.getElementById('currentDhikr').textContent = this.currentDhikr.arabic;
        }
      },
      
      selectDhikr: function(dhikrId) {
        // Save current count before switching
        if (this.currentDhikr && this.count > 0) {
          this.currentDhikr.count = this.count;
        }
        
        // Find new dhikr
        const selectedDhikr = this.dhikrOptions.find(d => d.id === dhikrId);
        if (selectedDhikr) {
          this.currentDhikr = selectedDhikr;
          this.count = selectedDhikr.count || 0;
          this.updateDhikrDisplay();
          this.updateCounterDisplay();
          
          // Update active state in UI
          document.querySelectorAll('.dhikr-option').forEach(option => {
            option.classList.remove('active');
            if (parseInt(option.dataset.id) === dhikrId) {
              option.classList.add('active');
            }
          });
        }
      },
      
      saveCount: function() {
        if (this.currentDhikr && this.count > 0) {
          // Update current dhikr count
          this.currentDhikr.count = this.count;
          
          // Add to history
          const historyItem = {
            dhikr: this.currentDhikr.english,
            count: this.count,
            date: new Date().toLocaleString()
          };
          this.history.unshift(historyItem); // Add to beginning of array
          
          // Save data
          this.saveData();
          
          // Reload history
          this.loadHistory();
          
          // Show success message
          alert(`Saved ${this.count} ${this.currentDhikr.english}`);
        } else {
          alert('Please count some dhikr before saving');
        }
      },
      
      clearHistory: function() {
        if (confirm('Are you sure you want to clear all your dhikr history? This cannot be undone.')) {
          this.history = [];
          this.saveData();
          this.loadHistory();
          alert('History cleared successfully');
        }
      },
      
      clearDhikrCount: function(dhikrId) {
        if (confirm('Are you sure you want to reset the count for this dhikr?')) {
          const dhikr = this.dhikrOptions.find(d => d.id === dhikrId);
          if (dhikr) {
            dhikr.count = 0;
            
            // If this is the current dhikr, reset the counter display
            if (this.currentDhikr && this.currentDhikr.id === dhikrId) {
              this.count = 0;
              this.updateCounterDisplay();
            }
            
            this.saveData();
            this.loadDhikrOptions();
          }
        }
      },
      
      clearAllDhikrCounts: function() {
        if (confirm('Are you sure you want to reset all dhikr counts? This cannot be undone.')) {
          this.dhikrOptions.forEach(dhikr => {
            dhikr.count = 0;
          });
          
          // Reset current counter if it's set
          if (this.currentDhikr) {
            this.count = 0;
            this.updateCounterDisplay();
          }
          
          this.saveData();
          this.loadDhikrOptions();
          alert('All dhikr counts have been reset');
        }
      },
      
      loadDhikrOptions: function() {
        const container = document.getElementById('dhikrOptions');
        container.innerHTML = this.dhikrOptions.map(dhikr => `
          <div class="dhikr-option ${dhikr.id === this.currentDhikr?.id ? 'active' : ''}" 
               data-id="${dhikr.id}" onclick="tasbeehCounter.selectDhikr(${dhikr.id})">
            <div class="arabic">${dhikr.arabic}</div>
            <div class="english">
              <div class="fw-bold">${dhikr.english}</div>
              <small class="text-muted">${dhikr.translation}</small>
            </div>
            <div class="count">${dhikr.count || 0}</div>
            <button class="dhikr-clear-btn" onclick="event.stopPropagation(); tasbeehCounter.clearDhikrCount(${dhikr.id})" 
                    title="Reset count for this dhikr">
              <i class="fas fa-times"></i>
            </button>
          </div>
        `).join('');
      },
      
      loadHistory: function() {
        const container = document.getElementById('dhikrHistory');
        
        if (this.history.length === 0) {
          container.innerHTML = '<p class="text-center text-muted">Your dhikr history will appear here</p>';
          return;
        }
        
        container.innerHTML = `
          <div class="history-card">
            ${this.history.map(item => `
              <div class="history-item">
                <div>
                  <strong>${item.dhikr}</strong>
                  <div class="text-muted small">${item.date}</div>
                </div>
                <div class="fw-bold" style="color: var(--primary-color);">${item.count}</div>
              </div>
            `).join('')}
          </div>
        `;
      },
      
      saveData: function() {
        const data = {
          dhikrOptions: this.dhikrOptions,
          history: this.history
        };
        localStorage.setItem('tasbeehCounterData', JSON.stringify(data));
      },
      
      loadData: function() {
        const savedData = localStorage.getItem('tasbeehCounterData');
        if (savedData) {
          const data = JSON.parse(savedData);
          this.dhikrOptions = data.dhikrOptions || this.dhikrOptions;
          this.history = data.history || [];
        }
      }
    };

    // Initialize the Tasbeeh Counter
    function initTasbeehCounter() {
      tasbeehCounter.init();
      
      // Keyboard support
      document.addEventListener('keydown', function(e) {
        if (e.code === 'Space' || e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          tasbeehCounter.increment();
        } else if (e.key === 'r' || e.key === 'R') {
          tasbeehCounter.reset();
        } else if (e.key === 's' || e.key === 'S') {
          tasbeehCounter.saveCount();
        } else if (e.key === 'c' || e.key === 'C') {
          if (e.ctrlKey) {
            tasbeehCounter.clearAllDhikrCounts();
          } else {
            tasbeehCounter.clearHistory();
          }
        }
      });
    }
  </script>
</body>
</html>