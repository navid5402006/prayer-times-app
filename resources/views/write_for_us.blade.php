@section('title', 'Write for Us - NextPrayerTime: Islamic Guest Post Guidelines')
@section('description', translate('Write for NextPrayerTime.com - Share authentic Islamic knowledge. Guest post guidelines for Tafsir, Seerah, Hadith, and Islamic articles with proper references.'))
@section('keywords', 'write for us, Islamic guest post, contribute Islamic content, Muslim writers, Islamic articles, guest posting guidelines')
@include('header')

    <style>
        :root {
            --primary: #0d6e6e;
            --secondary: #054545;
            --accent: #d4af37;
            --light: #f8f9fa;
            --text: #2c3e50;
            --white: #ffffff;
            --shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--text);
            line-height: 1.5;
            padding-top: 70px;
            margin: 0;
        }

        .navbar {
            background: var(--primary) !important;
            padding: 10px 0;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: var(--accent);
            margin-right: 8px;
            font-size: 1.5rem;
        }

        /* Simple Hero */
        .simple-hero {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .simple-hero h1 {
            font-size: 2rem;
            margin: 0 0 8px;
            font-weight: 600;
        }

        .simple-hero p {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* Main Container - Ek hi container mein sab */
        .main-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Cards - Chhotey aur compact */
        .card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(13,110,110,0.1);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(13,110,110,0.1);
        }

        .card-title i {
            font-size: 1.3rem;
            color: var(--primary);
        }

        .card-title h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary);
            margin: 0;
        }

        /* Lists - Compact */
        .list-grid {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        @media (min-width: 640px) {
            .list-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }

        .list-grid li {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            background: var(--light);
            padding: 8px 12px;
            border-radius: 30px;
            border: 1px solid rgba(13,110,110,0.1);
        }

        .list-grid li i {
            font-size: 0.9rem;
        }

        .list-grid li i.fa-check-circle {
            color: #28a745;
        }

        .list-grid li i.fa-times-circle {
            color: #dc3545;
        }

        /* Single column lists */
        .list-single {
            grid-template-columns: 1fr !important;
        }

        /* Intro text - Compact */
        .intro-text {
            background: rgba(13,110,110,0.03);
            padding: 15px 18px;
            border-radius: 10px;
            border-left: 3px solid var(--accent);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .intro-text p {
            margin: 5px 0;
        }

        /* Button - Bottom par */
        .btn-send {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 500;
            padding: 12px 25px;
            border-radius: 40px;
            text-decoration: none;
            display: inline-block;
            font-size: 0.95rem;
            border: none;
            box-shadow: 0 3px 10px rgba(13,110,110,0.2);
            transition: all 0.3s;
            margin: 5px 0;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13,110,110,0.3);
            color: white;
        }

        .btn-send i {
            margin-right: 8px;
        }

        /* Policy text - Compact */
        .policy-text {
            font-size: 0.95rem;
            margin: 10px 0;
        }

        .policy-text p {
            margin: 8px 0;
        }

        .text-danger {
            color: #dc3545;
        }

        /* Divider */
        .divider-light {
            margin: 25px 0;
            border: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        /* Stats - Chhotey */
        .stats-row {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 20px 0 0;
        }

        @media (min-width: 480px) {
            .stats-row {
                flex-direction: row;
                gap: 12px;
            }
        }

        .stat-item {
            flex: 1;
            background: rgba(13,110,110,0.03);
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(13,110,110,0.1);
        }

        .stat-number {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text);
        }

        /* Scroll top */
        .scroll-top {
            position: fixed;
            bottom: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            border: none;
            font-size: 0.9rem;
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }
    </style>

    <!-- Simple Hero -->
    <section class="simple-hero">
        <h1>🌙 Write For Us</h1>
        <p>Islamic Guest Post – Share Knowledge with Global Ummah</p>
    </section>

    <!-- Main Container - Ek hi container mein sab kuch -->
    <div class="main-container">
        
        <!-- Intro Card -->
        <div class="card">
            <div class="intro-text">
                <p><strong>✨ Introduction</strong></p>
                <p>NextPrayerTime.com welcomes Islamic scholars, writers & students to share authentic Islamic knowledge based on Qur'an and Sunnah.</p>
            </div>
        </div>

        <!-- Topics We Accept -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-book-open"></i>
                <h3>📚 Topics We Accept</h3>
            </div>
            <ul class="list-grid">
                <li><i class="fas fa-check-circle"></i> Tafsir of the Qur'an</li>
                <li><i class="fas fa-check-circle"></i> Seerah of Prophet ﷺ</li>
                <li><i class="fas fa-check-circle"></i> Authentic Hadith explanation</li>
                <li><i class="fas fa-check-circle"></i> Islamic history</li>
                <li><i class="fas fa-check-circle"></i> Islamic lifestyle guidance</li>
                <li><i class="fas fa-check-circle"></i> Fiqh issues (with references)</li>
                <li><i class="fas fa-check-circle"></i> Islamic events & Hijri calendar</li>
                <li><i class="fas fa-check-circle"></i> Dua & Islamic reminders</li>
            </ul>
        </div>

        <!-- Topics Not Accept -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-ban"></i>
                <h3>❌ Not Accepted</h3>
            </div>
            <ul class="list-grid">
                <li><i class="fas fa-times-circle"></i> Sectarian debates</li>
                <li><i class="fas fa-times-circle"></i> Hate speech</li>
                <li><i class="fas fa-times-circle"></i> Political propaganda</li>
                <li><i class="fas fa-times-circle"></i> Weak / fabricated hadith</li>
                <li><i class="fas fa-times-circle"></i> Content without references</li>
            </ul>
        </div>

        <!-- Submission Guidelines -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-ruler"></i>
                <h3>📏 Guidelines</h3>
            </div>
            <ul class="list-grid list-single">
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> 800–1500 words</li>
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> Authentic references (Qur'an, Hadith)</li>
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> Proper citations required</li>
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> 100% original - No plagiarism</li>
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> Simple, respectful language</li>
                <li><i class="fas fa-check-circle" style="color:#0d6e6e;"></i> 1 author bio allowed</li>
                <li><i class="fas fa-info-circle" style="color:#0d6e6e;"></i> We may edit for clarity & SEO</li>
            </ul>
        </div>

        <!-- Backlink Policy -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-link"></i>
                <h3>🔗 Backlink Policy</h3>
            </div>
            <div class="policy-text">
                <p>✓ One relevant backlink allowed in article/bio</p>
                <p>✓ Must provide backlink to NextPrayerTime.com</p>
                <p>✓ Only Islamic/educational niche websites</p>
                <p class="text-danger"><strong>✗ No spam, casino, betting, adult sites</strong></p>
                <p>✓ We reserve right to remove harmful backlinks</p>
            </div>
        </div>

        <!-- Privacy & Rights -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-lock"></i>
                <h3>🔐 Privacy & Rights</h3>
            </div>
            <div class="policy-text">
                <p>✓ We may edit content for clarity & SEO</p>
                <p>✓ We reserve right to reject any submission</p>
                <p>✓ Article becomes property of NextPrayerTime.com</p>
                <p>✓ Removal requests may not be accepted</p>
                <p>✓ Sponsored posts must be disclosed</p>
            </div>
        </div>

        <!-- Content Verification -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-shield-alt"></i>
                <h3>🛡 Verification Policy</h3>
            </div>
            <div class="policy-text">
                <p>All articles undergo strict authenticity check.</p>
                <p><strong style="color:#0d6e6e;">Any weak/fabricated hadith = Immediate rejection</strong></p>
            </div>
        </div>

        <!-- Stats - Chhotey -->
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-number">800+</div>
                <div class="stat-label">Min Words</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Original</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">Qur'an</div>
                <div class="stat-label">& Sunnah</div>
            </div>
        </div>

        <!-- Send Article Button - Bilkul Last Mein -->
        <div style="text-align: center; margin: 25px 0 10px;">
            <a href="https://nextprayertime.com/user/blog/create" class="btn-send">
                <i class="fas fa-envelope"></i>
                Write  Article
            </a>
        </div>

    </div> <!-- Main Container End -->

    <!-- Footer -->
    @include('footer')

    <!-- Scroll Top -->
    <button class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous" defer></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to Top
            const scrollTop = document.getElementById('scrollTop');
            if (scrollTop) {
                window.addEventListener('scroll', () => {
                    scrollTop.classList.toggle('show', window.pageYOffset > 300);
                });
                scrollTop.addEventListener('click', () => {
                    window.scrollTo({top: 0, behavior: 'smooth'});
                });
            }
        });
    </script>
</body>
</html>