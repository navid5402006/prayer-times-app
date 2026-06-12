@section('title', 'Support Us - Donate for Islamic Dawah')
@section('description', 'Support our mission to provide accurate prayer times and Islamic content. Your donations help us serve the Ummah better.')
@section('keywords','donate, sadaqah, zakat, islamic charity, support dawah')
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')

@include('header')

<style>
    /* === DONATION PAGE STYLES === */
    :root {
        --primary: rgb(13 110 110);
        --primary-light: rgb(13 110 110 / 0.1);
        --primary-medium: rgb(13 110 110 / 0.5);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f7fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Hero Section */
    .donation-hero {
        background: linear-gradient(135deg, var(--primary) 0%, rgb(13 90 90) 100%);
        padding: 60px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .donation-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M50 15 L61 40 L88 44 L67 62 L72 90 L50 76 L28 90 L33 62 L12 44 L39 40 Z" fill="white"/></svg>') repeat;
        background-size: 60px 60px;
    }

    .donation-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .donation-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .donation-hero p {
        font-size: 1.1rem;
        opacity: 0.95;
        line-height: 1.6;
    }

    /* Main Container */
    .donation-container {
        max-width: 1200px;
        margin: -40px auto 60px;
        padding: 0 20px;
        position: relative;
        z-index: 10;
    }

    /* Impact Stats */
    .impact-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #eef2f6;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(13,110,110,0.1);
        border-color: var(--primary-light);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .stat-icon i {
        font-size: 2rem;
        color: var(--primary);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .stat-label {
        color: #475569;
        font-size: 0.95rem;
    }

    /* Donation Grid */
    .donation-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
        margin-bottom: 60px;
    }

    /* Donation Form Card */
    .donation-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        border: 1px solid #eef2f6;
    }

    .donation-card h2 {
        font-size: 1.8rem;
        color: #0f172a;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .donation-card .subtitle {
        color: #475569;
        margin-bottom: 30px;
        font-size: 1rem;
    }

    /* Amount Presets */
    .amount-presets {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 25px;
    }

    .amount-btn {
        padding: 15px 10px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .amount-btn:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .amount-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    /* Custom Amount Input */
    .custom-amount {
        margin-bottom: 25px;
    }

    .custom-amount label {
        display: block;
        margin-bottom: 10px;
        color: #334155;
        font-weight: 500;
    }

    .custom-amount-input {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-symbol {
        position: absolute;
        left: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
    }

    .custom-amount-input input {
        width: 100%;
        padding: 15px 15px 15px 40px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 1.1rem;
        transition: all 0.2s;
    }

    .custom-amount-input input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    /* Donation Type */
    .donation-type {
        margin-bottom: 25px;
    }

    .type-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .type-btn {
        padding: 12px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 40px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .type-btn i {
        font-size: 1rem;
    }

    .type-btn:hover {
        border-color: var(--primary);
    }

    .type-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    /* Personal Info */
    .personal-info {
        margin-bottom: 25px;
    }

    .form-row {
        margin-bottom: 15px;
    }

    .form-row input {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-row input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .form-row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    /* Payment Methods */
    .payment-methods {
        margin-bottom: 25px;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .payment-btn {
        padding: 15px 10px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-btn i {
        font-size: 1.3rem;
    }

    .payment-btn span {
        font-weight: 500;
        color: #1e293b;
    }

    .payment-btn:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .payment-btn.active {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .payment-btn.visa i { color: #1A1F71; }
    .payment-btn.mastercard i { color: #EB001B; }
    .payment-btn.paypal i { color: #003087; }

    /* Submit Button */
    .donate-btn {
        width: 100%;
        padding: 18px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 40px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .donate-btn:hover {
        background: rgb(13 90 90);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(13,110,110,0.3);
    }

    .donate-btn:active {
        transform: translateY(0);
    }

    /* Info Sidebar */
    .info-sidebar {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .info-card {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        border: 1px solid #eef2f6;
    }

    .info-card h3 {
        font-size: 1.3rem;
        color: #0f172a;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card h3 i {
        color: var(--primary);
    }

    .zakat-calculator {
        background: var(--primary-light);
        border-radius: 16px;
        padding: 20px;
        margin-top: 15px;
    }

    .zakat-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed var(--primary-medium);
    }

    .zakat-item:last-child {
        border-bottom: none;
    }

    .zakat-label {
        color: #334155;
        font-weight: 500;
    }

    .zakat-value {
        color: var(--primary);
        font-weight: 600;
    }

    .testimonial {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f6;
    }

    .testimonial-avatar {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 600;
        font-size: 1.2rem;
    }

    .testimonial-content p {
        font-size: 0.9rem;
        color: #475569;
        font-style: italic;
        margin-bottom: 5px;
    }

    .testimonial-content span {
        font-size: 0.8rem;
        color: var(--primary);
        font-weight: 500;
    }

    /* Transparency Section */
    .transparency-section {
        background: white;
        border-radius: 24px;
        padding: 40px;
        margin-top: 40px;
        border: 1px solid #eef2f6;
    }

    .transparency-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 30px;
    }

    .transparency-item {
        text-align: center;
    }

    .transparency-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .transparency-icon i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .transparency-item h4 {
        color: #0f172a;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .transparency-item p {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* FAQ Section */
    .faq-section {
        margin-top: 50px;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 30px;
    }

    .faq-item {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #eef2f6;
        transition: all 0.3s;
    }

    .faq-item:hover {
        border-color: var(--primary);
        box-shadow: 0 10px 30px rgba(13,110,110,0.05);
    }

    .faq-question {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-question i {
        color: var(--primary);
        font-size: 1rem;
    }

    .faq-answer {
        color: #475569;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* Recent Donations */
    .recent-donations {
        background: white;
        border-radius: 24px;
        padding: 30px;
        margin-top: 40px;
        border: 1px solid #eef2f6;
    }

    .donation-ticker {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    .ticker-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 16px;
        animation: fadeIn 0.5s ease;
    }

    .ticker-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 600;
    }

    .ticker-info {
        flex: 1;
    }

    .ticker-name {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 3px;
    }

    .ticker-details {
        display: flex;
        gap: 15px;
        font-size: 0.8rem;
        color: #64748b;
    }

    .ticker-amount {
        font-weight: 600;
        color: var(--primary);
    }

    .ticker-time {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 968px) {
        .donation-grid {
            grid-template-columns: 1fr;
        }

        .transparency-grid {
            grid-template-columns: 1fr;
        }

        .faq-grid {
            grid-template-columns: 1fr;
        }

        .amount-presets {
            grid-template-columns: repeat(2, 1fr);
        }

        .type-options, .payment-options {
            grid-template-columns: 1fr;
        }

        .form-row-grid {
            grid-template-columns: 1fr;
        }

        .donation-hero h1 {
            font-size: 2rem;
        }
    }
</style>

<!-- Donation Hero Section -->
<section class="donation-hero">
    <div class="donation-hero-content container">
        <h1>Support the Ummah 🤲</h1>
        <p>Your donations help us provide accurate prayer times, authentic Islamic content, and free widgets for the global Muslim community. Every contribution, big or small, makes a difference.</p>
    </div>
</section>

<!-- Main Donation Container -->
<div class="donation-container">
    <!-- Impact Stats -->
    <div class="impact-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">50K+</div>
            <div class="stat-label">Daily Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-globe"></i>
            </div>
            <div class="stat-number">120+</div>
            <div class="stat-label">Countries</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="stat-number">30K+</div>
            <div class="stat-label">Mosques Served</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Transparent</div>
        </div>
    </div>

    <!-- Donation Grid -->
    <div class="donation-grid">
        <!-- Donation Form -->
        <div class="donation-card">
            <h2>Make a Donation</h2>
            <p class="subtitle">Your sadaqah helps us serve the Ummah better</p>

            <div class="amount-presets">
                <button class="amount-btn" onclick="setAmount(10)">$10</button>
                <button class="amount-btn" onclick="setAmount(25)">$25</button>
                <button class="amount-btn" onclick="setAmount(50)">$50</button>
                <button class="amount-btn" onclick="setAmount(100)">$100</button>
            </div>

            <div class="custom-amount">
                <label>Custom Amount</label>
                <div class="custom-amount-input">
                    <span class="currency-symbol">$</span>
                    <input type="number" id="customAmount" placeholder="Enter amount" min="1" step="1" oninput="setCustomAmount()">
                </div>
            </div>

            <div class="donation-type">
                <div class="type-options">
                    <button class="type-btn active" onclick="setDonationType('general')">
                        <i class="fas fa-heart"></i> General
                    </button>
                    <button class="type-btn" onclick="setDonationType('zakat')">
                        <i class="fas fa-calculator"></i> Zakat
                    </button>
                    <button class="type-btn" onclick="setDonationType('sadaqah')">
                        <i class="fas fa-hand-holding-heart"></i> Sadaqah
                    </button>
                </div>
            </div>

            <div class="personal-info">
                <div class="form-row">
                    <input type="text" placeholder="Full Name" id="fullName">
                </div>
                <div class="form-row">
                    <input type="email" placeholder="Email Address" id="email">
                </div>
                <div class="form-row-grid">
                    <input type="text" placeholder="Country">
                    <input type="text" placeholder="City">
                </div>
            </div>

            <div class="payment-methods">
                <div class="payment-options">
                    <button class="payment-btn visa active" onclick="setPaymentMethod('visa')">
                        <i class="fab fa-cc-visa"></i>
                        <span>Visa</span>
                    </button>
                    <button class="payment-btn mastercard" onclick="setPaymentMethod('mastercard')">
                        <i class="fab fa-cc-mastercard"></i>
                        <span>Mastercard</span>
                    </button>
                    <button class="payment-btn paypal" onclick="setPaymentMethod('paypal')">
                        <i class="fab fa-cc-paypal"></i>
                        <span>PayPal</span>
                    </button>
                </div>
            </div>

            <button class="donate-btn" onclick="processDonation()">
                <i class="fas fa-heart"></i>
                Donate Now
            </button>

            <div style="margin-top: 20px; text-align:center; font-size:0.8rem; color:#94a3b8;">
                <i class="fas fa-shield-alt"></i> Secure payment • 100% encrypted
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="info-sidebar">
            <div class="info-card">
                <h3><i class="fas fa-calculator"></i> Zakat Calculator</h3>
                <div class="zakat-calculator">
                    <div class="zakat-item">
                        <span class="zakat-label">Gold (85g)</span>
                        <span class="zakat-value">$5,000</span>
                    </div>
                    <div class="zakat-item">
                        <span class="zakat-label">Silver (595g)</span>
                        <span class="zakat-value">$400</span>
                    </div>
                    <div class="zakat-item">
                        <span class="zakat-label">Cash & Savings</span>
                        <span class="zakat-value">$10,000</span>
                    </div>
                    <div class="zakat-item">
                        <span class="zakat-label">Zakat Due (2.5%)</span>
                        <span class="zakat-value">$385</span>
                    </div>
                </div>
                <div style="margin-top: 15px; font-size:0.8rem; color:#475569;">
                    *Nisab values as of 2024
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-star"></i> Virtues of Giving</h3>
                <div style="background: #f8fafc; border-radius: 16px; padding: 20px; margin-bottom: 15px;">
                    <div style="font-size: 1rem; color: #0f172a; margin-bottom: 10px; font-family: 'Uthmanic', serif; direction: rtl;">
                        مَّثَلُ الَّذِينَ يُنفِقُونَ أَمْوَالَهُمْ فِي سَبِيلِ اللَّهِ كَمَثَلِ حَبَّةٍ أَنبَتَتْ سَبْعَ سَنَابِلَ فِي كُلِّ سُنبُلَةٍ مِّائَةُ حَبَّةٍ
                    </div>
                    <div style="font-size: 0.9rem; color: #475569; line-height: 1.5;">
                        "The example of those who spend their wealth in the way of Allah is like a seed which grows seven spikes; in each spike is a hundred grains." (Quran 2:261)
                    </div>
                </div>

                <div class="testimonial">
                    <div class="testimonial-avatar">A</div>
                    <div class="testimonial-content">
                        <p>"I've been using their prayer times for years. Happy to support!"</p>
                        <span>- Ahmed R.</span>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h3><i class="fas fa-clock"></i> Where Your Money Goes</h3>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Server Costs</span>
                        <span style="font-weight:600; color: var(--primary);">40%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px;">
                        <div style="width: 40%; height: 100%; background: var(--primary); border-radius: 10px;"></div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>API Development</span>
                        <span style="font-weight:600; color: var(--primary);">30%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px;">
                        <div style="width: 30%; height: 100%; background: var(--primary); border-radius: 10px;"></div>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Content Creation</span>
                        <span style="font-weight:600; color: var(--primary);">20%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px;">
                        <div style="width: 20%; height: 100%; background: var(--primary); border-radius: 10px;"></div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Dawah Outreach</span>
                        <span style="font-weight:600; color: var(--primary);">10%</span>
                    </div>
                    <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px;">
                        <div style="width: 10%; height: 100%; background: var(--primary); border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transparency Section -->
    <div class="transparency-section">
        <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">100% Transparency</h2>
        <p style="text-align: center; color: #475569; max-width: 700px; margin: 0 auto;">We believe in complete transparency. Every dollar is tracked and reported.</p>
        
        <div class="transparency-grid">
            <div class="transparency-item">
                <div class="transparency-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h4>Financial Reports</h4>
                <p>Quarterly financial reports published for public review</p>
            </div>
            <div class="transparency-item">
                <div class="transparency-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h4>Audited Accounts</h4>
                <p>Annual audits by independent third-party firms</p>
            </div>
            <div class="transparency-item">
                <div class="transparency-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4>Real-time Tracking</h4>
                <p>Live dashboard showing fund allocation</p>
            </div>
        </div>
    </div>

    <!-- Recent Donations Ticker -->
    <div class="recent-donations">
        <h3 style="color: #0f172a; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-history" style="color: var(--primary);"></i>
            Recent Donations
        </h3>
        <div class="donation-ticker" id="donationTicker">
            <!-- Dynamic donations will be added here -->
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">Frequently Asked Questions</h2>
        
        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question-circle"></i>
                    Is my donation tax-deductible?
                </div>
                <div class="faq-answer">
                    Yes, we are a registered 501(c)(3) non-profit organization. All donations are tax-deductible to the extent allowed by law.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question-circle"></i>
                    Can I donate Zakat?
                </div>
                <div class="faq-answer">
                    Absolutely! You can select "Zakat" as your donation type. We ensure your Zakat reaches those who are eligible.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question-circle"></i>
                    How secure is my payment?
                </div>
                <div class="faq-answer">
                    We use industry-standard SSL encryption and partner with trusted payment processors like Stripe and PayPal.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <i class="fas fa-question-circle"></i>
                    Can I donate monthly?
                </div>
                <div class="faq-answer">
                    Yes! You can set up recurring monthly donations. Check the "Monthly" option during checkout.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Donation page JavaScript
    let selectedAmount = 10;
    let donationType = 'general';
    let paymentMethod = 'visa';

    // Sample recent donations
    const recentDonations = [
        { name: 'Muhammad A.', amount: 100, time: '2 minutes ago', country: 'UAE' },
        { name: 'Fatima S.', amount: 50, time: '15 minutes ago', country: 'USA' },
        { name: 'Abdullah K.', amount: 250, time: '1 hour ago', country: 'Saudi Arabia' },
        { name: 'Aisha R.', amount: 25, time: '3 hours ago', country: 'UK' },
        { name: 'Omar H.', amount: 500, time: '5 hours ago', country: 'Canada' }
    ];

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Set active amount button
        document.querySelectorAll('.amount-btn')[0].classList.add('active');
        
        // Load recent donations
        loadRecentDonations();
        
        // Start donation ticker animation
        setInterval(rotateDonations, 5000);
    });

    function setAmount(amount) {
        selectedAmount = amount;
        
        // Update active state
        document.querySelectorAll('.amount-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        // Clear custom amount
        document.getElementById('customAmount').value = '';
    }

    function setCustomAmount() {
        const customAmount = document.getElementById('customAmount').value;
        if (customAmount && customAmount > 0) {
            selectedAmount = customAmount;
            
            // Remove active from preset buttons
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        }
    }

    function setDonationType(type) {
        donationType = type;
        
        document.querySelectorAll('.type-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    function setPaymentMethod(method) {
        paymentMethod = method;
        
        document.querySelectorAll('.payment-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    function processDonation() {
        const name = document.getElementById('fullName').value;
        const email = document.getElementById('email').value;
        
        if (!name || !email) {
            alert('Please fill in your name and email');
            return;
        }
        
        if (!selectedAmount || selectedAmount <= 0) {
            alert('Please enter a valid amount');
            return;
        }
        
        // Simulate donation processing
        alert(`Jazakallah Khair! Your donation of $${selectedAmount} has been received.`);
        
        // Add to recent donations
        addDonation(name, selectedAmount);
    }

    function loadRecentDonations() {
        const ticker = document.getElementById('donationTicker');
        ticker.innerHTML = '';
        
        recentDonations.forEach(donation => {
            addDonationToTicker(donation.name, donation.amount, donation.time, donation.country);
        });
    }

    function addDonation(name, amount) {
        const timeAgo = 'just now';
        const country = 'Unknown';
        addDonationToTicker(name, amount, timeAgo, country);
    }

    function addDonationToTicker(name, amount, time, country) {
        const ticker = document.getElementById('donationTicker');
        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2);
        
        const donationEl = document.createElement('div');
        donationEl.className = 'ticker-item';
        donationEl.innerHTML = `
            <div class="ticker-avatar">${initials}</div>
            <div class="ticker-info">
                <div class="ticker-name">${name}</div>
                <div class="ticker-details">
                    <span class="ticker-amount">$${amount}</span>
                    <span class="ticker-time"><i class="far fa-clock"></i> ${time}</span>
                    <span><i class="fas fa-map-marker-alt"></i> ${country}</span>
                </div>
            </div>
        `;
        
        ticker.insertBefore(donationEl, ticker.firstChild);
        
        // Keep only last 10 donations
        if (ticker.children.length > 10) {
            ticker.removeChild(ticker.lastChild);
        }
    }

    function rotateDonations() {
        // Simulate new donations coming in
        const names = ['Ibrahim', 'Maryam', 'Yusuf', 'Khadija', 'Bilal'];
        const countries = ['UAE', 'USA', 'UK', 'Canada', 'Australia'];
        const randomName = names[Math.floor(Math.random() * names.length)] + ' ' + ['A.', 'B.', 'M.'][Math.floor(Math.random() * 3)];
        const randomAmount = [25, 50, 100, 250, 500][Math.floor(Math.random() * 5)];
        const randomCountry = countries[Math.floor(Math.random() * countries.length)];
        
        addDonationToTicker(randomName, randomAmount, 'just now', randomCountry);
    }
</script>

@include('footer')
</body>
</html>