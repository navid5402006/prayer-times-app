<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Tags | Islamic Blog Topics & Keywords | IslamicHub</title>
    <meta name="description" content="Browse comprehensive Islamic blog tags covering Quran, Hadith, Spirituality, Fiqh, and more. Find specific Islamic topics and subjects to deepen your knowledge.">
    <meta name="keywords" content="islamic tags, quran tags, hadith tags, islamic topics, muslim blog tags, islamic keywords, sunnah, fiqh, spirituality, islamic education">
    
    <!-- SEO Meta Tags -->
    <meta property="og:title" content="Complete Islamic Blog Tags Collection | IslamicHub">
    <meta property="og:description" content="Explore our comprehensive collection of Islamic blog tags covering all aspects of Islam from Quran to daily living.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Islamic Blog Tags | Topics & Keywords">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "Islamic Blog Tags Collection",
        "description": "Complete collection of Islamic blog tags covering all topics related to Islam",
        "url": "{{ url()->current() }}",
        "mainEntity": {
            "@type": "ItemList",
            "numberOfItems": {{ $tags->count() }},
            "itemListElement": [
                @foreach($tags->take(10) as $index => $tag)
                {
                    "@type": "ListItem",
                    "position": {{ $index + 1 }},
                    "name": "{{ $tag->name }}",
                    "description": "{{ $tag->description ?? 'Islamic articles about ' . $tag->name }}",
                    "url": "{{ route('tag.show', $tag->slug) }}"
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
    }
    </script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2E8B57;
            --secondary-color: #8FBC8F;
            --accent-color: #F0FFF0;
            --text-dark: #2C3E50;
            --text-light: #7F8C8D;
            --bg-light: #F8F9FA;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        /* Header Styles */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }
        
        .hero h1 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        /* Section Styles */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 50px;
            position: relative;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Tags Cloud */
        .tags-cloud {
            text-align: center;
            padding: 40px 0;
            min-height: 300px;
        }
        
        .tag-item {
            display: inline-block;
            margin: 8px;
            transition: all 0.3s ease;
        }
        
        .tag-link {
            display: inline-block;
            padding: 12px 25px;
            background: white;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 30px;
            border: 2px solid #e9ecef;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        
        .tag-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(46, 139, 87, 0.3);
        }
        
        .tag-size-1 { font-size: 0.85rem; padding: 8px 15px; }
        .tag-size-2 { font-size: 0.95rem; padding: 9px 18px; }
        .tag-size-3 { font-size: 1.05rem; padding: 10px 20px; }
        .tag-size-4 { font-size: 1.15rem; padding: 11px 22px; }
        .tag-size-5 { font-size: 1.25rem; padding: 12px 25px; }
        
        .tag-count {
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            margin-left: 5px;
            font-weight: 700;
        }
        
        /* Alphabet Filter */
        .alphabet-filter {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }
        
        .alphabet-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .alphabet-letter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-color);
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .alphabet-letter:hover, .alphabet-letter.active {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }
        
        /* Popular Tags Section */
        .popular-tags-section {
            background: var(--accent-color);
            padding: 60px 0;
        }
        
        .popular-tag-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .popular-tag-card:hover {
            transform: translateY(-10px);
        }
        
        .popular-tag-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
        }
        
        .popular-tag-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-dark);
        }
        
        .popular-tag-count {
            color: var(--text-light);
            margin-bottom: 20px;
        }
        
        /* Category Badges */
        .category-badge {
            display: inline-block;
            padding: 4px 12px;
            background: var(--accent-color);
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 5px;
        }
        
        /* Sidebar Styles */
        .sidebar-widget {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .widget-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .category-list, .tag-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-list li, .tag-list li {
            margin-bottom: 10px;
        }
        
        .category-list a, .tag-list a {
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            transition: color 0.3s;
        }
        
        .category-list a:hover, .tag-list a:hover {
            color: var(--primary-color);
        }
        
        .tag-list a {
            background: var(--accent-color);
            padding: 5px 15px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        
        .recent-post {
            display: flex;
            margin-bottom: 15px;
        }
        
        .recent-post-image {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            background-size: cover;
            background-position: center;
            margin-right: 15px;
        }
        
        .recent-post-content h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        
        .recent-post-content h4 a {
            color: inherit;
            text-decoration: none;
        }
        
        .recent-post-content h4 a:hover {
            color: var(--primary-color);
        }
        
        .recent-post-content span {
            font-size: 0.8rem;
            color: var(--text-light);
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 15px 0;
            margin-bottom: 0;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        /* Statistics */
        .tag-stats {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* Footer */
        footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-widget h4 {
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .footer-widget h4:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            bottom: 0;
            left: 0;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid #444;
            color: #bbb;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                padding: 60px 0;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .tag-link {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .alphabet-letter {
                width: 35px;
                height: 35px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    @include('header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tags</li>
                </ol>
            </nav>
            
            <h1>Islamic Blog Tags</h1>
            <p>Browse {{ $tags->count() }}+ Islamic topics and keywords to find content that matters to you</p>
            
            <!-- Statistics -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-3 col-6">
                    <div class="tag-stats">
                        <div class="stat-number">{{ $tags->count() }}</div>
                        <div class="stat-label">Total Tags</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="tag-stats">
                        <div class="stat-number">{{ $totalArticles }}</div>
                        <div class="stat-label">Total Articles</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alphabet Filter -->
    <section class="section">
        <div class="container">
            <div class="alphabet-filter">
                <h3 class="text-center mb-3">Browse Tags Alphabetically</h3>
                <div class="alphabet-list">
                    <a href="javascript:void(0)" class="alphabet-letter active" data-letter="all">All</a>
                    @foreach(range('A', 'Z') as $letter)
                        @if($tags->filter(fn($tag) => strtoupper(substr($tag->name, 0, 1)) == $letter)->count() > 0)
                        <a href="javascript:void(0)" class="alphabet-letter" data-letter="{{ $letter }}">{{ $letter }}</a>
                        @else
                        <a href="javascript:void(0)" class="alphabet-letter disabled" data-letter="{{ $letter }}" style="opacity: 0.3; cursor: not-allowed;">{{ $letter }}</a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <h2 class="section-title">Complete Islamic Tags Collection</h2>
                    
                    <div class="tags-cloud" id="tagsContainer">
                        @foreach($tags as $tag)
                        @php
                            // Determine tag size based on blog count
                            $sizeClass = 'tag-size-1';
                            if ($tag->blogs_count >= 20) {
                                $sizeClass = 'tag-size-5';
                            } elseif ($tag->blogs_count >= 15) {
                                $sizeClass = 'tag-size-4';
                            } elseif ($tag->blogs_count >= 10) {
                                $sizeClass = 'tag-size-3';
                            } elseif ($tag->blogs_count >= 5) {
                                $sizeClass = 'tag-size-2';
                            }
                            
                            // Get first letter for alphabet filter
                            $firstLetter = strtoupper(substr($tag->name, 0, 1));
                        @endphp
                        <div class="tag-item" data-letter="{{ $firstLetter }}" data-count="{{ $tag->blogs_count }}">
                            <a href="{{ route('tag.show', $tag->slug) }}" class="tag-link {{ $sizeClass }}" title="Browse {{ $tag->blogs_count }} articles tagged with {{ $tag->name }}">
                                {{ $tag->name }} <span class="tag-count">{{ $tag->blogs_count }}</span>
                            </a>
                        </div>
                        @endforeach
                        
                        @if($tags->count() == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h3>No Tags Available</h3>
                            <p class="text-muted">There are no tags available at the moment.</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Popular Categories Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Popular Categories</h3>
                        <ul class="category-list">
                            @foreach($categories->sortByDesc('blogs_count')->take(5) as $category)
                            <li>
                                <a href="{{ route('category.show', $category->slug) }}">
                                    {{ $category->name }} 
                                    <span>({{ $category->blogs_count }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Recent Posts</h3>
                        @foreach($recentPosts as $recentPost)
                        <div class="recent-post">
                            <div class="recent-post-image" style="background-image: url('{{ $recentPost->image ? Storage::url($recentPost->image) : 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}');"></div>
                            <div class="recent-post-content">
                                <h4>
                                    <a href="{{ route('blog_detail', $recentPost->slug) }}">
                                        {{ Str::limit($recentPost->title, 50) }}
                                    </a>
                                </h4>
                                <span>{{ $recentPost->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Most Used Tags Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Top Tags</h3>
                        <div class="tag-list">
                            @foreach($tags->sortByDesc('blogs_count')->take(10) as $popularTag)
                            <a href="{{ route('tag.show', $popularTag->slug) }}">{{ $popularTag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Tags by Category -->
    <section class="popular-tags-section">
        <div class="container">
            <h2 class="section-title">Popular Tags by Category</h2>
            <div class="row">
                <!-- Quran & Tafsir -->
                <div class="col-md-3 col-sm-6">
                    <div class="popular-tag-card">
                        <div class="popular-tag-icon">
                            <i class="fas fa-quran"></i>
                        </div>
                        <h3 class="popular-tag-name">Quran & Tafsir</h3>
                        <div class="mb-3">
                            @php
                                $quranTags = $tags->filter(function($tag) {
                                    $quranKeywords = ['quran', 'surah', 'ayat', 'tafsir', 'recitation', 'memorization'];
                                    return Str::contains(strtolower($tag->name), $quranKeywords);
                                })->take(3);
                            @endphp
                            @foreach($quranTags as $tag)
                            <span class="category-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('category.show', 'quran-tafsir') }}" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
                
                <!-- Hadith & Sunnah -->
                <div class="col-md-3 col-sm-6">
                    <div class="popular-tag-card">
                        <div class="popular-tag-icon">
                            <i class="fas fa-book-hadith"></i>
                        </div>
                        <h3 class="popular-tag-name">Hadith & Sunnah</h3>
                        <div class="mb-3">
                            @php
                                $hadithTags = $tags->filter(function($tag) {
                                    $hadithKeywords = ['hadith', 'sunnah', 'prophet', 'muhammad', 'sahih', 'bukhari', 'muslim'];
                                    return Str::contains(strtolower($tag->name), $hadithKeywords);
                                })->take(3);
                            @endphp
                            @foreach($hadithTags as $tag)
                            <span class="category-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('category.show', 'hadith-sunnah') }}" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
                
                <!-- Fiqh & Jurisprudence -->
                <div class="col-md-3 col-sm-6">
                    <div class="popular-tag-card">
                        <div class="popular-tag-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3 class="popular-tag-name">Fiqh & Jurisprudence</h3>
                        <div class="mb-3">
                            @php
                                $fiqhTags = $tags->filter(function($tag) {
                                    $fiqhKeywords = ['fiqh', 'halal', 'haram', 'prayer', 'fasting', 'zakat', 'hajj'];
                                    return Str::contains(strtolower($tag->name), $fiqhKeywords);
                                })->take(3);
                            @endphp
                            @foreach($fiqhTags as $tag)
                            <span class="category-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('category.show', 'fiqh-jurisprudence') }}" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
                
                <!-- Spirituality -->
                <div class="col-md-3 col-sm-6">
                    <div class="popular-tag-card">
                        <div class="popular-tag-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="popular-tag-name">Spirituality</h3>
                        <div class="mb-3">
                            @php
                                $spiritualityTags = $tags->filter(function($tag) {
                                    $spiritKeywords = ['patience', 'sabr', 'taqwa', 'iman', 'tawakkul', 'zikr', 'dua'];
                                    return Str::contains(strtolower($tag->name), $spiritKeywords);
                                })->take(3);
                            @endphp
                            @foreach($spiritualityTags as $tag)
                            <span class="category-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('category.show', 'spirituality') }}" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
        
        // Alphabet filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const alphabetLetters = document.querySelectorAll('.alphabet-letter');
            const tagItems = document.querySelectorAll('.tag-item');
            
            alphabetLetters.forEach(letter => {
                letter.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (this.classList.contains('disabled')) return;
                    
                    // Remove active class from all letters
                    alphabetLetters.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked letter
                    this.classList.add('active');
                    
                    const selectedLetter = this.dataset.letter;
                    
                    // Show/hide tags based on selected letter
                    tagItems.forEach(tag => {
                        if (selectedLetter === 'all') {
                            tag.style.display = 'inline-block';
                        } else {
                            const tagLetter = tag.dataset.letter;
                            if (tagLetter === selectedLetter) {
                                tag.style.display = 'inline-block';
                            } else {
                                tag.style.display = 'none';
                            }
                        }
                    });
                    
                    // Update URL without page reload (for bookmarking)
                    const url = new URL(window.location);
                    if (selectedLetter === 'all') {
                        url.searchParams.delete('letter');
                    } else {
                        url.searchParams.set('letter', selectedLetter);
                    }
                    window.history.pushState({}, '', url);
                });
            });
            
            // Check URL for letter parameter on page load
            const urlParams = new URLSearchParams(window.location.search);
            const letterParam = urlParams.get('letter');
            if (letterParam) {
                const letterElement = document.querySelector(`.alphabet-letter[data-letter="${letterParam.toUpperCase()}"]`);
                if (letterElement && !letterElement.classList.contains('disabled')) {
                    letterElement.click();
                }
            }
            
            // Sort functionality (optional - can be added if needed)
            const sortOptions = document.querySelectorAll('.sort-option');
            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortType = this.dataset.sort;
                    
                    // Convert NodeList to Array for sorting
                    const tagArray = Array.from(tagItems);
                    
                    if (sortType === 'name') {
                        // Sort by name
                        tagArray.sort((a, b) => {
                            const nameA = a.querySelector('.tag-link').textContent.toLowerCase();
                            const nameB = b.querySelector('.tag-link').textContent.toLowerCase();
                            return nameA.localeCompare(nameB);
                        });
                    } else if (sortType === 'count') {
                        // Sort by count
                        tagArray.sort((a, b) => {
                            const countA = parseInt(a.dataset.count) || 0;
                            const countB = parseInt(b.dataset.count) || 0;
                            return countB - countA; // Descending order
                        });
                    }
                    
                    // Re-append sorted tags
                    const container = document.getElementById('tagsContainer');
                    container.innerHTML = '';
                    tagArray.forEach(tag => {
                        container.appendChild(tag);
                    });
                });
            });
        });
    </script>
</body>
</html>