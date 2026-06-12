<!DOCTYPE html>
<html amp lang="{{ $lang ?? 'en' }}">
<head>
    <!-- AMP required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="robots" content="@yield('robot', 'index, follow')">
    <meta name="googlebot" content="@yield('googlebot', 'index, follow')">
    
    <!-- Verification Meta Tags -->
    <meta name="msvalidate.01" content="8B11E023A9E798815DC1E761965B0A5B" />
    <meta name="google-site-verification" content="BMwTvJtJmFNe_dEXHJDHDxoy2zHfgdmKwNDEV7SnXZs" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('meta_description', @yield('description'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/default-og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="@yield('meta_description', @yield('description'))">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/default-og-image.jpg'))">
    
    <!-- Canonical URL (required for AMP) -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="https://nextprayertime.com/nextprayertime.ico" type="image/x-icon">
    
    <!-- AMP Script - MUST BE FIRST SCRIPT -->
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    
    <!-- AMP Components -->
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    
    <!-- AMP Boilerplate (required) -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:hidden}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:hidden}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:hidden}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:hidden}}@keyframes -amp-start{from{visibility:hidden}to{visibility:hidden}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    
    <!-- AMP Custom Styles (combine all CSS here) -->
    <style amp-custom>
        /* Header Styles */
        :root {
            --primary: #0d6e6e;
            --primary-dark: #0a5a5a;
            --text-light: #666;
            --text-dark: #333;
            --bg-white: #ffffff;
            --bg-light: #f8f9fa;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: #f5f5f5;
            padding-top: 70px;
        }

        /* Navbar Styles */
        .navbar {
            background: var(--primary);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        /* Mobile menu button */
        .navbar-toggler {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            color: white;
            font-size: 1.25rem;
        }

        /* Navigation menu */
        .navbar-collapse {
            width: 100%;
            display: none;
        }

        .navbar-collapse.show {
            display: block;
        }

        .navbar-nav {
            list-style: none;
            margin: 10px 0;
            padding: 0;
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 8px 0;
            display: block;
            transition: color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
        }

        .dropdown-menu {
            background: var(--primary-dark);
            padding: 10px 0 10px 20px;
            margin: 5px 0 0;
            list-style: none;
            border-radius: 4px;
        }

        .dropdown-item {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            padding: 6px 0;
            display: block;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            color: white;
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 20px;
        }

        /* Loader */
        .npt-loader {
            position: fixed;
            inset: 0;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s;
        }

        .npt-loader.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .npt-loader-box {
            text-align: center;
            color: #fff;
        }

        .npt-dua {
            font-size: 1.4rem;
            margin-bottom: 10px;
            display: block;
        }

        .npt-dots {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .npt-dots span {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50px;
            margin: 0 4px;
            animation: bounce 1s infinite;
        }

        .npt-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .npt-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%,80%,100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        .npt-text {
            margin-top: 10px;
            font-size: 1.1rem;
        }

        /* Main content */
        #npt-main {
            display: none;
        }

        .npt-main.visible {
            display: block;
        }

        /* Desktop styles */
        @media (min-width: 992px) {
            .navbar-toggler {
                display: none;
            }

            .navbar-collapse {
                display: block !important;
                width: auto;
            }

            .navbar-nav {
                display: flex;
                align-items: center;
                margin: 0;
            }

            .nav-item {
                margin: 0 5px;
                position: relative;
            }

            .nav-link {
                padding: 8px 12px;
            }

            .dropdown {
                position: relative;
            }

            .dropdown-menu {
                position: absolute;
                top: 100%;
                left: 0;
                min-width: 200px;
                background: var(--primary-dark);
                padding: 10px;
                display: none;
            }

            .dropdown:hover .dropdown-menu {
                display: block;
            }
        }

        /* Utilities */
        .fas {
            font-family: 'Font Awesome 5 Free', 'Font Awesome 6 Free';
            font-weight: 900;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }

        .fa-mosque:before { content: "🕌"; }
        .fa-calendar-alt:before { content: "📅"; }
        .fa-hand-sparkles:before { content: "🤲"; }
        .fa-calculator:before { content: "🧮"; }
        .fa-tools:before { content: "🔧"; }
        .fa-arrow-right:before { content: "→"; }
        .fa-globe:before { content: "🌐"; }
        .fa-check:before { content: "✓"; }
    </style>
</head>
<body>
    <!-- Google Analytics (AMP version) -->
    <amp-analytics type="gtag" data-credentials="include">
        <script type="application/json">
        {
            "vars": {
                "gtag_id": "AW-17957861346",
                "config": {
                    "AW-17957861346": { "groups": "default" }
                }
            }
        }
        </script>
    </amp-analytics>

    <!-- Loader (CSS-only, no JS) -->
    <div class="npt-loader" id="loader">
        <div class="npt-loader-box">
            <span class="npt-dua">اللّهُم صَلِّ عَلَى مُحَمَّدٍ</span>
            <div class="npt-dots">
                <span></span><span></span><span></span>
            </div>
            <div class="npt-text">Loading, please wait...</div>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <div id="npt-main">
        <!-- Header -->
        <nav class="navbar">
            <div class="container navbar-container">
                <a class="navbar-brand" href="/{{ $lang ?? '' }}">
                    {{ config('app.name') }}
                </a>
                
                <button class="navbar-toggler" on="tap:navbarCollapse.toggleClass(class='show')">
                    ☰
                </button>
                
                <div class="navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/" : '/') ? 'active' : '' }}" 
                               href="/{{ $lang ?? '' }}">@trans('Home')</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/ramadan-timing" : 'ramadan-timing') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/ramadan-timing" : '/ramadan-timing' }}">@trans('Ramadan Timings')</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/mosque-near-me" : 'mosque-near-me') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/mosque-near-me" : '/mosque-near-me' }}">@trans('Mosques Near Me')</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/qibla-direction" : 'qibla-direction') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/qibla-direction" : '/qibla-direction' }}">@trans('Qibla Finder')</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#">@trans('Islamic Tools') ▼</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ $lang ? "/$lang/islamic-calendar" : '/islamic-calendar' }}">
                                        <i class="fas fa-calendar-alt"></i> @trans('Islamic Calendar')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ $lang ? "/$lang/Tasbeeh-counter" : '/Tasbeeh-counter' }}">
                                        <i class="fas fa-hand-sparkles"></i> @trans('Dua & Azkar')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ $lang ? "/$lang/zakat-calculator" : '/Zakat-Calculator' }}">
                                        <i class="fas fa-calculator"></i> @trans('Zakat Calculator')
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/blogs" : 'blogs') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/blogs" : '/blogs' }}">@trans('Blogs')</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($lang ? "$lang/developers" : 'developers') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/developers" : '/developers' }}">@trans('Developers')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>