<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | IslamicPrayerTimes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #0d6e6e;
            --primary-light: rgba(13, 110, 110, 0.1);
            --secondary-color: #054545;
            --accent-color: #d4af37;
            --accent-light: rgba(212, 175, 55, 0.1);
            --light-color: #f8f9fa;
            --text-color: #2d3436;
            --light-text: #636e72;
            --border-color: #e9ecef;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 20px 40px rgba(13, 110, 110, 0.12);
            --transition-smooth: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
            color: var(--text-color);
            overflow-x: hidden;
        }
        
        /* Sidebar */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(145deg, var(--secondary-color) 0%, #0a4d4d 100%);
            color: white;
            transition: var(--transition-smooth);
            z-index: 1000;
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.1);
        }
        
        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        #sidebar .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin: 0;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
        }
        
        #sidebar ul li a {
            padding: 14px 25px;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition-smooth);
            font-size: 0.95rem;
            font-weight: 400;
            border-left: 3px solid transparent;
            margin: 4px 0;
        }
        
        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-color);
            transform: translateX(5px);
        }
        
        #sidebar ul li.active > a {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left: 3px solid var(--accent-color);
            font-weight: 500;
        }
        
        #sidebar ul li a i {
            margin-right: 12px;
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition-smooth);
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            font-weight: 500;
            padding: 1.2rem 1.5rem;
            border-radius: 24px 24px 0 0 !important;
            font-size: 1rem;
            letter-spacing: 0.3px;
            color: var(--secondary-color);
        }
        
        .stat-card {
            text-align: center;
            padding: 1.8rem 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: var(--primary-light);
            border-radius: 50%;
            opacity: 0.5;
            transition: var(--transition-smooth);
        }
        
        .stat-card:hover::before {
            transform: scale(1.5);
        }
        
        .stat-card i {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            background: var(--primary-light);
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 18px;
            display: inline-block;
            transition: var(--transition-smooth);
        }
        
        .stat-card:hover i {
            transform: scale(1.1) rotate(5deg);
            background: var(--primary-color);
            color: white;
        }
        
        .stat-card h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            color: var(--secondary-color);
        }
        
        .stat-card p {
            color: var(--light-text);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-card small {
            font-size: 0.75rem;
            color: var(--light-text);
            background: var(--light-color);
            padding: 0.2rem 1rem;
            border-radius: 50px;
        }
        
        /* Country Cards */
        .country-card {
            transition: var(--transition-smooth);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            height: 100%;
            min-height: 220px;
            background: white;
            position: relative;
        }

        .country-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(145deg, rgba(13,110,110,0.02) 0%, rgba(255,255,255,0) 100%);
            pointer-events: none;
        }

        .country-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: var(--primary-color);
            box-shadow: 0 30px 45px rgba(13, 110, 110, 0.15);
        }

        .country-card .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .country-card .country-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .country-card .country-name i {
            color: var(--primary-color);
            font-size: 1.2rem;
            background: var(--primary-light);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .country-card .city-count {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 1rem;
            align-self: flex-start;
            box-shadow: 0 5px 15px rgba(13, 110, 110, 0.3);
        }

        .country-card .last-added {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 14px;
            padding: 0.9rem;
            margin: 0.5rem 0 0.8rem;
            border: 1px solid var(--border-color);
            transition: var(--transition-smooth);
            flex: 1;
        }

        .country-card:hover .last-added {
            border-color: var(--primary-color);
            background: white;
        }

        .country-card .last-added .label {
            font-size: 0.65rem;
            color: var(--light-text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .country-card .last-added .city-name {
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .country-card .last-added .time {
            font-size: 0.7rem;
            color: var(--light-text);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.2rem;
        }

        .country-card .badges {
            margin: 0.3rem 0 0.8rem;
            display: flex;
            gap: 0.3rem;
        }

        .country-card .service-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: var(--transition-smooth);
            cursor: default;
        }

        .country-card .service-badge.prayer {
            background: linear-gradient(135deg, #0d6e6e, #0a8a8a);
            color: white;
            box-shadow: 0 4px 10px rgba(13, 110, 110, 0.3);
        }

        .country-card .service-badge.qibla {
            background: linear-gradient(135deg, #d4af37, #f5c542);
            color: white;
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        .country-card .service-badge.ramadan {
            background: linear-gradient(135deg, #054545, #0d6e6e);
            color: white;
            box-shadow: 0 4px 10px rgba(5, 69, 69, 0.3);
        }

        .country-card .btn-view {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            transition: var(--transition-smooth);
            width: 100%;
            margin-top: 0.5rem;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .country-card .btn-view:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(13, 110, 110, 0.4);
        }

        /* Grid Layout */
        .countries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.2rem;
            max-height: 550px;
            overflow-y: auto;
            padding: 0.3rem 0.5rem 0.3rem 0;
        }

        /* Custom Scrollbar */
        .countries-grid::-webkit-scrollbar,
        .recent-scroll::-webkit-scrollbar,
        .table-responsive::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .countries-grid::-webkit-scrollbar-track,
        .recent-scroll::-webkit-scrollbar-track,
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .countries-grid::-webkit-scrollbar-thumb,
        .recent-scroll::-webkit-scrollbar-thumb,
        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            transition: var(--transition-smooth);
        }

        .countries-grid::-webkit-scrollbar-thumb:hover,
        .recent-scroll::-webkit-scrollbar-thumb:hover,
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-weight: 500;
            color: var(--secondary-color);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
            background: white;
        }
        
        .table td {
            font-size: 0.85rem;
            vertical-align: middle;
            padding: 0.8rem 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr {
            transition: var(--transition-smooth);
        }

        .table tbody tr:hover {
            background: var(--primary-light);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        
        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.4rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
        }
        
        .badge-prayer {
            background: linear-gradient(135deg, #0d6e6e, #0a8a8a);
            color: white;
        }
        
        .badge-qibla {
            background: linear-gradient(135deg, #d4af37, #f5c542);
            color: white;
        }
        
        .badge-ramadan {
            background: linear-gradient(135deg, #054545, #0d6e6e);
            color: white;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #00b0b0, #00d4d4) !important;
            color: white;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #00b894, #00cec9) !important;
        }
        
        /* Source Badges */
        .source-badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            font-size: 0.6rem;
            font-weight: 600;
            margin-right: 2px;
            transition: var(--transition-smooth);
        }
        
        .source-prayer {
            background: linear-gradient(135deg, #0d6e6e, #0a8a8a);
            color: white;
        }
        
        .source-qibla {
            background: linear-gradient(135deg, #d4af37, #f5c542);
            color: white;
        }
        
        .source-ramadan {
            background: linear-gradient(135deg, #054545, #0d6e6e);
            color: white;
        }
        
        /* Country Selector */
        .country-selector {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }
        
        .form-select, .form-control {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            transition: var(--transition-smooth);
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--primary-light);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: var(--transition-smooth);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(13, 110, 110, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            transition: var(--transition-smooth);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 110, 0.3);
        }
        
        /* Recent Activity */
        .recent-scroll {
            max-height: 350px;
            overflow-y: auto;
            padding: 0.5rem 0;
        }
        
        .recent-activity-item {
            padding: 0.8rem 1.2rem;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition-smooth);
        }
        
        .recent-activity-item:hover {
            background: var(--primary-light);
            transform: translateX(5px);
        }
        
        .recent-activity-item .city-name {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
        
        .recent-activity-item .country-name {
            font-size: 0.75rem;
            color: var(--light-text);
        }
        
        .recent-activity-item .time {
            font-size: 0.65rem;
            color: var(--light-text);
        }
        
        /* Sidebar Toggle */
        #sidebarCollapse {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            color: white;
            padding: 0.6rem 1rem;
            transition: var(--transition-smooth);
        }

        #sidebarCollapse:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13, 110, 110, 0.4);
        }
        
        /* Section Headers */
        .section-header {
            margin-bottom: 1.2rem;
        }
        
        .section-header h5 {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.2rem;
            font-size: 1.1rem;
        }
        
        .section-header p {
            font-size: 0.8rem;
            color: var(--light-text);
            margin-bottom: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -260px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                width: calc(100% - 260px);
                margin-left: 260px;
            }
            
            .stat-card h2 {
                font-size: 1.8rem;
            }
            
            .countries-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                max-height: 450px;
            }
            
            .card-header {
                padding: 1rem 1.2rem;
            }
        }

        /* Loading Animation */
        .smooth-load {
            animation: smoothFade 0.6s ease-out;
        }

        @keyframes smoothFade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        @include('admin.layout')

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-dark" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-2" style="font-size: 1.2rem;"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 15px;">
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user me-2 text-primary"></i> Profile</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-cog me-2 text-primary"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid py-3 smooth-load">
                <!-- Stats Cards -->
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="card stat-card">
                            <i class="fas fa-clock"></i>
                            <h2>{{ $totalPrayerSearches }}</h2>
                            <p>Prayer Searches</p>
                            <small class="text-muted">{{ $todayPrayerSearches }} today</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card">
                            <i class="fas fa-compass"></i>
                            <h2>{{ $totalQiblaSearches }}</h2>
                            <p>Qibla Searches</p>
                            <small class="text-muted">{{ $todayQiblaSearches }} today</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card">
                            <i class="fas fa-moon"></i>
                            <h2>{{ $totalRamadanSearches }}</h2>
                            <p>Ramadan Searches</p>
                            <small class="text-muted">{{ $todayRamadanSearches }} today</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card stat-card">
                            <i class="fas fa-globe"></i>
                            <h2>{{ count($countryStats) }}</h2>
                            <p>Countries</p>
                            <small class="text-muted">{{ $totalCities }} cities</small>
                        </div>
                    </div>
                </div>

                <!-- Countries Cards Section with Smooth Scroll -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-flag me-2" style="color: var(--primary-color);"></i>
                                    <span>Countries Overview</span>
                                </div>
                                <span class="badge bg-primary rounded-pill px-3 py-2">{{ count($countryCards) }} Countries</span>
                            </div>
                            <div class="card-body">
                                <div class="countries-grid">
                                    @foreach($countryCards as $country)
                                    <div class="country-card">
                                        <div class="card-body">
                                            <div class="country-name" title="{{ $country['country'] }}">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ $country['country'] }}</span>
                                            </div>
                                            
                                            <span class="city-count">
                                                <i class="fas fa-city me-1"></i> {{ $country['cities_count'] }} Cities
                                            </span>
                                            
                                            @if($country['last_added_city'])
                                            <div class="last-added">
                                                <div class="label">RECENTLY ADDED</div>
                                                <div class="city-name" title="{{ $country['last_added_city'] }}">
                                                    <i class="fas fa-clock me-1" style="font-size: 0.7rem;"></i>
                                                    {{ $country['last_added_city'] }}
                                                </div>
                                                @if($country['last_activity'])
                                                <div class="time">
                                                    {{ \Carbon\Carbon::parse($country['last_activity'])->diffForHumans() }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            <div class="badges">
                                                @if($country['has_prayer'])
                                                    <span class="service-badge prayer" title="Prayer Times Available">P</span>
                                                @endif
                                                @if($country['has_qibla'])
                                                    <span class="service-badge qibla" title="Qibla Direction Available">Q</span>
                                                @endif
                                                @if($country['has_ramadan'])
                                                    <span class="service-badge ramadan" title="Ramadan Timings Available">R</span>
                                                @endif
                                            </div>
                                            
                                            <a href="?country={{ urlencode($country['country']) }}" class="btn-view">
                                                <i class="fas fa-eye me-1"></i> View All Cities
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Country Selector & Cities Section -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="country-selector">
                            <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2 align-items-end">
                                <div class="col-md-9">
                                    <label for="country" class="form-label fw-medium small mb-1">Select Country</label>
                                    <select name="country" id="country" class="form-select">
                                        <option value="all" {{ $selectedCountry == 'all' ? 'selected' : '' }}>🌍 All Countries ({{ $totalCities }} cities)</option>
                                        @foreach($allCountries as $countryName)
                                            @if(!empty($countryName))
                                                <option value="{{ $countryName }}" {{ $selectedCountry == $countryName ? 'selected' : '' }}>
                                                    {{ $countryName }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i> View Cities
                                    </button>
                                </div>
                            </form>
                            
                            @if($selectedCountry != 'all' && $selectedCountryStats)
                            <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 p-3" style="background: var(--primary-light); border-radius: 16px;">
                                <span><i class="fas fa-map-marker-alt text-primary me-1"></i> <strong class="text-secondary">{{ $selectedCountry }}</strong></span>
                                <div class="d-flex gap-2">
                                    <span class="badge badge-prayer">P: {{ $selectedCountryStats['prayer_count'] }}</span>
                                    <span class="badge badge-qibla">Q: {{ $selectedCountryStats['qibla_count'] }}</span>
                                    <span class="badge badge-ramadan">R: {{ $selectedCountryStats['ramadan_count'] }}</span>
                                    <span class="badge bg-info">C: {{ $selectedCountryStats['cities_count'] }}</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Cities List -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-city me-2" style="color: var(--primary-color);"></i>
                                    @if($selectedCountry == 'all')
                                        All Cities ({{ count($cities) }})
                                    @else
                                        {{ $selectedCountry }} Cities ({{ count($cities) }})
                                    @endif
                                </span>
                            </div>
                            <div class="card-body p-0">
                                @if(count($cities) > 0)
                                <div class="table-responsive" style="max-height: 400px;">
                                    <table class="table table-hover mb-0">
                                        <thead class="sticky-top bg-white" style="border-bottom: 2px solid var(--border-color);">
                                            <tr>
                                                <th class="ps-3">City</th>
                                                <th>Country</th>
                                                <th>Sources</th>
                                                <th class="pe-3">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cities as $city)
                                            <tr>
                                                <td class="ps-3"><span class="fw-medium">{{ $city->city }}</span></td>
                                                <td>{{ $city->country }}</td>
                                                <td>
                                                    @if($city->has_prayer)
                                                        <span class="source-badge source-prayer" title="Prayer Times">P</span>
                                                    @endif
                                                    @if($city->has_qibla)
                                                        <span class="source-badge source-qibla" title="Qibla Direction">Q</span>
                                                    @endif
                                                    @if($city->has_ramadan)
                                                        <span class="source-badge source-ramadan" title="Ramadan Timings">R</span>
                                                    @endif
                                                </td>
                                                <td class="pe-3">
                                                    <div class="btn-group btn-group-sm">
                                                        @if($city->has_prayer)
                                                            <a href="#" class="btn btn-outline-primary" title="View Prayer Times">
                                                                <i class="fas fa-clock"></i>
                                                            </a>
                                                        @endif
                                                        @if($city->has_qibla)
                                                            <a href="#" class="btn btn-outline-warning" title="View Qibla Direction">
                                                                <i class="fas fa-compass"></i>
                                                            </a>
                                                        @endif
                                                        @if($city->has_ramadan)
                                                            <a href="#" class="btn btn-outline-success" title="View Ramadan Timings">
                                                                <i class="fas fa-moon"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <i class="fas fa-city fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                                    <h6 class="text-muted">No cities found</h6>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section: Country Stats & Recent Searches -->
                <div class="row mt-3 g-3">
                    <!-- Country Statistics Table -->
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header">
                                <i class="fas fa-globe-asia me-2" style="color: var(--primary-color);"></i>Country Statistics
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 380px;">
                                    <table class="table table-hover mb-0 country-stats-table">
                                        <thead class="sticky-top bg-white">
                                            <tr>
                                                <th class="ps-3">Country</th>
                                                <th>Cities</th>
                                                <th>P</th>
                                                <th>Q</th>
                                                <th>R</th>
                                                <th>Total</th>
                                                <th>Last Activity</th>
                                                <th class="pe-3"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($countryStats as $country)
                                            <tr>
                                                <td class="ps-3"><span class="fw-medium">{{ $country['country'] }}</span></td>
                                                <td><span class="badge bg-info">{{ $country['cities_count'] }}</span></td>
                                                <td><span class="badge badge-prayer">{{ $country['prayer_count'] }}</span></td>
                                                <td><span class="badge badge-qibla">{{ $country['qibla_count'] }}</span></td>
                                                <td><span class="badge badge-ramadan">{{ $country['ramadan_count'] }}</span></td>
                                                <td><span class="badge bg-success">{{ $country['total_searches'] }}</span></td>
                                                <td>
                                                    @if(isset($country['last_activity']))
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($country['last_activity'])->diffForHumans() }}</small>
                                                    @endif
                                                </td>
                                                <td class="pe-3">
                                                    <a href="?country={{ urlencode($country['country']) }}" class="btn btn-sm btn-outline-primary py-1 px-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="8" class="text-center py-4">No data available</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Searches Combined -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <i class="fas fa-history me-2" style="color: var(--primary-color);"></i>Recent Activity
                            </div>
                            <div class="card-body p-0">
                                <div class="recent-scroll">
                                    @forelse($recentPrayerSearches as $search)
                                    <div class="recent-activity-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="city-name">{{ $search->city ?? 'Unknown' }}</span>
                                                <small class="country-name d-block">{{ $search->country ?? '' }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-prayer py-1 px-2">P</span>
                                                <small class="time d-block mt-1">{{ $search->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @forelse($recentQiblaSearches as $search)
                                    <div class="recent-activity-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="city-name">{{ $search->city ?? 'Unknown' }}</span>
                                                <small class="country-name d-block">{{ $search->country ?? '' }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-qibla py-1 px-2">Q</span>
                                                <small class="time d-block mt-1">{{ $search->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @forelse($recentRamadanSearches as $search)
                                    <div class="recent-activity-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="city-name">{{ $search->city ?? 'Unknown' }}</span>
                                                <small class="country-name d-block">{{ $search->country ?? '' }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-ramadan py-1 px-2">R</span>
                                                <small class="time d-block mt-1">{{ $search->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @if($recentPrayerSearches->isEmpty() && $recentQiblaSearches->isEmpty() && $recentRamadanSearches->isEmpty())
                                    <div class="text-center py-5">
                                        <i class="fas fa-history fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                                        <p class="text-muted small">No recent activity</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth sidebar toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
        
        // Auto-submit with smooth transition
        document.getElementById('country').addEventListener('change', function() {
            this.form.submit();
        });

        // Add smooth scroll behavior
        document.querySelectorAll('.countries-grid, .recent-scroll, .table-responsive').forEach(el => {
            el.style.scrollBehavior = 'smooth';
        });

        // Hover effects for cards
        document.querySelectorAll('.stat-card, .country-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1)';
            });
        });
    </script>
</body>
</html>