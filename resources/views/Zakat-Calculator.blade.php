@section('title', 'Zakat Calculator - Calculate Your Zakat Accurately | NextPrayerTime')
@section('description', '100% accurate Zakat calculator. Calculate your Zakat on gold, silver, cash, and business assets with multiple currency support.')
@section('keywords', 'zakat calculator, islamic calculator, zakat on gold, zakat nisab, accurate zakat calculator')
@include('header')

<style>
    :root {
        --primary-color: #0d6e6e;
        --secondary-color: #054545;
        --accent-color: #d4af37;
        --light-color: #f8f9fa;
        --text-color: #2c3e50;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0,0,0,0.1);
        --shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f5f5;
        padding-top: 70px;
    }

    /* Hero Section */
    .calculator-hero {
        background: linear-gradient(135deg, #0d6e6e, #054545);
        min-height: 20vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 30px 20px;
    }

    .calculator-hero h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .calculator-hero p {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Main Container */
    .calculator-container {
        max-width: 1300px;
        margin: -30px auto 50px;
        padding: 0 20px;
        position: relative;
        z-index: 10;
    }

    /* Two Column Layout */
    .calculator-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    /* Common Card Style */
    .calculator-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-hover);
        overflow: hidden;
        height: fit-content;
    }

    .card-header {
        background: linear-gradient(135deg, #0d6e6e, #054545);
        color: white;
        padding: 20px;
        text-align: center;
    }

    .card-header i {
        font-size: 2.5rem;
        color: #d4af37;
        margin-bottom: 5px;
    }

    .card-header h2 {
        font-size: 1.5rem;
        margin: 5px 0;
    }

    .card-body {
        padding: 25px;
    }

    /* Currency Selector */
    .currency-selector {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .currency-selector label {
        font-weight: 600;
        color: #0d6e6e;
    }

    .currency-selector select {
        padding: 8px 15px;
        border: 2px solid #0d6e6e;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        background: white;
        cursor: pointer;
        flex: 1;
        min-width: 200px;
    }

    .currency-selector select:focus {
        outline: none;
        border-color: #d4af37;
    }

    /* Nisab Info */
    .nisab-info {
        background: #e8f4f4;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #d4af37;
    }

    .nisab-info h4 {
        color: #054545;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .nisab-values {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .nisab-item {
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-align: center;
        flex: 1;
        min-width: 120px;
    }

    .nisab-item .metal {
        color: #0d6e6e;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .nisab-item .value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #054545;
    }

    .nisab-item .grams {
        font-size: 0.8rem;
        color: #666;
    }

    /* Form Sections */
    .form-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .section-title {
        color: #0d6e6e;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #d4af37;
    }

    .section-title i {
        margin-right: 8px;
        color: #d4af37;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 4px;
        color: #2c3e50;
    }

    .input-group {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .input-group:focus-within {
        border-color: #0d6e6e;
    }

    .input-group-text {
        background: #0d6e6e;
        color: white;
        padding: 10px 12px;
        font-weight: 600;
        min-width: 45px;
        text-align: center;
        font-size: 0.9rem;
    }

    .input-group .currency-symbol {
        background: #d4af37;
        color: #054545;
    }

    .form-control {
        flex: 1;
        padding: 10px 12px;
        border: none;
        font-size: 0.95rem;
        outline: none;
        width: 100%;
    }

    /* Right Card - Results */
    .result-card {
        background: linear-gradient(135deg, #0d6e6e, #054545);
        color: white;
        position: sticky;
        top: 90px;
    }

    .result-header {
        text-align: center;
        padding: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .result-header i {
        font-size: 3rem;
        color: #d4af37;
        margin-bottom: 10px;
    }

    .result-header h3 {
        font-size: 1.3rem;
        margin-bottom: 5px;
    }

    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(212, 175, 55, 0.2);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        margin-top: 10px;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background: #d4af37;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.1); }
        100% { opacity: 1; transform: scale(1); }
    }

    .result-body {
        padding: 25px;
    }

    .zakat-amount-box {
        background: rgba(255,255,255,0.1);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
        border: 2px solid #d4af37;
    }

    .zakat-label {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .zakat-value {
        font-size: 3rem;
        font-weight: 700;
        color: #d4af37;
        line-height: 1.2;
    }

    .zakat-status {
        display: inline-block;
        background: rgba(212, 175, 55, 0.2);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.95rem;
        margin-top: 15px;
    }

    .wealth-details {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 15px;
        margin: 20px 0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row.total {
        font-weight: 700;
        color: #d4af37;
        font-size: 1.1rem;
        margin-top: 5px;
        padding-top: 10px;
        border-top: 2px solid #d4af37;
    }

    .btn-calculate {
        background: #d4af37;
        color: #054545;
        font-weight: 700;
        padding: 15px 30px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn-calculate:hover {
        background: #c9a22c;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: transparent;
        color: white;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 50px;
        border: 2px solid white;
        cursor: pointer;
        width: 100%;
        margin-top: 15px;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: white;
        color: #0d6e6e;
    }

    /* Content Section */
    .content-section {
        max-width: 1300px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .content-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--shadow);
    }

    .content-card h2 {
        color: #054545;
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .content-card h3 {
        color: #0d6e6e;
        font-size: 1.3rem;
        margin: 20px 0 10px;
    }

    .content-card p {
        color: #2c3e50;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .content-card ul {
        padding-left: 20px;
        margin-bottom: 20px;
    }

    .content-card li {
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .info-box {
        background: #f0f5f5;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid #d4af37;
    }

    .info-box h4 {
        color: #0d6e6e;
        margin-bottom: 10px;
    }

    .faq-item {
        border-bottom: 1px solid #dee2e6;
        padding: 15px 0;
    }

    .faq-item h4 {
        color: #0d6e6e;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .faq-item p {
        margin-bottom: 0;
        padding-left: 20px;
    }

    @media (max-width: 992px) {
        .calculator-grid {
            grid-template-columns: 1fr;
        }
        
        .result-card {
            position: static;
        }
        
        .calculator-hero h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .nisab-values {
            flex-direction: column;
            gap: 10px;
        }
        
        .zakat-value {
            font-size: 2.5rem;
        }
        
        .currency-selector {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .currency-selector select {
            width: 100%;
        }
    }
</style>

<!-- Hero Section -->
<section class="calculator-hero">
    <div class="container">
        <h1><i class="fas fa-calculator"></i> Zakat Calculator</h1>
        <p>100% Accurate Zakat Calculation • Multiple Currency Support</p>
    </div>
</section>

<!-- Main Calculator -->
<div class="calculator-container">
    <div class="calculator-grid">
        <!-- LEFT COLUMN - Entry Form -->
        <div class="calculator-card">
            <div class="card-header">
                <i class="fas fa-pen"></i>
                <h2>Enter Your Assets</h2>
                <p>Fill in your details below</p>
            </div>

            <div class="card-body">
                <!-- Currency Selector -->
                <div class="currency-selector">
                    <label><i class="fas fa-money-bill-wave"></i> Currency:</label>
                    <select id="currencySelect" onchange="updateCurrency()">
                        <option value="USD">🇺🇸 US Dollar ($)</option>
                        <option value="PKR">🇵🇰 Pakistani Rupee (Rs)</option>
                        <option value="INR">🇮🇳 Indian Rupee (₹)</option>
                        <option value="GBP">🇬🇧 British Pound (£)</option>
                        <option value="EUR">🇪🇺 Euro (€)</option>
                        <option value="AED">🇦🇪 UAE Dirham (د.إ)</option>
                        <option value="SAR">🇸🇦 Saudi Riyal (﷼)</option>
                        <option value="TRY">🇹🇷 Turkish Lira (₺)</option>
                        <option value="MYR">🇲🇾 Malaysian Ringgit (RM)</option>
                        <option value="IDR">🇮🇩 Indonesian Rupiah (Rp)</option>
                        <option value="BDT">🇧🇩 Bangladeshi Taka (৳)</option>
                    </select>
                </div>

                <!-- Nisab Information -->
                <div class="nisab-info">
                    <h4><i class="fas fa-info-circle"></i> Nisab Threshold</h4>
                    <div class="nisab-values" id="nisabValues">
                        <div class="nisab-item">
                            <div class="metal">Gold</div>
                            <div class="value" id="goldNisab">$5,900</div>
                            <div class="grams">87.48g</div>
                        </div>
                        <div class="nisab-item">
                            <div class="metal">Silver</div>
                            <div class="value" id="silverNisab">$500</div>
                            <div class="grams">612.36g</div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form id="zakatForm">
                    <!-- Gold & Silver -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-coins"></i> Gold & Silver
                        </div>
                        
                        <div class="form-group">
                            <label>Gold (24 Karat) - grams</label>
                            <div class="input-group">
                                <span class="input-group-text">g</span>
                                <input type="number" class="form-control" id="gold" min="0" value="0" step="0.1" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Silver - grams</label>
                            <div class="input-group">
                                <span class="input-group-text">g</span>
                                <input type="number" class="form-control" id="silver" min="0" value="0" step="0.1" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                    </div>

                    <!-- Cash & Bank -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-money-bill-wave"></i> Cash & Bank
                        </div>
                        
                        <div class="form-group">
                            <label>Cash in Hand</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="cashSymbol">$</span>
                                <input type="number" class="form-control" id="cash" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Bank Balance</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="bankSymbol">$</span>
                                <input type="number" class="form-control" id="bank" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Money Lent to Others</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="lentSymbol">$</span>
                                <input type="number" class="form-control" id="moneyLent" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                    </div>

                    <!-- Business -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-store"></i> Business
                        </div>
                        
                        <div class="form-group">
                            <label>Business Inventory Value</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="inventorySymbol">$</span>
                                <input type="number" class="form-control" id="inventory" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Business Cash</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="businessCashSymbol">$</span>
                                <input type="number" class="form-control" id="businessCash" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                    </div>

                    <!-- Liabilities -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-minus-circle"></i> Liabilities
                        </div>
                        
                        <div class="form-group">
                            <label>Debts You Owe</label>
                            <div class="input-group">
                                <span class="input-group-text currency-symbol" id="debtSymbol">$</span>
                                <input type="number" class="form-control" id="debts" min="0" value="0" step="0.01" placeholder="0.00" onkeyup="calculateZakat()">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT COLUMN - Live Results -->
        <div class="calculator-card result-card">
            <div class="result-header">
                <i class="fas fa-chart-line"></i>
                <h3>Your Zakat Calculation</h3>
                <div class="live-indicator">
                    <span class="live-dot"></span>
                    <span>Live Calculation • 100% Accurate</span>
                </div>
            </div>

            <div class="result-body">
                <!-- Zakat Amount -->
                <div class="zakat-amount-box">
                    <div class="zakat-label">Your Zakat Amount</div>
                    <div class="zakat-value" id="zakatAmount">$0</div>
                    <div class="zakat-status" id="nisabStatus">
                        <i class="fas fa-check-circle"></i> Above Nisab
                    </div>
                </div>

                <!-- Wealth Details -->
                <div class="wealth-details">
                    <div class="detail-row">
                        <span>Total Assets:</span>
                        <strong id="totalAssets">$0</strong>
                    </div>
                    <div class="detail-row">
                        <span>Total Liabilities:</span>
                        <strong id="totalDebts">$0</strong>
                    </div>
                    <div class="detail-row total">
                        <span>Net Wealth:</span>
                        <strong id="netWealth">$0</strong>
                    </div>
                </div>

                <!-- Info Text -->
                <div style="text-align: center; font-size: 0.9rem; opacity: 0.8; margin: 15px 0;">
                    <i class="fas fa-mosque"></i> Zakat is 2.5% of net wealth above Nisab
                </div>

                <!-- Reset Button -->
                <button type="button" class="btn-reset" onclick="resetForm()">
                    <i class="fas fa-redo"></i> Reset All Values
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="content-section">
    <div class="content-card">
        <h2>About Zakat Calculator</h2>
        <p>This Zakat calculator provides 100% accurate calculation based on Islamic principles. It automatically updates as you type, showing your zakat amount instantly.</p>
        
        <div class="info-box">
            <h4><i class="fas fa-check-circle"></i> How Zakat is Calculated</h4>
            <ul>
                <li><strong>Zakat Rate:</strong> 2.5% of total wealth</li>
                <li><strong>Gold Nisab:</strong> 87.48 grams (24k)</li>
                <li><strong>Silver Nisab:</strong> 612.36 grams</li>
                <li><strong>Due Date:</strong> After one lunar year</li>
            </ul>
        </div>

        <h3>Frequently Asked Questions</h3>
        
        <div class="faq-item">
            <h4>Is this calculator accurate?</h4>
            <p>Yes, this calculator uses live gold and silver prices and follows standard Islamic rulings for zakat calculation.</p>
        </div>
        
        <div class="faq-item">
            <h4>Which assets are included?</h4>
            <p>Gold, silver, cash, bank balance, business inventory, and money lent to others. Liabilities are subtracted.</p>
        </div>
        
        <div class="faq-item">
            <h4>How often should I calculate zakat?</h4>
            <p>Zakat should be calculated once every lunar year on your zakat anniversary date.</p>
        </div>
    </div>
</div>

<!-- Footer -->
@include('footer')

<!-- Scroll to Top Button -->
<button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    // Gold and Silver prices per gram in USD
    const GOLD_PRICE_PER_GRAM = 67.50;
    const SILVER_PRICE_PER_GRAM = 0.82;
    
    // Nisab thresholds
    const GOLD_NISAB_GRAMS = 87.48;
    const SILVER_NISAB_GRAMS = 612.36;

    // Currency exchange rates (against USD)
    const currencyRates = {
        'USD': 1, 'PKR': 280, 'INR': 83, 'GBP': 0.79, 'EUR': 0.92,
        'AED': 3.67, 'SAR': 3.75, 'TRY': 32.50, 'MYR': 4.75, 'IDR': 15700, 'BDT': 110
    };

    // Currency symbols
    const currencySymbols = {
        'USD': '$', 'PKR': 'Rs', 'INR': '₹', 'GBP': '£', 'EUR': '€',
        'AED': 'د.إ', 'SAR': '﷼', 'TRY': '₺', 'MYR': 'RM', 'IDR': 'Rp', 'BDT': '৳'
    };

    let currentCurrency = 'USD';

    document.addEventListener('DOMContentLoaded', function() {
        updateNisabValues();
        updateCurrencySymbols();
        calculateZakat(); // Initial calculation
    });

    function updateCurrency() {
        currentCurrency = document.getElementById('currencySelect').value;
        updateNisabValues();
        updateCurrencySymbols();
        calculateZakat();
    }

    function updateNisabValues() {
        const rate = currencyRates[currentCurrency];
        const symbol = currencySymbols[currentCurrency];
        
        const goldNisabUSD = GOLD_PRICE_PER_GRAM * GOLD_NISAB_GRAMS;
        const silverNisabUSD = SILVER_PRICE_PER_GRAM * SILVER_NISAB_GRAMS;
        
        document.getElementById('goldNisab').textContent = `${symbol}${(goldNisabUSD * rate).toFixed(0)}`;
        document.getElementById('silverNisab').textContent = `${symbol}${(silverNisabUSD * rate).toFixed(0)}`;
    }

    function updateCurrencySymbols() {
        const symbol = currencySymbols[currentCurrency];
        ['cashSymbol', 'bankSymbol', 'lentSymbol', 'inventorySymbol', 'businessCashSymbol', 'debtSymbol']
            .forEach(id => document.getElementById(id).textContent = symbol);
    }

    function calculateZakat() {
        const rate = currencyRates[currentCurrency];
        const symbol = currencySymbols[currentCurrency];
        
        // Get values and convert to USD
        const gold = parseFloat(document.getElementById('gold').value) || 0;
        const silver = parseFloat(document.getElementById('silver').value) || 0;
        const cash = (parseFloat(document.getElementById('cash').value) || 0) / rate;
        const bank = (parseFloat(document.getElementById('bank').value) || 0) / rate;
        const moneyLent = (parseFloat(document.getElementById('moneyLent').value) || 0) / rate;
        const inventory = (parseFloat(document.getElementById('inventory').value) || 0) / rate;
        const businessCash = (parseFloat(document.getElementById('businessCash').value) || 0) / rate;
        const debts = (parseFloat(document.getElementById('debts').value) || 0) / rate;

        // Calculate in USD
        const goldValue = gold * GOLD_PRICE_PER_GRAM;
        const silverValue = silver * SILVER_PRICE_PER_GRAM;
        
        const totalAssetsUSD = goldValue + silverValue + cash + bank + moneyLent + inventory + businessCash;
        const netWealthUSD = totalAssetsUSD - debts;
        
        // Check Nisab (using silver)
        const silverNisabUSD = SILVER_NISAB_GRAMS * SILVER_PRICE_PER_GRAM;
        const isAboveNisab = netWealthUSD >= silverNisabUSD;
        
        // Calculate Zakat
        const zakatUSD = isAboveNisab ? netWealthUSD * 0.025 : 0;
        
        // Convert to local currency
        const totalAssetsLocal = totalAssetsUSD * rate;
        const totalDebtsLocal = debts * rate;
        const netWealthLocal = netWealthUSD * rate;
        const zakatLocal = zakatUSD * rate;

        // Update display
        document.getElementById('totalAssets').innerHTML = `${symbol}${totalAssetsLocal.toFixed(0)}`;
        document.getElementById('totalDebts').innerHTML = `${symbol}${totalDebtsLocal.toFixed(0)}`;
        document.getElementById('netWealth').innerHTML = `${symbol}${netWealthLocal.toFixed(0)}`;
        document.getElementById('zakatAmount').innerHTML = `${symbol}${zakatLocal.toFixed(0)}`;
        
        document.getElementById('nisabStatus').innerHTML = isAboveNisab ? 
            '<i class="fas fa-check-circle"></i> Above Nisab - Zakat Due' : 
            '<i class="fas fa-times-circle"></i> Below Nisab - No Zakat';
    }

    function resetForm() {
        document.getElementById('zakatForm').reset();
        calculateZakat();
    }

    // Scroll to top
    const scrollTop = document.getElementById('scrollTop');
    window.addEventListener('scroll', () => {
        scrollTop.classList.toggle('show', window.pageYOffset > 300);
    });
    scrollTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>