
@section('title', $meta_title)
@section('description', $meta_description)
@section('keywords', $meta_keywords)
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')

<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="robots" content="@yield('robot')">
    <meta name="googlebot" content="@yield('googlebot')">
    <meta name="msvalidate.01" content="8B11E023A9E798815DC1E761965B0A5B" />
    <meta name="google-site-verification" content="BMwTvJtJmFNe_dEXHJDHDxoy2zHfgdmKwNDEV7SnXZs" />
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="https://nextprayertime.com/nextprayertime.ico" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #2a7f4e;
            --primary-dark: #1e5f3a;
            --primary-light: #4a9e6e;
            --bg-main: #f4f8f2;
            --bg-card: #ffffff;
            --text-primary: #1f2e2a;
            --text-secondary: #3a5248;
            --text-muted: #6b8a7a;
            --border: #e2eae0;
            --shadow-sm: 0 4px 14px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 8px 28px rgba(0, 0, 0, 0.08);
            --radius-lg: 1.5rem;
            --radius-md: 1rem;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-primary); line-height: 1.5; scroll-behavior: smooth; }
        .app-wrapper { display: flex; max-width: 1400px; margin: 0 auto; gap: 28px; padding: 0 24px; }
        .main-content { flex: 1; min-width: 0; }
        .right-sidebar { width: 320px; flex-shrink: 0; margin-top: 28px; position: sticky; top: 24px; height: fit-content; }

        .header { background: var(--bg-card); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.98); backdrop-filter: blur(8px); }
        .nav-bar { display: flex; justify-content: space-between; align-items: center; padding: 14px 24px; max-width: 1400px; margin: 0 auto; flex-wrap: wrap; gap: 10px; }
        .logo h1 { font-size: 1.4rem; font-weight: 700; letter-spacing: -0.3px; }
        .logo span { color: var(--primary); }
        .logo p { font-size: 0.7rem; color: var(--text-muted); }
        .nav-links { display: flex; gap: 24px; align-items: center; flex-wrap: wrap; }
        .nav-links a { text-decoration: none; font-size: 0.85rem; font-weight: 500; color: var(--text-secondary); transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary); }
        .btn-outline-nav, .btn-primary-nav { padding: 6px 20px; border-radius: 40px; font-weight: 500; display: inline-block; }
        .btn-outline-nav { border: 1.5px solid var(--border); background: transparent; }
        .btn-primary-nav { background: var(--primary); color: white !important; }
        .mobile-menu-toggle { display: none; background: none; border: none; font-size: 1.6rem; color: var(--primary); cursor: pointer; }

        .user-menu-wrapper { position: relative; margin-left: 15px; }
        .user-menu-btn { display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 5px 12px; border-radius: 40px; background: rgba(0,0,0,0.05); transition: all 0.2s; }
        .user-menu-btn:hover { background: rgba(0,0,0,0.1); }
        .user-avatar-sm { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); }
        .user-name-sm { font-size: 0.85rem; font-weight: 500; color: var(--text-primary); }
        .user-dropdown { position: absolute; top: calc(100% + 10px); right: 0; width: 260px; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.25s; z-index: 1000; }
        .user-menu-wrapper:hover .user-dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .user-dropdown-header { padding: 16px; text-align: center; border-bottom: 1px solid #eef2f6; }
        .user-dropdown-header img { width: 48px; height: 48px; border-radius: 50%; margin-bottom: 8px; }
        .user-dropdown-header .name { font-weight: 600; color: #1e293b; font-size: 0.9rem; }
        .user-dropdown-header .email { font-size: 0.7rem; color: #64748b; }
        .user-dropdown-item { display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: #334155; text-decoration: none; transition: all 0.2s; font-size: 0.85rem; }
        .user-dropdown-item:hover { background: #f8fafc; color: var(--primary); padding-left: 20px; }
        .user-dropdown-divider { height: 1px; background: #eef2f6; margin: 6px 0; }
        .auth-buttons { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

        .settings-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); z-index: 400; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: 0.2s; }
        .settings-modal.active { visibility: visible; opacity: 1; }
        .settings-modal-container { background: var(--bg-card); border-radius: 28px; width: 90%; max-width: 450px; padding: 28px; box-shadow: var(--shadow-md); }
        .settings-modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .settings-modal-header h3 { color: var(--primary); font-size: 1.3rem; }
        .close-settings-btn { background: #f0f0f0; border: none; width: 36px; height: 36px; border-radius: 30px; font-size: 1.2rem; cursor: pointer; }
        .settings-select-modal { width: 100%; padding: 14px; border-radius: 60px; border: 1.5px solid var(--border); background: white; font-size: 0.9rem; margin: 15px 0; }
        .apply-settings-btn { background: var(--primary); color: white; border: none; padding: 12px; border-radius: 60px; width: 100%; font-weight: 600; cursor: pointer; font-size: 1rem; }

        .hero-card, .description-section, .faq-item, .sidebar-card, .weekly-section, .monthly-section {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 28px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
            position: relative;
        }
        .hero-card { margin-top: 30px; }
        .hero-settings-icon { position: absolute; top: 20px; right: 24px; background: none; border: none; font-size: 1.3rem; color: var(--text-muted); cursor: pointer; padding: 8px; border-radius: 50%; transition: 0.2s; z-index: 10; }
        .hero-settings-icon:hover { background: var(--bg-main); color: var(--primary); transform: rotate(15deg); }
        
        .time-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 28px; padding-bottom: 20px; border-bottom: 2px solid var(--border); }
        .current-time-box .label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .current-time-box .date-large { font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-top: 4px; }
        .current-time-box .time-value { font-size: 2.2rem; font-weight: 700; color: var(--primary); font-family: monospace; }
        .hijri-badge { background: #eef5ea; padding: 12px 28px; border-radius: 60px; font-weight: 600; font-size: 0.9rem; color: var(--primary-dark); text-align: center; }

        .prayer-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 28px 0; }
        .prayer-card-prayer { border-radius: var(--radius-md); padding: 24px 12px; text-align: center; background-size: cover; background-position: center; position: relative; overflow: hidden; cursor: default; transition: all 0.3s ease; min-height: 140px; }
        .prayer-card-prayer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); border-radius: var(--radius-md); z-index: 0; }
        .prayer-card-prayer > * { position: relative; z-index: 1; color: white; }
        .prayer-name { font-size: 0.85rem; font-weight: 800; text-transform: uppercase; background: rgba(0,0,0,0.6); display: inline-block; padding: 5px 14px; border-radius: 40px; letter-spacing: 1px; }
        .prayer-time { font-size: 1.7rem; font-weight: 800; font-family: monospace; margin-top: 12px; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .active-prayer { border: 3px solid var(--primary); transform: scale(1.02); box-shadow: var(--shadow-md); }
        .upcoming-alert { background: #eef5ea; border-radius: 1rem; padding: 16px; text-align: center; font-weight: 500; }

        .table-responsive { overflow-x: auto; margin-top: 20px; -webkit-overflow-scrolling: touch; }
        .weekly-table, .monthly-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; border-radius: 12px; overflow: hidden; }
        .weekly-table th, .weekly-table td, .monthly-table th, .monthly-table td { border: 1px solid var(--border); padding: 12px 8px; text-align: center; }
        .weekly-table th { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; font-weight: 700; }
        .monthly-table th { background: linear-gradient(135deg, #1e5f3a, #2a7f4e); color: white; font-weight: 700; }
        .weekly-table tr:nth-child(even), .monthly-table tr:nth-child(even) { background: #f9fdf8; }
        .weekly-table tr:hover, .monthly-table tr:hover { background: #eef5ea; transition: 0.2s; }
        .weekly-table tr.active-week-day, .monthly-table tr.active-month-day { background: #e8f3e5; font-weight: bold; }
        .weekly-table td.active-week-day, .monthly-table td.active-month-day { background: var(--primary-light); color: white; }
        
        .calendar-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
        .btn-icon { background: var(--primary); color: white; border: none; padding: 8px 20px; border-radius: 40px; cursor: pointer; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
        .btn-icon:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .export-btn { background: #2c3e50; }
        .method-badge-center { text-align: center; margin-top: 16px; display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap; }
        .method-badge { background: #e8f3e5; padding: 8px 20px; border-radius: 40px; font-size: 0.75rem; font-weight: 500; color: var(--primary-dark); display: inline-block; }
        .method-badge-active { background: var(--primary); color: white; padding: 6px 14px; border-radius: 40px; font-size: 0.75rem; font-weight: 500; display: inline-block; }
        
        .city-quick { background: rgba(42, 127, 78, 0.12); padding: 7px 18px; border-radius: 40px; cursor: pointer; font-size: 0.85rem; transition: 0.2s; display: inline-block; margin: 5px; }
        .city-quick:hover { background: var(--primary); color: white; }
        .city-link { padding: 10px 0; border-bottom: 1px solid var(--border); cursor: pointer; transition: 0.1s; font-size: 0.85rem; }
        .city-link:hover { color: var(--primary); padding-left: 6px; }
        .toggle-switch { width: 52px; height: 26px; background: #ccc; border-radius: 30px; position: relative; cursor: pointer; }
        .toggle-switch.active { background: var(--primary); }
        .toggle-switch::after { content: ''; width: 22px; height: 22px; background: white; border-radius: 50%; position: absolute; top: 2px; left: 4px; transition: 0.2s; }
        .toggle-switch.active::after { left: 26px; }

        .calc-card-modern { background: linear-gradient(145deg, #ffffff, #f8fbf6); border-radius: 1.2rem; padding: 18px; margin-top: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); }
        .calc-header { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--primary-light); }
        .calc-header i { font-size: 1.5rem; color: var(--primary); }
        .calc-header h4 { font-size: 0.95rem; color: var(--primary-dark); }
        .calc-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e0e8dc; flex-wrap: wrap; gap: 8px; }
        .calc-row:last-child { border-bottom: none; }
        .calc-label { font-weight: 600; color: var(--text-secondary); font-size: 0.75rem; display: flex; align-items: center; gap: 5px; }
        .calc-value { font-weight: 700; color: var(--primary-dark); font-family: monospace; font-size: 0.8rem; background: #eef5ea; padding: 3px 10px; border-radius: 30px; display: inline-block; }

        .footer { background: #112e1f; color: #d4e0d4; margin-top: 48px; padding: 48px 0 28px; }
        .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 32px; max-width: 1400px; margin: 0 auto; padding: 0 24px; }
        .footer-col h4 { color: white; margin-bottom: 16px; font-size: 1rem; }
        .footer-col p, .footer-col a { font-size: 0.8rem; color: #c0d4c0; text-decoration: none; display: block; margin-bottom: 8px; }
        .social-icons { display: flex; gap: 18px; margin-top: 12px; flex-wrap: wrap; }

        .mobile-bottom-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(20px); border-top: 1px solid rgba(226, 234, 224, 0.8); padding: 10px 20px 12px; z-index: 200; justify-content: space-around; align-items: center; }
        .nav-icon { display: flex; flex-direction: column; align-items: center; gap: 4px; background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; padding: 6px 12px; border-radius: 40px; }
        .nav-icon span { font-size: 0.7rem; font-weight: 500; }
        .nav-icon.active { color: var(--primary); background: rgba(42, 127, 78, 0.1); }

        .mobile-search-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(12px); z-index: 300; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: 0.2s; }
        .mobile-search-modal.active { visibility: visible; opacity: 1; }
        .modal-container { background: var(--bg-card); border-radius: 32px; width: 90%; max-width: 450px; padding: 28px 24px 32px; box-shadow: var(--shadow-md); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 10px; }
        .modal-header h3 { font-size: 1.3rem; color: var(--primary); font-weight: 700; }
        .close-modal-btn { background: #f0f0f0; border: none; width: 36px; height: 36px; border-radius: 30px; font-size: 1.2rem; cursor: pointer; }
        .mobile-search-input-wrapper { position: relative; width: 100%; margin-bottom: 20px; }
        .mobile-search-input-wrapper input { width: 100%; padding: 16px 20px 16px 48px; border: 1.5px solid var(--border); border-radius: 60px; font-size: 1rem; }
        .mobile-search-input-wrapper i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .modal-buttons { display: flex; flex-direction: column; gap: 12px; }
        .modal-buttons button { width: 100%; padding: 14px; font-size: 1rem; border-radius: 60px; font-weight: 600; cursor: pointer; border: none; }
        .modal-buttons .btn-primary { background: var(--primary); color: white; }
        .modal-buttons .btn-secondary { background: white; border: 1.5px solid var(--border); }
        .suggestions-list { position: absolute; background: white; border: 1px solid var(--border); border-radius: 20px; width: 100%; max-height: 280px; overflow-y: auto; z-index: 61; margin-top: 8px; }
        .suggestion-item { padding: 12px 20px; cursor: pointer; border-bottom: 1px solid #f0f0f0; }
        .suggestion-item:hover { background: var(--bg-main); }

        .faq-wrapper { margin-top: 20px; }
        .faq-item-modern { background: var(--bg-card); border-radius: 16px; margin-bottom: 16px; border: 1px solid var(--border); overflow: hidden; transition: all 0.3s ease; }
        .faq-item-modern:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .faq-question { width: 100%; text-align: left; padding: 20px 24px; background: transparent; border: none; font-size: 1rem; font-weight: 600; color: var(--text-primary); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s; }
        .faq-question:hover { background: rgba(42, 127, 78, 0.05); color: var(--primary); }
        .faq-question.active { background: rgba(42, 127, 78, 0.08); color: var(--primary); border-bottom: 1px solid var(--border); }
        .faq-question .faq-icon { transition: transform 0.3s; color: var(--primary); font-size: 1.2rem; }
        .faq-question.active .faq-icon { transform: rotate(180deg); }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-out; padding: 0 24px; line-height: 1.8; color: var(--text-secondary); font-size: 0.95rem; }
        .faq-answer.active { max-height: 500px; padding: 20px 24px; }

        .description-section-enhanced { background: linear-gradient(135deg, var(--bg-card) 0%, #f9fdf8 100%); border-radius: var(--radius-md); padding: 32px; margin-bottom: 24px; border: 1px solid var(--border); }
        .description-section-enhanced h3 { font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .description-section-enhanced h3 i { font-size: 1.8rem; color: var(--primary); }
        .description-section-enhanced p { font-size: 1rem; line-height: 1.8; color: var(--text-secondary); margin-bottom: 16px; }
        .description-section-enhanced p:last-child { margin-bottom: 0; }

        .qibla-card-enhanced { text-align: center; }
        .qibla-direction-circle { width: 120px; height: 120px; margin: 20px auto; position: relative; border-radius: 50%; background: #f0f4ec; }
        .qibla-needle { width: 4px; height: 50px; background: var(--primary); position: absolute; bottom: 50%; left: 50%; transform-origin: bottom center; transition: transform 0.5s; border-radius: 2px; }
        .qibla-degree { font-size: 2rem; font-weight: 800; color: var(--primary); }
        .qibla-link { display: inline-block; margin-top: 15px; padding: 10px 24px; background: var(--primary); color: white; text-decoration: none; border-radius: 40px; font-weight: 600; transition: all 0.3s; }
        .qibla-link:hover { background: var(--primary-dark); transform: translateY(-2px); }

        .mosque-card-enhanced { text-align: center; }
        .mosque-finder-btn { width: 100%; padding: 14px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; border-radius: 60px; color: white; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .mosque-finder-btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* Skeleton Loader Styles */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        .skeleton-prayer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 28px 0;
        }
        
        .skeleton-prayer-card {
            height: 140px;
            border-radius: var(--radius-md);
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        .skeleton-clock {
            width: 280px;
            height: 80px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 12px;
        }
        
        .skeleton-hijri {
            width: 200px;
            height: 60px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 60px;
        }
        
        .skeleton-title {
            width: 300px;
            height: 32px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .skeleton-upcoming {
            height: 60px;
            background: #eef5ea;
            border-radius: 1rem;
            margin-top: 20px;
        }
        
        .skeleton-table-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .skeleton-table-cell {
            height: 45px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 6px;
            flex: 1;
        }

        @media (max-width: 1024px) { 
            .app-wrapper { flex-direction: column; padding: 0 20px; } 
            .right-sidebar { width: 100%; position: static; margin-top: 0; }
            .nav-bar { flex-direction: column; }
            .nav-links { justify-content: center; }
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: block; }
            .nav-bar { flex-direction: row; justify-content: space-between; }
            .nav-links { position: fixed; top: 0; left: -100%; width: 75%; max-width: 280px; height: 100vh; background: var(--bg-card); flex-direction: column; align-items: flex-start; padding: 80px 24px 32px; gap: 20px; z-index: 105; transition: left 0.3s; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
            .nav-links.open { left: 0; }
            .menu-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 104; opacity: 0; visibility: hidden; transition: all 0.3s; }
            .menu-overlay.active { opacity: 1; visibility: visible; }
            .prayer-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .skeleton-prayer-grid { grid-template-columns: repeat(2, 1fr); }
            .prayer-time { font-size: 1.2rem; }
            .hero-card { padding: 24px; }
            .mobile-bottom-nav { display: flex; }
            body { padding-bottom: 80px; }
            .current-time-box .time-value { font-size: 1.8rem; }
            .weekly-table, .monthly-table { font-size: 0.7rem; min-width: 500px; }
            .description-section-enhanced { padding: 20px; }
            .description-section-enhanced h3 { font-size: 1.2rem; }
            .time-row { flex-direction: column; text-align: center; }
            .skeleton-clock { width: 100%; }
            .skeleton-hijri { width: 100%; }
            .hijri-badge { padding: 8px 16px; font-size: 0.8rem; }
            .method-badge-center { flex-direction: column; }
            .sidebar-card { padding: 20px; }
        }
        @media (max-width: 480px) {
            .prayer-grid { gap: 10px; }
            .skeleton-prayer-grid { gap: 10px; }
            .prayer-card-prayer { padding: 15px 8px; min-height: 100px; }
            .skeleton-prayer-card { height: 100px; }
            .prayer-name { font-size: 0.7rem; }
            .prayer-time { font-size: 1rem; }
            .btn-icon { padding: 6px 12px; font-size: 0.7rem; }
            .hero-card, .weekly-section, .monthly-section { padding: 16px; }
        }
    </style>
</head>
<body>

<form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">@csrf</form>

<div class="header">
    <div class="nav-bar">
        <div class="logo">
            <h1>Next<span>PrayerTime</span></h1>
            <p>Precision Salah Times & Islamic Tools</p>
        </div>
        <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
        <div class="nav-links" id="navLinks">
            <a href="/{{ $lang ?? '' }}">Home</a>
            <a href="/{{ $lang ? "$lang/qibla-direction" : 'qibla-direction' }}">Qibla</a>
            <a href="/{{ $lang ? "$lang/ramadan-timing" : 'ramadan-timing' }}">Ramadan</a>
            <a href="/{{ $lang ? "$lang/Tasbeeh-counter" : 'Tasbeeh-counter' }}">Tools</a>
            <a href="/{{ $lang ? "$lang/blogs" : 'blogs' }}">Blog</a>
            @guest('web')
                <a href="{{ route('user.login') }}" class="btn-outline-nav">Login</a>
                <a href="{{ route('user.register') }}" class="btn-primary-nav">Register</a>
            @else
                <div class="user-menu-wrapper">
                    <div class="user-menu-btn">
                        <img src="{{ Auth::guard('web')->user()->avatar_url }}" class="user-avatar-sm" alt="Avatar">
                        <span class="user-name-sm">{{ Auth::guard('web')->user()->name }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
                    </div>
                    <div class="user-dropdown">
                        <div class="user-dropdown-header">
                            <img src="{{ Auth::guard('web')->user()->avatar_url }}" alt="Avatar">
                            <div class="name">{{ Auth::guard('web')->user()->name }}</div>
                            <div class="email">{{ Auth::guard('web')->user()->email }}</div>
                        </div>
                        <a href="{{ route('user.dashboard') }}" class="user-dropdown-item"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a href="{{ route('user.profile') }}" class="user-dropdown-item"><i class="fas fa-user"></i> My Profile</a>
                        <a href="{{ route('user.blog.create') }}" class="user-dropdown-item"><i class="fas fa-pen-alt"></i> Write a Post</a>
                        <div class="user-dropdown-divider"></div>
                        <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()" class="user-dropdown-item" style="color: #dc2626;"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                    </div>
                </div>
            @endguest
        </div>
    </div>
    <div id="menuOverlay" class="menu-overlay"></div>
</div>

<div id="settingsModal" class="settings-modal">
    <div class="settings-modal-container">
        <div class="settings-modal-header">
            <h3>Calculation Settings</h3>
            <button class="close-settings-btn" id="closeSettingsBtn"><i class="fas fa-times"></i></button>
        </div>
        <p style="margin-bottom:10px;">Select prayer calculation method:</p>
        <select id="methodSelectModal" class="settings-select-modal">
            <option value="8">University of Islamic Sciences, Karachi (Fajr 18°, Isha 18°)</option>
            <option value="3">Muslim World League (Fajr 18°, Isha 17°)</option>
            <option value="4">Umm al-Qura, Makkah (Fajr 18.5°, Isha 90 min)</option>
            <option value="5">Egyptian General Authority (Fajr 19.5°, Isha 17.5°)</option>
            <option value="2">Islamic Society of North America (ISNA)</option>
        </select>
        <button id="applySettingsBtn" class="apply-settings-btn">Apply & Update Times</button>
    </div>
</div>

<div class="app-wrapper">
    <div class="main-content">
        <div class="hero-card">
            <button id="heroSettingsIcon" class="hero-settings-icon"><i class="fas fa-cog"></i></button>
            
            <!-- Skeleton Loader for Hero Section -->
            <div id="heroSkeleton" class="skeleton-hero">
                <div class="skeleton-time-row">
                    <div class="skeleton-clock"></div>
                    <div class="skeleton-hijri"></div>
                </div>
                <div class="skeleton-title"></div>
                <div class="skeleton-prayer-grid">
                    <div class="skeleton-prayer-card"></div>
                    <div class="skeleton-prayer-card"></div>
                    <div class="skeleton-prayer-card"></div>
                    <div class="skeleton-prayer-card"></div>
                    <div class="skeleton-prayer-card"></div>
                    <div class="skeleton-prayer-card"></div>
                </div>
                <div class="skeleton-upcoming"></div>
            </div>
            
            <!-- Actual Hero Content -->
            <div id="heroContent" style="display: none;">
                <div class="time-row">
                    <div class="current-time-box">
                        <div class="label">Today's Date &amp; Time (<span id="cityNameLabel">{{ $city ?? 'Loading' }}</span> Time)</div>
                        <div class="date-large" id="fullDateDisplay"></div>
                        <div class="time-value" id="liveClock">--:--:--</div>
                    </div>
                    <div class="hijri-badge" id="hijriDetail">Islamic Date: Loading...</div>
                </div>
                <h2 style="font-size:1.3rem;">Prayer Times for <span id="cityNameDisplay" style="color:var(--primary); font-weight:700;">{{ $city }}</span>, {{ $country ?? '' }}</h2>
                <div class="prayer-grid" id="prayerTimesGrid"></div>
                <div class="upcoming-alert"><strong>Upcoming Prayer:</strong> <span id="upcomingPrayerName">—</span> at <span id="upcomingPrayerTime">--:--</span></div>
            </div>
        </div>

        <div class="description-section-enhanced">
            <h3><i class="fas fa-mosque"></i> Spiritual Benefits of Regular Salah in <span id="descCityName">{{ $city }}</span></h3>
            <p>{!! $description ?? 'Prayer (Salah) is the second pillar of Islam and a direct connection between the servant and Allah. Performing prayers on time brings countless blessings, peace to the heart, and discipline to life. Our accurate prayer times help you fulfill this sacred duty with ease.' !!}</p>
        </div>

        <div class="weekly-section">
            <div class="calendar-nav">
                <h3><i class="fas fa-calendar-week"></i> Weekly Prayer Times (<span id="weeklyCityName">{{ $city }}</span>)</h3>
                <div>
                    <button id="prevWeekBtn" class="btn-icon"><i class="fas fa-chevron-left"></i> Prev Week</button>
                    <button id="nextWeekBtn" class="btn-icon">Next Week <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Skeleton Loader for Weekly Table -->
                <div id="weeklySkeleton">
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                </div>
                <!-- Actual Weekly Table -->
                <table class="weekly-table" id="weeklyTable" style="display: none;">
                    <thead><tr><th>Day</th><th>Fajr</th><th>Sunrise</th><th>Dhuhr</th><th>Asr</th><th>Maghrib</th><th>Isha</th></tr></thead>
                    <tbody id="weeklyTableBody"><tr><td colspan="6">Loading...</td></tr></tbody>
                </table>
            </div>
        </div>

        <div class="monthly-section" id="monthlySection">
            <div class="calendar-nav">
                <h3><i class="fas fa-calendar-alt"></i> Monthly Prayer Times</h3>
                <div>
                    <button id="prevMonthBtn" class="btn-icon"><i class="fas fa-chevron-left"></i> Prev Month</button>
                    <button id="nextMonthBtn" class="btn-icon">Next Month <i class="fas fa-chevron-right"></i></button>
                    <button id="exportPdfBtn" class="btn-icon export-btn"><i class="fas fa-file-pdf"></i> Export PDF</button>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Skeleton Loader for Monthly Table -->
                <div id="monthlySkeleton">
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                    <div class="skeleton-table-row">
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                        <div class="skeleton-table-cell"></div>
                    </div>
                </div>
                <!-- Actual Monthly Table -->
                <table class="monthly-table" id="monthlyTable" style="display: none;">
                    <thead><tr><th>Date</th><th>Fajr</th><th>Dhuhr</th><th>Asr</th><th>Maghrib</th><th>Isha</th></tr></thead>
                    <tbody id="monthlyTableBody"><tr><td colspan="6">Loading......</td></tr></tbody>
                </table>
            </div>
            <div class="method-badge-center">
                <span class="method-badge" id="calculationMethodBadge">Calculation Method: {{ $method ?? 'ISNA' }} | Aladhan API</span>
                <span id="activeMethodBadge" class="method-badge-active"></span>
            </div>
        </div>

        <!-- Dynamic FAQ Section with City-Specific Content -->
        <div class="hero-card">
            <h3 class="mb-4">Frequently Asked Questions about Prayer Times in <span id="faqCityName">{{ $city }}</span></h3>
            <div class="faq-wrapper" id="faqWrapper">
                @php
                    $methodName = $method ?? 'Karachi';
                    $timezoneName = $timezone ?? 'local';
                    $cityName = $city ?? 'your city';
                    $faqItems = [
                        ['question' => "What is the Fajr prayer time in " . $cityName . "?", 'answer' => "Fajr prayer time in " . $cityName . ", " . ($country ?? 'your country') . " begins at dawn and ends just before sunrise. Using the " . $methodName . " calculation method, the Fajr time is determined by the angle of the sun below the horizon. This is the first prayer of the day and consists of 2 rakats."],
                        ['question' => "When is Dhuhr prayer in " . $cityName . "?", 'answer' => "Dhuhr (Zuhr) prayer in " . $cityName . " begins after the sun passes its zenith (highest point). In " . $timezoneName . " timezone, this occurs around midday. It is the second prayer of the day and consists of 4 rakats."],
                        ['question' => "What time is Asr prayer in " . $cityName . "?", 'answer' => "Asr prayer time in " . $cityName . " begins when the shadow of an object equals its length. This is the third prayer of the day and consists of 4 rakats."],
                        ['question' => "When does Maghrib prayer start in " . $cityName . "?", 'answer' => "Maghrib prayer in " . $cityName . " starts immediately after sunset. It is the fourth daily prayer and consists of 3 rakats."],
                        ['question' => "What is Isha prayer time in " . $cityName . "?", 'answer' => "Isha prayer time in " . $cityName . " begins after the red twilight disappears from the sky. It is the fifth and final obligatory prayer."],
                        ['question' => "How are prayer times calculated for " . $cityName . "?", 'answer' => "Prayer times for " . $cityName . " are calculated using the " . $methodName . " calculation method, based on the geographic coordinates of the city."],
                    ];
                @endphp
                @foreach($faqItems as $index => $faq)
                    <div class="faq-item-modern">
                        <button class="faq-question" data-faq="{{ $index }}">
                            {{ $faq['question'] }}
                            <i class="fas fa-chevron-down faq-icon"></i>
                        </button>
                        <div class="faq-answer" id="faqAnswer{{ $index }}">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dynamic FAQ Schema -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                @foreach($faqItems as $index => $faq)
                {
                    "@type": "Question",
                    "name": "{{ $faq['question'] }}",
                    "acceptedAnswer": { "@type": "Answer", "text": "{{ str_replace('"', "'", $faq['answer']) }}" }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        </script>

        <!-- Nearby Cities -->
        @if(isset($citiesInCountry) && count($citiesInCountry) > 0)
        <div class="hero-card">
            <h3>Nearby Cities in {{ $country ?? '' }}</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($citiesInCountry as $cityItem)
                    @if(strtolower($cityItem->city) != strtolower($city ?? ''))
                        <span class="city-quick" data-city="{{ $cityItem->city }}">{{ $cityItem->city }}</span>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="right-sidebar">
        <div class="sidebar-card qibla-card-enhanced">
            <h3><i class="fas fa-compass"></i> Qibla Direction (<span id="qiblaCityName">{{ $city }}</span>)</h3>
            <div class="qibla-direction-circle">
                <div class="qibla-needle" id="qiblaNeedle" style="transform: rotate({{ $qibla_direction ?? 119 }}deg);"></div>
                <i class="fas fa-mosque" style="font-size: 2rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: var(--primary-dark);"></i>
            </div>
            <div class="qibla-degree">{{ $qibla_direction ?? '119' }}&deg; Southeast</div>
            <a href="/{{ $lang ? $lang . '/' : '' }}{{ strtolower(str_replace(' ', '-', $city ?? 'mecca')) }}-qibla-direction" class="qibla-link">
                View Full Qibla Guide <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="sidebar-card">
            <h3><i class="fas fa-bell"></i> Prayer Alarms</h3>
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap: wrap; gap: 10px;">
                <span>Adhan Notifications for <span id="notifCityName">{{ $city }}</span></span>
                <div id="notificationToggle" class="toggle-switch"></div>
            </div>
            <div id="notificationStatus" style="font-size: 0.7rem; color: var(--text-muted); margin-top: 10px;"></div>
        </div>

        <div class="sidebar-card">
            <h3><i class="fas fa-city"></i> Quick Cities</h3>
            <div id="sidebarCityList"></div>
        </div>

        <div class="sidebar-card mosque-card-enhanced">
            <h3><i class="fas fa-mosque"></i> Mosque Finder</h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px;">Find mosques near your location in <span id="mosqueCityName">{{ $city }}</span></p>
            <button id="mosqueFinderBtn" class="mosque-finder-btn">
                <i class="fas fa-map-marker-alt"></i> Find Mosques Near Me
            </button>
        </div>
        
        <div class="sidebar-card">
            <h3><i class="fas fa-calculator"></i> Prayer Calculation</h3>
            <div class="calc-card-modern">
                <div class="calc-header"><i class="fas fa-map-marker-alt"></i><h4><span id="calcCityName">{{ $city }}</span>, <span id="calcCountryName">{{ $country ?? '' }}</span> Coordinates</h4></div>
                <div class="calc-row"><span class="calc-label"><i class="fas fa-location-dot"></i> Lat / Lon</span><span class="calc-value" id="cityCoordinates">Loading...</span></div>
                <div class="calc-row"><span class="calc-label"><i class="fas fa-angle-double-up"></i> Fajr Angle</span><span class="calc-value" id="calcFajrAngle">18°</span></div>
                <div class="calc-row"><span class="calc-label"><i class="fas fa-angle-double-down"></i> Isha Angle</span><span class="calc-value" id="calcIshaAngle">18°</span></div>
                <div class="calc-row"><span class="calc-label"><i class="fas fa-sun"></i> Asr Method</span><span class="calc-value">Shafi / Standard</span></div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-bottom-nav" id="mobileBottomNav">
    <button class="nav-icon" data-nav="home"><i class="fas fa-home"></i><span>Home</span></button>
    <button class="nav-icon" data-nav="qibla"><i class="fas fa-compass"></i><span>Qibla</span></button>
    <button class="nav-icon" data-nav="zakat"><i class="fas fa-coins"></i><span>Zakat</span></button>
    <button class="nav-icon" data-nav="search"><i class="fas fa-search"></i><span>Search</span></button>
</div>

<div id="mobileSearchModal" class="mobile-search-modal">
    <div class="modal-container">
        <div class="modal-header"><h3>Search City</h3><button class="close-modal-btn" id="closeModalBtn"><i class="fas fa-times"></i></button></div>
        <div class="mobile-search-input-wrapper"><i class="fas fa-search"></i><input type="text" id="modalLocationInput" placeholder="e.g., London, Dubai, Karachi"><div id="modalSuggestionsBox" class="suggestions-list" style="display:none;"></div></div>
        <div class="modal-buttons"><button id="modalSearchBtn" class="btn-primary">Get Prayer Times</button><button id="modalLiveBtn" class="btn-secondary">Use My Location</button></div>
    </div>
</div>

<footer class="footer">
    <div class="footer-grid">
        <div class="footer-col"><h4>NextPrayerTime</h4><p>Providing accurate prayer times since 2023.</p><div class="social-icons"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div></div>
        <div class="footer-col"><h4>Quick Links</h4><a href="/{{ $lang ?? '' }}">Home</a><a href="/aboutus">About</a><a href="/blogs">Blogs</a></div>
        <div class="footer-col"><h4>Islamic Tools</h4><a href="/{{ $lang ? "$lang/islamic-calendar" : 'islamic-calendar' }}">Hijri Calendar</a><a href="/{{ $lang ? "$lang/ramadan-timing" : 'ramadan-timing' }}">Ramadan Timings</a><a href="/{{ $lang ? "$lang/qibla-direction" : 'qibla-direction' }}">Qibla Finder</a></div>
        <div class="footer-col"><h4>Connect</h4><a href="#">Facebook</a><a href="#">Twitter</a><a href="#">Instagram</a><p id="footerHijri" style="margin-top:12px;"></p></div>
    </div>
    <hr style="margin:32px 24px 16px; border-color:#2c4b38;">
    <div style="text-align:center; font-size:0.75rem;">© {{ date('Y') }} NextPrayerTimes – <span id="footerCityName">{{ $city }}</span> Prayer Times. All Rights Reserved.</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ============================================================
    // FULLY FIXED: Accurate city time using TimeAPI.io
    // ============================================================
    
    function getCityFromUrl() {
        let path = window.location.pathname;
        let match = path.match(/prayer-times-in-([^\/]+)/i);
        if (match && match[1]) {
            return decodeURIComponent(match[1].replace(/-/g, ' '));
        }
        return "{{ $city ?? 'Dubai' }}";
    }
    
    const CITY_NAME = getCityFromUrl();
    let COUNTRY_NAME = "{{ $country ?? '' }}";
    let LAT = null, LON = null;
    let CITY_TIMEZONE = null;
    let currentMethod = {{ $method_id ?? 2 }};
    let weekOffset = 0, monthOffset = 0;
    let notificationPermission = false;
    
    const METHOD_NAMES = {8:"Karachi (18°/18°)",3:"Muslim World League (18°/17°)",4:"Umm al-Qura (18.5°/90min)",5:"Egyptian (19.5°/17.5°)",2:"ISNA (15°/15°)"};
    
    let currentCityDateTime = null;
    let lastTimeFetch = 0;
    
    const prayerBgImages = {
        Fajr: "url('https://static4.depositphotos.com/1011421/368/i/450/depositphotos_3686923-stock-photo-putrajaya-mosque.jpg')",
        Sunrise: "url('https://pics.freeartbackgrounds.com/midle/Sea_Sunrise_Background-1063.jpg')",
        Dhuhr: "url('https://images.pexels.com/photos/268533/pexels-photo-268533.jpeg?auto=compress&cs=tinysrgb&w=600')",
        Asr: "url('https://media.istockphoto.com/id/1322236237/photo/aerial-view-of-mosque-jame-asr-hassanil-bokliah-at-brunei-darussalam.jpg?s=612x612&w=0&k=20&c=35eUO8EFL18bROWXIQC7KRdeXwzhlnhGpnCqMaciueY=')",
        Maghrib: "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqSWQQrXo7YgWzVJ4pZTi15_5V2dkY5-4BIg&s')",
        Isha: "url('https://images.pexels.com/photos/355887/pexels-photo-355887.jpeg?auto=compress&cs=tinysrgb&w=600')"
    };
    
    function updateCityNamesInDOM() {
        const citySpans = ['cityNameLabel', 'cityNameDisplay', 'descCityName', 'weeklyCityName', 'faqCityName', 'qiblaCityName', 'notifCityName', 'mosqueCityName', 'calcCityName', 'footerCityName'];
        citySpans.forEach(id => {
            let el = document.getElementById(id);
            if (el) el.innerText = CITY_NAME;
        });
    }
    
    async function getCityCoordinates() {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(CITY_NAME)}&format=json&limit=1`);
            const data = await response.json();
            if (data.length > 0) {
                LAT = parseFloat(data[0].lat);
                LON = parseFloat(data[0].lon);
                if (data[0].address?.country) COUNTRY_NAME = data[0].address.country;
                document.getElementById('cityCoordinates').innerHTML = `${LAT.toFixed(4)}° / ${LON.toFixed(4)}°`;
                return true;
            }
        } catch(e) { console.warn(e); }
        
        const fallbacks = { 
            'dubai': [25.2048, 55.2708, 'UAE'], 'london': [51.5074, -0.1278, 'UK'], 
            'karachi': [24.8607, 67.0011, 'Pakistan'], 'mecca': [21.3891, 39.8579, 'Saudi Arabia'], 
            'medina': [24.5247, 39.5692, 'Saudi Arabia'], 'istanbul': [41.0082, 28.9784, 'Turkey'],
            'new york': [40.7128, -74.0060, 'USA'], 'toronto': [43.6532, -79.3832, 'Canada']
        };
        let key = CITY_NAME.toLowerCase();
        if (fallbacks[key]) {
            LAT = fallbacks[key][0];
            LON = fallbacks[key][1];
            COUNTRY_NAME = fallbacks[key][2];
        } else {
            LAT = 25.2048; LON = 55.2708; COUNTRY_NAME = 'UAE';
        }
        document.getElementById('cityCoordinates').innerHTML = `${LAT.toFixed(4)}° / ${LON.toFixed(4)}°`;
        return true;
    }
    
    async function fetchTimezone() {
        if (!LAT || !LON) return;
        try {
            const response = await fetch(`https://timeapi.io/api/timezone/coordinate?latitude=${LAT}&longitude=${LON}`);
            const data = await response.json();
            if (data.timeZone) {
                CITY_TIMEZONE = data.timeZone;
                return;
            }
        } catch(e) { console.warn("Timezone API error:", e); }
        
        const tzMap = { 
            'dubai':'Asia/Dubai', 'london':'Europe/London', 'karachi':'Asia/Karachi', 
            'mecca':'Asia/Riyadh', 'medina':'Asia/Riyadh', 'istanbul':'Europe/Istanbul',
            'new york':'America/New_York', 'toronto':'America/Toronto'
        };
        CITY_TIMEZONE = tzMap[CITY_NAME.toLowerCase()] || 'UTC';
    }
    
    async function fetchCityCurrentTime() {
        if (!CITY_TIMEZONE) await fetchTimezone();
        if (!CITY_TIMEZONE) return new Date();
        
        try {
            const response = await fetch(`https://timeapi.io/api/time/current/zone?timeZone=${CITY_TIMEZONE}`);
            const data = await response.json();
            if (data.dateTime) {
                currentCityDateTime = new Date(data.dateTime);
                lastTimeFetch = Date.now();
                return currentCityDateTime;
            }
        } catch(e) {
            try {
                const response = await fetch(`https://worldtimeapi.org/api/timezone/${CITY_TIMEZONE}`);
                const data = await response.json();
                if (data.datetime) {
                    currentCityDateTime = new Date(data.datetime);
                    lastTimeFetch = Date.now();
                    return currentCityDateTime;
                }
            } catch(e2) {}
        }
        return new Date();
    }
    
    async function getCurrentCityTime() {
        if (!currentCityDateTime || (Date.now() - lastTimeFetch) > 30000) {
            await fetchCityCurrentTime();
        }
        if (currentCityDateTime && lastTimeFetch) {
            const elapsedMs = Date.now() - lastTimeFetch;
            return new Date(currentCityDateTime.getTime() + elapsedMs);
        }
        return new Date();
    }
    
    async function fetchPrayerTimes(date, method = currentMethod) {
        if (!LAT || !LON) await getCityCoordinates();
        let y = date.getFullYear(), m = date.getMonth()+1, d = date.getDate();
        let url = `https://api.aladhan.com/v1/timings/${d}-${m}-${y}?latitude=${LAT}&longitude=${LON}&method=${method}&school=1`;
        if (CITY_TIMEZONE) url += `&timezonestring=${CITY_TIMEZONE}`;
        try {
            let res = await fetch(url);
            let data = await res.json();
            if(data.code === 200 && data.data) {
                if (data.data.meta?.timezone) CITY_TIMEZONE = data.data.meta.timezone;
                return data.data.timings;
            }
        } catch(e) { console.warn(e); }
        return null;
    }
    
    function formatTo12(time24) {
        if (!time24) return '--:--';
        let [hour, minute] = time24.split(':');
        hour = parseInt(hour);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12 || 12;
        return `${hour}:${minute} ${ampm}`;
    }
    
    function timeToMinutes(timeStr) {
        if (!timeStr) return 0;
        let parts = timeStr.match(/(\d+):(\d+)/);
        if (parts) return parseInt(parts[1]) * 60 + parseInt(parts[2]);
        return 0;
    }
    
    async function renderDailyPrayers() {
        let cityTime = await getCurrentCityTime();
        let times = await fetchPrayerTimes(cityTime);
        if (!times) return;
        
        const names = ["Fajr", "Sunrise", "Dhuhr", "Asr", "Maghrib", "Isha"];
        let nowMin = cityTime.getHours()*60 + cityTime.getMinutes();
        let activeIdx = names.findIndex(p => timeToMinutes(times[p]) > nowMin);
        if(activeIdx === -1) activeIdx = 0;
        
        let grid = document.getElementById("prayerTimesGrid");
        grid.innerHTML = "";
        names.forEach((name, idx) => {
            let card = document.createElement("div");
            card.className = `prayer-card-prayer ${idx === activeIdx ? 'active-prayer' : ''}`;
            card.style.backgroundImage = prayerBgImages[name] || prayerBgImages.Fajr;
            card.style.backgroundSize = "cover";
            card.innerHTML = `<div class="prayer-name">${name}</div><div class="prayer-time">${formatTo12(times[name])}</div>`;
            grid.appendChild(card);
        });
        
        let upcoming = names.find(p => timeToMinutes(times[p]) > nowMin) || names[0];
        document.getElementById("upcomingPrayerName").innerHTML = upcoming;
        document.getElementById("upcomingPrayerTime").innerHTML = formatTo12(times[upcoming]);
    }
    
    async function updateLiveClockAndDate() {
        const cityNow = await getCurrentCityTime();
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById("fullDateDisplay").innerText = cityNow.toLocaleDateString('en-US', dateOptions);
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        document.getElementById("liveClock").innerText = cityNow.toLocaleTimeString('en-US', timeOptions);
        document.getElementById("cityNameLabel").innerText = CITY_NAME;
    }
    
    async function updateHijriDate() {
        const cityDate = await getCurrentCityTime();
        try {
            let res = await fetch(`https://api.aladhan.com/v1/gToH/${cityDate.getDate()}-${cityDate.getMonth()+1}-${cityDate.getFullYear()}`);
            let data = await res.json();
            if(data.data?.hijri) {
                let h = data.data.hijri;
                document.getElementById("hijriDetail").innerHTML = `${h.day} ${h.month.en} ${h.year} AH`;
                document.getElementById("footerHijri").innerHTML = `${h.day} ${h.month.en} ${h.year} AH`;
            }
        } catch(e) {
            let islamic = cityDate.toLocaleDateString('en-u-ca-islamic', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById("hijriDetail").innerHTML = islamic;
            document.getElementById("footerHijri").innerHTML = islamic;
        }
    }
    
    async function generateWeeklyTable(offset = 0) {
        let base = await getCurrentCityTime();
        base.setDate(base.getDate() + (offset * 7));
        let start = new Date(base);
        start.setDate(base.getDate() - base.getDay());
        let tbody = document.getElementById("weeklyTableBody");
        let html = '';
        let today = await getCurrentCityTime();
        let todayStr = today.toDateString();
        
        for(let i=0;i<7;i++) {
            let day = new Date(start);
            day.setDate(start.getDate() + i);
            let times = await fetchPrayerTimes(day);
            if(times) {
                let dayLabel = day.toLocaleDateString('en-US', { weekday: 'short' }) + " " + day.getDate();
                let isToday = day.toDateString() === todayStr;
                let rowClass = isToday ? 'active-week-day' : '';
                html += `<tr class="${rowClass}">
                    <td class="${rowClass}">${dayLabel}</td>
                    <td>${formatTo12(times.Fajr)}</td>
                    <td>${formatTo12(times.Sunrise)}</td>
                    <td>${formatTo12(times.Dhuhr)}</td>
                    <td>${formatTo12(times.Asr)}</td>
                    <td>${formatTo12(times.Maghrib)}</td>
                    <td>${formatTo12(times.Isha)}</td>
                </tr>`;
            }
        }
        tbody.innerHTML = html || '<tr><td colspan="7">Unable to load data</td></tr>';
    }
    
    async function generateMonthlyTable(offset = 0) {
        let target = await getCurrentCityTime();
        target.setMonth(target.getMonth() + offset);
        let year = target.getFullYear(), month = target.getMonth();
        let daysInMonth = new Date(year, month+1, 0).getDate();
        let tbody = document.getElementById("monthlyTableBody");
        let html = '';
        let today = await getCurrentCityTime();
        let todayStr = today.toDateString();
        
        for(let d=1; d<=daysInMonth; d++) {
            let dateObj = new Date(year, month, d);
            let times = await fetchPrayerTimes(dateObj);
            if(times) {
                let dateStr = dateObj.toLocaleDateString('en-GB', { day:'numeric', month:'short' });
                let isToday = dateObj.toDateString() === todayStr;
                let rowClass = isToday ? 'active-month-day' : '';
                html += `<tr class="${rowClass}">
                    <td class="${rowClass}">${dateStr}</td>
                    <td>${formatTo12(times.Fajr)}</td>
                    <td>${formatTo12(times.Dhuhr)}</td>
                    <td>${formatTo12(times.Asr)}</td>
                    <td>${formatTo12(times.Maghrib)}</td>
                    <td>${formatTo12(times.Isha)}</td>
                </tr>`;
            }
        }
        tbody.innerHTML = html || '<tr><td colspan="6">Unable to load data</td></tr>';
        let monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        document.querySelector("#monthlySection h3").innerHTML = `<i class="fas fa-calendar-alt"></i> Monthly Prayer Times (${monthNames[month]} ${year})`;
    }
    
    async function refreshAllData() {
        await getCityCoordinates();
        await fetchTimezone();
        await fetchCityCurrentTime();
        await renderDailyPrayers();
        await generateWeeklyTable(weekOffset);
        await generateMonthlyTable(monthOffset);
        await updateLiveClockAndDate();
        await updateHijriDate();
        updateMethodDisplay();
        
        // Hide skeletons and show actual content after data loads
        const heroSkeleton = document.getElementById('heroSkeleton');
        const heroContent = document.getElementById('heroContent');
        const weeklySkeleton = document.getElementById('weeklySkeleton');
        const weeklyTable = document.getElementById('weeklyTable');
        const monthlySkeleton = document.getElementById('monthlySkeleton');
        const monthlyTable = document.getElementById('monthlyTable');
        
        if (heroSkeleton) heroSkeleton.style.display = 'none';
        if (heroContent) heroContent.style.display = 'block';
        if (weeklySkeleton) weeklySkeleton.style.display = 'none';
        if (weeklyTable) weeklyTable.style.display = 'table';
        if (monthlySkeleton) monthlySkeleton.style.display = 'none';
        if (monthlyTable) monthlyTable.style.display = 'table';
    }
    
    function updateMethodDisplay() {
        document.getElementById("calculationMethodBadge").innerHTML = `Calculation Method: ${METHOD_NAMES[currentMethod] || 'ISNA'} | Aladhan API`;
        document.getElementById("activeMethodBadge").innerHTML = `Active: ${METHOD_NAMES[currentMethod] || 'ISNA'}`;
        document.getElementById("methodSelectModal").value = currentMethod;
        const angles = {8:{fajr:18,isha:18},3:{fajr:18,isha:17},4:{fajr:18.5,isha:"90 min"},5:{fajr:19.5,isha:17.5},2:{fajr:15,isha:15}};
        let ang = angles[currentMethod] || {fajr:18,isha:18};
        document.getElementById("calcFajrAngle").innerHTML = ang.fajr + "°";
        document.getElementById("calcIshaAngle").innerHTML = typeof ang.isha === "number" ? ang.isha+"°" : ang.isha;
    }
    
    document.addEventListener("DOMContentLoaded", async () => {
        updateCityNamesInDOM();
        await refreshAllData();
        
        setInterval(async () => { await updateLiveClockAndDate(); }, 1000);
        setInterval(async () => { await renderDailyPrayers(); await updateHijriDate(); }, 60000);
        setInterval(async () => { await fetchCityCurrentTime(); await updateLiveClockAndDate(); }, 30000);
        
        const settingsModal = document.getElementById("settingsModal");
        document.getElementById("heroSettingsIcon").onclick = () => settingsModal.classList.add("active");
        document.getElementById("closeSettingsBtn").onclick = () => settingsModal.classList.remove("active");
        settingsModal.onclick = (e) => { if(e.target === settingsModal) settingsModal.classList.remove("active"); };
        document.getElementById("applySettingsBtn").onclick = async () => {
            currentMethod = parseInt(document.getElementById("methodSelectModal").value);
            await refreshAllData();
            settingsModal.classList.remove("active");
        };
        
        document.getElementById("prevWeekBtn").onclick = async () => { weekOffset--; await generateWeeklyTable(weekOffset); };
        document.getElementById("nextWeekBtn").onclick = async () => { weekOffset++; await generateWeeklyTable(weekOffset); };
        document.getElementById("prevMonthBtn").onclick = async () => { monthOffset--; await generateMonthlyTable(monthOffset); };
        document.getElementById("nextMonthBtn").onclick = async () => { monthOffset++; await generateMonthlyTable(monthOffset); };
        
               // FIXED: PDF Export using browser print (100% reliable - no blank pages)
        document.getElementById("exportPdfBtn")?.addEventListener("click", async () => {
            const exportBtn = document.getElementById("exportPdfBtn");
            const originalText = exportBtn.innerHTML;
            exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Preparing PDF...';
            exportBtn.disabled = true;
            
            try {
                // Get current target month/year based on monthOffset
                let target = await getCurrentCityTime();
                target.setMonth(target.getMonth() + monthOffset);
                let year = target.getFullYear();
                let month = target.getMonth();
                let daysInMonth = new Date(year, month + 1, 0).getDate();
                
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const shortMonthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading prayer times...';
                
                // Fetch all prayer times for the month
                let tableRows = [];
                let today = await getCurrentCityTime();
                let todayStr = today.toDateString();
                
                for (let d = 1; d <= daysInMonth; d++) {
                    let dateObj = new Date(year, month, d);
                    let times = await fetchPrayerTimes(dateObj);
                    if (times) {
                        let dateStr = d + " " + shortMonthNames[month];
                        let isToday = dateObj.toDateString() === todayStr;
                        tableRows.push({
                            date: dateStr,
                            fajr: formatTo12(times.Fajr),
                            sunrise: formatTo12(times.Sunrise),
                            dhuhr: formatTo12(times.Dhuhr),
                            asr: formatTo12(times.Asr),
                            maghrib: formatTo12(times.Maghrib),
                            isha: formatTo12(times.Isha),
                            isToday: isToday
                        });
                    }
                    if (d % 5 === 0) {
                        exportBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Loading ${Math.round(d/daysInMonth*100)}%...`;
                        await new Promise(r => setTimeout(r, 10));
                    }
                }
                
                if (tableRows.length === 0) {
                    alert("No data available. Please check your internet connection and try again.");
                    return;
                }
                
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating PDF...';
                
                // Build HTML table rows
                let tableRowsHtml = '';
                for (let row of tableRows) {
                    let rowStyle = row.isToday ? 'style="background-color: #e8f3e5; font-weight: bold;"' : '';
                    tableRowsHtml += `<tr ${rowStyle}>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.date}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.fajr}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.sunrise}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.dhuhr}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.asr}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.maghrib}</td>
                        <td style="padding: 10px 8px; border: 1px solid #c0d4c0; text-align: center;">${row.isha}</td>
                    </tr>`;
                }
                
                // Create complete HTML document for print/PDF
                const printContent = `<!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>${CITY_NAME} - Monthly Prayer Times</title>
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        body {
                            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
                            padding: 40px 30px;
                            background: white;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 3px solid #2a7f4e;
                            padding-bottom: 20px;
                        }
                        .header h1 {
                            color: #2a7f4e;
                            font-size: 28px;
                            margin: 0;
                        }
                        .header p {
                            color: #6b8a7a;
                            font-size: 14px;
                            margin-top: 8px;
                        }
                        .city-title {
                            text-align: center;
                            color: #1e5f3a;
                            font-size: 22px;
                            font-weight: bold;
                            margin: 20px 0 8px;
                        }
                        .month-year {
                            text-align: center;
                            color: #3a5248;
                            font-size: 16px;
                            margin-bottom: 25px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 11px;
                            margin: 0 auto;
                        }
                        th {
                            background: linear-gradient(135deg, #1e5f3a, #2a7f4e);
                            color: white;
                            padding: 12px 8px;
                            border: 1px solid #c0d4c0;
                            text-align: center;
                            font-weight: bold;
                        }
                        td {
                            padding: 8px 6px;
                            border: 1px solid #c0d4c0;
                            text-align: center;
                        }
                        tr:nth-child(even) {
                            background-color: #f9fdf8;
                        }
                        .footer {
                            margin-top: 25px;
                            padding-top: 15px;
                            border-top: 1px solid #e2eae0;
                            text-align: center;
                            font-size: 10px;
                            color: #aaa;
                        }
                        .note {
                            text-align: center;
                            font-size: 9px;
                            color: #999;
                            margin-top: 10px;
                        }
                        @media print {
                            body { margin: 0; padding: 20px; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>NextPrayerTime.com</h1>
                        <p>Accurate Islamic Prayer Times</p>
                    </div>
                    <div class="city-title">${CITY_NAME}, ${COUNTRY_NAME}</div>
                    <div class="month-year">${monthNames[month]} ${year} - Monthly Prayer Schedule</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Fajr</th>
                                <th>Sunrise</th>
                                <th>Dhuhr</th>
                                <th>Asr</th>
                                <th>Maghrib</th>
                                <th>Isha</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRowsHtml}
                        </tbody>
                    </table>
                    <div class="footer">
                        <p>Calculation Method: ${METHOD_NAMES[currentMethod] || 'ISNA'}</p>
                        <p>© ${new Date().getFullYear()} NextPrayerTime.com - Accurate Prayer Times for ${CITY_NAME}</p>
                    </div>
                    <div class="note">* Times are based on your selected calculation method and city coordinates</div>
                </body>
                </html>`;
                
                // Open new window and trigger print/Save as PDF
                const printWindow = window.open('', '_blank');
                printWindow.document.write(printContent);
                printWindow.document.close();
                
                // Wait for content to load then open print dialog
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                };
                
                alert("Click 'Save as PDF' in the print dialog to download your file.");
                
            } catch (error) {
                console.error("PDF Error:", error);
                alert("Error preparing PDF. Please try again.");
            } finally {
                exportBtn.innerHTML = originalText;
                exportBtn.disabled = false;
            }
        });
        
        const cities = ["Mecca", "Medina", "Dubai", "Istanbul", "Karachi", "London", "New York"];
        document.getElementById("sidebarCityList").innerHTML = cities.map(c => `<div class="city-link" data-city="${c}">${c}</div>`).join('');
        document.querySelectorAll(".city-link").forEach(link => {
            link.addEventListener("click", () => { window.location.href = `/prayer-times-in-${link.dataset.city.toLowerCase().replace(/ /g, '-')}`; });
        });
        document.querySelectorAll(".city-quick").forEach(el => {
            el.addEventListener("click", () => { window.location.href = `/prayer-times-in-${el.dataset.city.toLowerCase().replace(/ /g, '-')}`; });
        });
        
        document.getElementById("mosqueFinderBtn")?.addEventListener("click", () => {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((pos) => { window.open(`https://www.google.com/maps/search/mosque+near+${pos.coords.latitude},${pos.coords.longitude}`, "_blank"); }, () => { window.open(`https://www.google.com/maps/search/mosque+near+${CITY_NAME}`, "_blank"); });
            } else { window.open(`https://www.google.com/maps/search/mosque+near+${CITY_NAME}`, "_blank"); }
        });
        
        let notifToggle = document.getElementById("notificationToggle");
        notifToggle.addEventListener("click", async () => {
            if(Notification.permission === "granted") {
                notificationPermission = !notificationPermission;
                notifToggle.classList.toggle("active", notificationPermission);
                document.getElementById("notificationStatus").innerHTML = notificationPermission ? "Notifications enabled" : "Notifications disabled";
            } else {
                let permission = await Notification.requestPermission();
                if(permission === "granted") {
                    notificationPermission = true;
                    notifToggle.classList.add("active");
                    document.getElementById("notificationStatus").innerHTML = "Notifications enabled";
                }
            }
        });
        
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                const isActive = button.classList.contains('active');
                document.querySelectorAll('.faq-question').forEach(btn => {
                    btn.classList.remove('active');
                    btn.nextElementSibling.classList.remove('active');
                });
                if (!isActive) {
                    button.classList.add('active');
                    answer.classList.add('active');
                }
            });
        });
        
        const searchModal = document.getElementById("mobileSearchModal");
        const openSearchModal = () => searchModal.classList.add("active");
        const closeSearchModal = () => searchModal.classList.remove("active");
        document.getElementById("closeModalBtn").onclick = closeSearchModal;
        searchModal.onclick = (e) => { if(e.target === searchModal) closeSearchModal(); };
        document.getElementById("modalSearchBtn").onclick = () => {
            let input = document.getElementById("modalLocationInput");
            if(input.value.trim()) { window.location.href = `/prayer-times-in-${input.value.trim().toLowerCase().replace(/ /g, '-')}`; }
        };
        document.getElementById("modalLiveBtn").onclick = () => {
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (pos) => {
                    let res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${pos.coords.latitude}&lon=${pos.coords.longitude}&format=json`);
                    let data = await res.json();
                    let city = data.address?.city || data.address?.town || data.address?.village;
                    if(city) window.location.href = `/prayer-times-in-${city.toLowerCase().replace(/ /g, '-')}`;
                });
            }
            closeSearchModal();
        };
        
        document.querySelectorAll(".nav-icon").forEach(btn => {
            btn.addEventListener("click", () => {
                const type = btn.dataset.nav;
                if(type === "search") openSearchModal();
                else if(type === "home") window.scrollTo({ top: 0, behavior: "smooth" });
                else if(type === "qibla") window.location.href = `/{{ $lang ? $lang . '/' : '' }}{{ strtolower(str_replace(' ', '-', $city ?? 'mecca')) }}-qibla-direction`;
                else if(type === "zakat") window.location.href = "/Zakat-Calculator";
            });
        });
        
        const mobileToggle = document.getElementById("mobileMenuToggle");
        const navLinks = document.getElementById("navLinks");
        const overlay = document.getElementById("menuOverlay");
        mobileToggle.onclick = () => { navLinks.classList.toggle("open"); overlay.classList.toggle("active"); };
        overlay.onclick = () => { navLinks.classList.remove("open"); overlay.classList.remove("active"); };
    });
</script>
</body>
</html>
