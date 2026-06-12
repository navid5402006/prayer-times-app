<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('description')">
  <meta name="keywords" content="@yield('keywords')">
  <meta name="robots" content="@yield('robot')">
  <meta name="msvalidate.01" content="8B11E023A9E798815DC1E761965B0A5B" />
  <link rel="icon" href="https://nextprayertime.com/nextprayertime.ico" type="image/x-icon">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="googlebot" content="@yield('googlebot')">
  <meta name="google-site-verification" content="BMwTvJtJmFNe_dEXHJDHDxoy2zHfgdmKwNDEV7SnXZs" />
  <title>@yield('title')</title>
  <!-- Load Bootstrap CSS asynchronously -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mynew.css') }}">
  
  <style>
    /* User Menu Styles */
    .user-menu-wrapper {
      position: relative;
      margin-left: 15px;
    }
    
    .user-menu-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      padding: 5px 12px;
      border-radius: 40px;
      background: rgba(255,255,255,0.1);
      transition: all 0.2s;
    }
    
    .user-menu-btn:hover {
      background: rgba(255,255,255,0.2);
    }
    
    .user-avatar-sm {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.3);
    }
    
    .user-name-sm {
      font-size: 0.85rem;
      font-weight: 500;
      color: #fff;
    }
    
    .user-dropdown {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 260px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.25s;
      z-index: 1000;
    }
    
    .user-menu-wrapper:hover .user-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .user-dropdown-header {
      padding: 16px;
      text-align: center;
      border-bottom: 1px solid #eef2f6;
    }
    
    .user-dropdown-header img {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      margin-bottom: 8px;
    }
    
    .user-dropdown-header .name {
      font-weight: 600;
      color: #1e293b;
      font-size: 0.9rem;
    }
    
    .user-dropdown-header .email {
      font-size: 0.7rem;
      color: #64748b;
    }
    
    .user-dropdown-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 16px;
      color: #334155;
      text-decoration: none;
      transition: all 0.2s;
      font-size: 0.85rem;
    }
    
    .user-dropdown-item:hover {
      background: #f8fafc;
      color: #0d6e6e;
      padding-left: 20px;
    }
    
    .user-dropdown-divider {
      height: 1px;
      background: #eef2f6;
      margin: 6px 0;
    }
    
    /* Auth Buttons */
    .auth-buttons {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    
    .btn-login-nav {
      background: transparent;
      border: 1px solid rgba(255,255,255,0.5);
      color: #fff;
      padding: 6px 16px;
      border-radius: 30px;
      font-weight: 500;
      transition: all 0.2s;
      text-decoration: none;
      font-size: 0.85rem;
    }
    
    .btn-login-nav:hover {
      background: #fff;
      border-color: #fff;
      color: #0d6e6e;
    }
    
    .btn-register-nav {
      background: #d4af37;
      border: 1px solid #d4af37;
      color: #0d6e6e;
      padding: 6px 16px;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.2s;
      text-decoration: none;
      font-size: 0.85rem;
    }
    
    .btn-register-nav:hover {
      background: transparent;
      color: #d4af37;
    }
    
    /* Mobile Responsive */
    @media (max-width: 991px) {
      .auth-buttons {
        margin: 15px 0;
        justify-content: center;
      }
      
      .user-menu-wrapper {
        margin: 15px 0 0;
        text-align: center;
      }
      
      .user-menu-btn {
        display: inline-flex;
        background: rgba(255,255,255,0.1);
      }
      
      .user-dropdown {
        position: static;
        width: 100%;
        margin-top: 10px;
        opacity: 1;
        visibility: visible;
        transform: none;
        display: none;
        box-shadow: none;
        border: 1px solid #eef2f6;
      }
      
      .user-menu-wrapper.active .user-dropdown {
        display: block;
      }
      
      .navbar-collapse {
        padding: 10px 0;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/{{ $lang ?? '' }}">
            <i class="fas fa-mosque"></i> {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is($lang ? "$lang/" : '/') ? 'active' : '' }}" 
                       href="/{{ $lang ?? '' }}">@trans('Home')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is($lang ? "$lang/qibla-direction" : 'qibla-direction') ? 'active' : '' }}" 
                       href="{{ $lang ? "/$lang/qibla-direction" : '/qibla-direction' }}">@trans('Qibla Finder')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is($lang ? "$lang/ramadan-timing" : 'ramadan-timing') ? 'active' : '' }}" 
                       href="{{ $lang ? "/$lang/ramadan-timing" : '/ramadan-timing' }}">@trans('Ramadan Timings')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is($lang ? "$lang/prayer-times" : 'prayer-times') ? 'active' : '' }}" 
                       href="{{ $lang ? "/$lang/prayer-times" : '/prayer-times' }}">
                         @trans('Prayer Times')
                    </a>
                </li>
                
                <!-- Islamic Tools Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="islamicToolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @trans('Islamic Tools')
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="islamicToolsDropdown">
                        <li>
                            <a class="dropdown-item {{ request()->is($lang ? "$lang/islamic-calendar" : 'islamic-calendar') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/islamic-calendar" : '/islamic-calendar' }}">
                                @trans('Islamic Calendar')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is($lang ? "$lang/Tasbeeh-counter" : 'Tasbeeh-counter') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/Tasbeeh-counter" : '/Tasbeeh-counter' }}">
                                <i class="fas fa-praying-hands"></i> @trans('Dua & Azkar')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is($lang ? "$lang/zakat-calculator" : 'zakat-calculator') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/zakat-calculator" : '/zakat-calculator' }}">
                                <i class="fas fa-calculator"></i> @trans('Zakat Calculator')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request()->is($lang ? "$lang/mosque-near-me" : 'mosque-near-me') ? 'active' : '' }}" 
                               href="{{ $lang ? "/$lang/mosque-near-me" : '/mosque-near-me' }}">
                                <i class="fas fa-mosque"></i> @trans('Mosque Finder')
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
            
            <!-- Auth Section - Login/Register or User Menu -->
            <div class="ms-auto" style="margin-right: -94px;">
                @guest('web')
                    <div class="auth-buttons">
                        <a href="{{ route('user.login') }}" class="btn-login-nav">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('user.register') }}" class="btn-register-nav">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </div>
                @else
                    <div class="user-menu-wrapper">
                        <div class="user-menu-btn">
                            <img src="{{ Auth::guard('web')->user()->avatar_url }}" class="user-avatar-sm" alt="Avatar">
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: rgba(255,255,255,0.7);"></i>
                        </div>
                        <div class="user-dropdown">
                            <div class="user-dropdown-header">
                                <img src="{{ Auth::guard('web')->user()->avatar_url }}" alt="Avatar">
                                <div class="name">{{ Auth::guard('web')->user()->name }}</div>
                                <div class="email">{{ Auth::guard('web')->user()->email }}</div>
                            </div>
                            <a href="{{ route('user.dashboard') }}" class="user-dropdown-item">
                                <i class="fas fa-tachometer-alt" style="width: 20px;"></i> Dashboard
                            </a>
                            <a href="{{ route('user.profile') }}" class="user-dropdown-item">
                                <i class="fas fa-user" style="width: 20px;"></i> My Profile
                            </a>
                            <a href="{{ route('user.blog.create') }}" class="user-dropdown-item">
                                <i class="fas fa-pen-alt" style="width: 20px;"></i> Write a Post
                            </a>
                            <div class="user-dropdown-divider"></div>
                            <a href="javascript:void(0)" onclick="logoutUser()" class="user-dropdown-item" style="color: #dc2626;">
                                <i class="fas fa-sign-out-alt" style="width: 20px;"></i> Sign Out
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
  <style>
    /* If the above doesn't work, try this more specific selector */
    .navbar-nav .dropdown.no-border > .nav-link::after {
        display: none !important;
    }
  </style>
  
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Get current language from URL or default to 'en'
      const pathParts = window.location.pathname.split('/').filter(Boolean);
      const currentLang = pathParts.length > 0 && ['ar','ur','zh','fr','es','tr','id','ms','bn'].includes(pathParts[0]) 
                          ? pathParts[0] 
                          : 'en';
      
      // Set active language in dropdown
      const currentLangElement = document.getElementById('currentLanguage');
      if (currentLangElement) {
          currentLangElement.textContent = currentLang.toUpperCase();
      }
      document.querySelectorAll('.language-option').forEach(option => {
          if (option.dataset.lang === currentLang) {
              option.innerHTML = `<i class="fas fa-check me-2"></i>${option.textContent}`;
          }
      });
      
      // Handle language selection
      document.querySelectorAll('.language-option').forEach(option => {
          option.addEventListener('click', function(e) {
              e.preventDefault();
              const selectedLang = this.dataset.lang;
              
              // Get current path without language prefix
              let newPath = window.location.pathname;
              const langRegex = /^\/[a-z]{2}(-[a-zA-Z]{2})?(\/|$)/;
              
              if (selectedLang === 'en') {
                  // Remove language prefix for English
                  newPath = newPath.replace(langRegex, '/');
              } else {
                  // Add or replace language prefix
                  if (newPath.match(langRegex)) {
                      newPath = newPath.replace(langRegex, `/${selectedLang}/`);
                  } else {
                      newPath = `/${selectedLang}${newPath}`;
                  }
              }
              
              // Ensure there's no double slashes
              newPath = newPath.replace(/\/+/g, '/');
              
              // Reload page with new language
              window.location.href = newPath + window.location.search;
          });
      });
      
      // Mobile user menu toggle
      const userMenuWrapper = document.querySelector('.user-menu-wrapper');
      if (userMenuWrapper) {
          userMenuWrapper.addEventListener('click', function(e) {
              if (window.innerWidth <= 991) {
                  e.stopPropagation();
                  this.classList.toggle('active');
              }
          });
          
          document.addEventListener('click', function(e) {
              if (window.innerWidth <= 991 && userMenuWrapper && !userMenuWrapper.contains(e.target)) {
                  userMenuWrapper.classList.remove('active');
              }
          });
      }
  });
  
  // Logout function
  function logoutUser() {
      if (confirm('Are you sure you want to sign out?')) {
          document.getElementById('logout-form').submit();
      }
  }
  </script>
  
  <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
      @csrf
  </form>
  
  <!-- Full-page Loader -->
  <div class="npt-loader">
    <div class="npt-loader-box">
      <span class="npt-dua">اللّهُم صَلِّ عَلَى مُحَمَّدٍ</span>
      <div class="npt-dots">
        <span></span><span></span><span></span>
      </div>
      <div class="npt-text">Loading, please wait...</div>
    </div>
  </div>

  

  <!-- Loader CSS -->
  <style>
  .npt-loader{position:fixed;inset:0;background:#0d6e6e;display:flex;align-items:center;justify-content:center;z-index:9999;transition:opacity .5s}
  .npt-loader-box{text-align:center;color:#fff;font-family:Arial,sans-serif;}
  .npt-dua{font-size:1.4rem;margin-bottom:10px;display:block;}
  .npt-text{margin-top:10px;font-size:1.1rem;}
  .npt-dots{display:flex;justify-content:center;margin-top:10px;}
  .npt-dots span{width:8px;height:8px;background:white;border-radius:50px;margin:0 4px;animation:bounce 1s infinite;}
  .npt-dots span:nth-child(2){animation-delay:0.2s;}
  .npt-dots span:nth-child(3){animation-delay:0.4s;}
  @keyframes bounce{0%,80%,100%{transform:scale(0)}40%{transform:scale(1)}}
  </style>

  <!-- Loader JS -->
  <script>
  window.addEventListener('load',()=>{
    const loader=document.querySelector('.npt-loader');
    const main=document.getElementById('npt-main');
    loader.style.opacity=0;
    setTimeout(()=>{loader.style.display='none';main.style.display='block';},500);
  });
  </script>

 