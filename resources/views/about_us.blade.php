@section('title', 'About Us - NextPrayerTime: Accurate Prayer Times & Islamic Resources')
@section('description', translate('Learn about NextPrayerTime.com - Your trusted source for accurate prayer times, Qibla direction, Islamic calendar, and more. Serving 200+ cities worldwide.')) 
@section('keywords', 'about NextPrayerTime, prayer times, Qibla direction, Islamic calendar, Ramadan timings, Muslim app')
@include('header')

    <style>
        :root {
            --primary-color: #0d6e6e;
            --secondary-color: #054545;
            --accent-color: #d4af37;
            --light-color: #f8f9fa;
            --text-color: #2c3e50;
            --light-text: #6c757d;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
        }

        /* SEO Optimized Base Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
            line-height: 1.6;
            padding-top: 70px;
            overflow-x: hidden;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Navbar - Mobile First */
        .navbar {
            background-color: rgba(13, 110, 110, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .navbar-brand i {
            color: var(--accent-color);
            margin-right: 8px;
            font-size: 1.8rem;
        }

        /* Hero Section - Mobile Optimized */
        .hero {
            background: linear-gradient(135deg, rgba(13, 110, 110, 0.95), rgba(5, 69, 69, 0.98)), url('https://images.unsplash.com/photo-1585030247580-d9e3e5f9f1b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            min-height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 60px 20px;
        }

        .hero h1 {
            font-size: clamp(1.8rem, 5vw, 3.5rem);
            font-weight: 700;
            animation: fadeInDown 0.8s ease forwards;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero p {
            font-size: clamp(1rem, 3vw, 1.3rem);
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0.95;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Section Styling - Mobile First */
        .section {
            padding: 60px 20px;
        }

        @media (min-width: 768px) {
            .section {
                padding: 80px 40px;
            }
        }

        @media (min-width: 1024px) {
            .section {
                padding: 100px 0;
            }
        }

        .section-title {
            position: relative;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 50px;
            text-align: center;
            letter-spacing: -0.5px;
            line-height: 1.2;
            padding: 0 15px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), var(--primary-color));
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            .section-title:after {
                width: 120px;
            }
        }

        /* About Section - Mobile First */
        .about-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (min-width: 992px) {
            .about-content {
                flex-direction: row;
                gap: 50px;
            }
        }

        /* Image Container - Optimized */
        .about-image {
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            position: relative;
            text-align: center;
        }

        @media (min-width: 480px) {
            .about-image {
                max-width: 320px;
            }
        }

        @media (min-width: 768px) {
            .about-image {
                max-width: 350px;
            }
        }

        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 50% 50% 30% 70% / 60% 40% 60% 40%;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
            border: 4px solid var(--accent-color);
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        .about-image img:hover {
            transform: scale(1.02);
        }

        /* Remove distracting animations on mobile */
        @media (max-width: 768px) {
            .about-image::before {
                display: none;
            }
        }

        /* Text Content - Mobile Optimized */
        .about-text {
            width: 100%;
            background: var(--white);
            padding: 25px 20px;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        @media (min-width: 768px) {
            .about-text {
                padding: 35px 30px;
                border-radius: 25px;
            }
        }

        @media (min-width: 992px) {
            .about-text {
                padding: 40px;
                border-radius: 30px;
            }
        }

        .about-text p {
            font-size: 1rem;
            margin-bottom: 18px;
            color: var(--text-color);
            line-height: 1.7;
        }

        @media (min-width: 768px) {
            .about-text p {
                font-size: 1.1rem;
            }
        }

        /* Features List - Mobile First */
        .features-list {
            list-style: none;
            padding: 0;
            margin: 25px 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 640px) {
            .features-list {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            background: var(--light-color);
            padding: 10px 15px;
            border-radius: 40px;
            transition: all 0.3s ease;
            border: 1px solid rgba(13, 110, 110, 0.1);
        }

        @media (min-width: 768px) {
            .features-list li {
                font-size: 1rem;
                padding: 12px 18px;
            }
        }

        /* Button - Mobile Optimized */
        .btn-contact {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 15px rgba(13, 110, 110, 0.3);
        }

        @media (min-width: 480px) {
            .btn-contact {
                width: auto;
                padding: 14px 35px;
            }
        }

        /* Mission Section - Mobile First */
        .mission-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        @media (min-width: 768px) {
            .mission-section {
                padding: 80px 40px;
            }
        }

        @media (min-width: 1024px) {
            .mission-section {
                padding: 100px 0;
            }
        }

        .mission-section p {
            font-size: 1.1rem;
            line-height: 1.7;
            opacity: 0.95;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .mission-section p {
                font-size: 1.25rem;
            }
        }

        /* Stats Container - Mobile First */
        .stats-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 40px;
            padding: 0 15px;
        }

        @media (min-width: 480px) {
            .stats-container {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            backdrop-filter: blur(5px);
            width: 100%;
            transition: transform 0.3s ease;
        }

        @media (min-width: 480px) {
            .stat-item {
                width: calc(50% - 10px);
                min-width: 150px;
            }
        }

        @media (min-width: 768px) {
            .stat-item {
                width: auto;
                min-width: 200px;
                padding: 25px;
            }
        }

        .stat-number {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        @media (min-width: 768px) {
            .stat-label {
                font-size: 1.1rem;
            }
        }

        /* Scroll to Top - Mobile Friendly */
        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @media (min-width: 768px) {
            .scroll-top {
                width: 50px;
                height: 50px;
                bottom: 30px;
                right: 30px;
            }
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }

        /* Touch-friendly improvements */
        .nav-link, 
        .btn-contact, 
        .features-list li,
        .scroll-top {
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        /* Optimize animations for mobile */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Remove heavy animations on mobile */
        @media (max-width: 768px) {
            .hero::before,
            .mission-section::before {
                animation: none;
            }
            
            .about-image img:hover {
                transform: none;
            }
        }

        /* SEO Optimized Hidden Elements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }

        /* Loading Optimization */
        img {
            loading: lazy;
        }
    </style>

    <!-- Navbar -->
  

    <!-- Main Content -->
    <main>
        <!-- Hero Section with Schema Markup -->
        <section class="hero" aria-label="About NextPrayerTime">
            <div class="container">
                <h1 class="fade-in">About NextPrayerTime</h1>
                <p class="fade-in">Your trusted companion for accurate Islamic prayers times and spiritual guidance worldwide</p>
            </div>
        </section>

        <!-- About Section with Optimized Image -->
        <section class="section" aria-label="About Us Section">
            <div class="container">
                <h2 class="section-title slide-in-left">Who We Are</h2>
                <div class="about-content">
                    <!-- Optimized Image with proper alt text -->
                    <div class="about-image slide-in-left">
                        <img src="https://i.ibb.co/cKzspg67/FB-IMG-1761315456826.jpg" 
                             alt="CEO of NextPrayerTime - Founder and Leader"
                             title="NextPrayerTime CEO"
                             width="350" 
                             height="350"
                             loading="lazy">
                    </div>
                    
                    <!-- Text Content -->
                    <div class="about-text slide-in-right">
                        <p><span aria-hidden="true">✨</span> Welcome to NextPrayerTime.com - Your Gateway to Accurate Islamic Prayers</p>
                        
                        <p>We are dedicated to serving the global Muslim community by providing accurate and reliable prayer times, Qibla direction, and essential Islamic resources. Our mission is to help every Muslim maintain their salah on time, wherever they are in the world.</p>
                        
                        <p>Founded in 2023, we have grown to become a comprehensive Islamic platform offering:</p>
                        
                        <ul class="features-list">
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Daily prayer times by city</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Prayer times based on user location</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Accurate Qibla direction</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Ramadan timings & calendar</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Complete Islamic calendar</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Developer API & embed options</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Islamic articles & blog</li>
                            <li><i class="fas fa-check-circle" aria-hidden="true"></i> Monthly prayer schedules</li>
                        </ul>
                        
                        <p>Our platform combines cutting-edge technology with authentic Islamic knowledge to strengthen faith and facilitate spiritual growth. We provide easy-to-use embed options for masjids and Islamic centers, and our developer API allows seamless integration of prayer times into other applications.</p>
                        
                        <p>As the CEO of NextPrayerTime, I am committed to maintaining a platform that is not just informative, but also accurate, reliable, and accessible to Muslims everywhere. We continuously work to improve our services and add new features that benefit the Ummah.</p>
                        
                        <a href="/contact" class="btn-contact" aria-label="Contact NextPrayerTime Team">
                            Contact Our Team <i class="fas fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section with Stats -->
        <section class="mission-section" aria-label="Our Mission and Impact">
            <div class="container">
                <h2 class="section-title">Our Mission</h2>
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <p>To provide accurate, reliable, and accessible Islamic prayer times and resources to Muslims worldwide, helping them maintain their spiritual connection through timely salah.</p>
                        <p>We believe that technology should serve faith, making it easier for every Muslim to practice their religion with confidence and peace of mind.</p>
                    </div>
                </div>
                
                <!-- Stats with semantic HTML -->
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Cities Worldwide</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1M+</div>
                        <div class="stat-label">Happy Users</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Accuracy</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    @include('footer')

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
        <i class="fas fa-arrow-up" aria-hidden="true"></i>
    </button>

    <!-- Optimized Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous" defer></script>
    
    <script>
        // Defer non-critical JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Current Year
            const yearElement = document.getElementById('currentYear');
            if (yearElement) {
                yearElement.textContent = new Date().getFullYear();
            }
            
            // Scroll to Top - Optimized for performance
            const scrollTop = document.getElementById('scrollTop');
            
            if (scrollTop) {
                let scrollTimeout;
                
                window.addEventListener('scroll', () => {
                    if (scrollTimeout) {
                        window.cancelAnimationFrame(scrollTimeout);
                    }
                    
                    scrollTimeout = window.requestAnimationFrame(() => {
                        if (window.pageYOffset > 300) {
                            scrollTop.classList.add('show');
                        } else {
                            scrollTop.classList.remove('show');
                        }
                    });
                });
                
                scrollTop.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
            
            // Optimized Intersection Observer
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '50px'
                });
                
                document.querySelectorAll('.section-title, .about-image, .about-text, .stat-item').forEach(el => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    el.style.transition = 'all 0.6s ease';
                    observer.observe(el);
                });
            } else {
                // Fallback for older browsers
                document.querySelectorAll('.section-title, .about-image, .about-text, .stat-item').forEach(el => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
            }
        });
    </script>

    <!-- JSON-LD Schema Markup for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "name": "About NextPrayerTime",
        "description": "Learn about NextPrayerTime.com - Your trusted source for accurate prayer times, Qibla direction, Islamic calendar, and more.",
        "url": "https://nextprayertime.com/about",
        "mainEntity": {
            "@type": "Organization",
            "name": "NextPrayerTime",
            "description": "Providing accurate Islamic prayer times and resources worldwide",
            "foundingDate": "2023",
            "founder": {
                "@type": "Person",
                "name": "CEO of NextPrayerTime"
            },
            "areaServed": "Worldwide",
            "knowsAbout": ["Prayer Times", "Qibla Direction", "Islamic Calendar", "Ramadan Timings"]
        }
    }
    </script>
</body>
</html>