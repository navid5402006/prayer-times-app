@section('title', translate('Islamic Blogs | Prayer Times, Duas, Hadith & Islamic Articles'))

@section('description', translate('Read authentic Islamic blog articles about prayer times, daily duas, hadith of the day, Ramadan timetable, Islamic calendar, and spiritual guidance for Muslims worldwide.'))

@section('keywords', translate('islamic blog, prayer time blog, salah articles, daily dua, hadith of the day, ramadan timetable, islamic calendar, muslim guidance, islamic articles'))

@section('robot', 'index, follow')
@section('googlebot', 'index, follow')

@include('header')

<style>
    :root {
        --primary: #0f766e;
        --primary-dark: #0d5a54;
        --primary-light: #ccfbf1;
        --accent: #f59e0b;
        --dark: #1e293b;
        --gray: #64748b;
        --gray-light: #f1f5f9;
        --white: #ffffff;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--gray-light);
        color: var(--dark);
    }
    
    /* Hero Section - Animated */
    .hero {
        background: linear-gradient(135deg, #0f766e 0%, #0d5a54 50%, #0a4a44 100%);
        padding: 5rem 0;
        position: relative;
        isolation: isolate;
        overflow: hidden;
    }
    
    .hero::before {
        content: '☪';
        position: absolute;
        font-size: 28rem;
        opacity: 0.03;
        bottom: -8rem;
        right: -8rem;
        animation: floatStar 20s ease-in-out infinite;
        pointer-events: none;
    }
    
    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat bottom;
        background-size: cover;
        opacity: 0.5;
        pointer-events: none;
        animation: waveMove 12s ease-in-out infinite;
    }
    
    @keyframes floatStar {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        50% {
            transform: translateY(-40px) rotate(8deg);
        }
    }
    
    @keyframes waveMove {
        0%, 100% {
            transform: translateX(0) scaleX(1);
        }
        50% {
            transform: translateX(-30px) scaleX(1.02);
        }
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #ffffff, #fef9c3);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -0.02em;
        animation: titleGlow 2s ease-in-out infinite;
    }
    
    @keyframes titleGlow {
        0%, 100% {
            text-shadow: 0 0 0px rgba(255,255,255,0);
        }
        50% {
            text-shadow: 0 0 30px rgba(255,255,255,0.3);
        }
    }
    
    .hero p {
        font-size: 1.2rem;
        color: rgba(255,255,255,0.95);
        max-width: 600px;
        margin: 0 auto;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }
    
    /* Floating Orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.1), rgba(255,255,255,0));
        pointer-events: none;
        animation: floatOrb 15s ease-in-out infinite;
    }
    
    .orb-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -100px;
        animation-delay: 0s;
    }
    
    .orb-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        right: 20%;
        animation-delay: 2s;
        animation-duration: 18s;
    }
    
    .orb-3 {
        width: 400px;
        height: 400px;
        top: 30%;
        right: -150px;
        animation-delay: 4s;
        animation-duration: 22s;
    }
    
    @keyframes floatOrb {
        0%, 100% {
            transform: translateY(0) translateX(0) scale(1);
        }
        33% {
            transform: translateY(-30px) translateX(20px) scale(1.05);
        }
        66% {
            transform: translateY(20px) translateX(-20px) scale(0.95);
        }
    }
    
    /* Search Container */
    .search-container {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .search-modern {
        background: white;
        border-radius: 2rem;
        padding: 0.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    
    .search-modern:focus-within {
        border-color: var(--primary);
        box-shadow: 0 4px 20px rgba(15, 118, 110, 0.15);
        transform: translateY(-2px);
    }
    
    .search-modern i {
        padding-left: 1rem;
        color: var(--gray);
        font-size: 1rem;
    }
    
    .search-modern input {
        flex: 1;
        border: none;
        padding: 0.8rem 0;
        font-size: 0.95rem;
        background: transparent;
        outline: none;
    }
    
    /* Search Suggestions */
    .search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 1rem;
        margin-top: 0.5rem;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }
    
    .search-suggestions.show {
        display: block;
        animation: slideDown 0.2s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .suggestion-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .suggestion-item:last-child {
        border-bottom: none;
    }
    
    .suggestion-item:hover {
        background: var(--primary-light);
    }
    
    .suggestion-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--dark);
    }
    
    .suggestion-category {
        font-size: 0.7rem;
        color: var(--gray);
        margin-top: 0.25rem;
    }
    
    .search-counter {
        font-size: 0.85rem;
        color: var(--gray);
        margin-top: 0.75rem;
        padding: 0 0.5rem;
    }
    
    .search-counter span {
        font-weight: 600;
        color: var(--primary);
    }
    
    /* Blog Cards */
    .blog-card {
        background: var(--white);
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #e2e8f0;
    }
    
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -12px rgba(0,0,0,0.1);
        border-color: var(--primary-light);
    }
    
    .blog-image {
        height: 210px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .blog-category {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--primary);
        color: white;
        padding: 0.25rem 0.875rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .blog-content {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .blog-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .blog-title a {
        color: var(--dark);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .blog-title a:hover {
        color: var(--primary);
    }
    
    .blog-excerpt {
        color: var(--gray);
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex: 1;
    }
    
    .blog-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.7rem;
        color: var(--gray);
        border-top: 1px solid #e2e8f0;
        padding-top: 0.75rem;
        margin-top: auto;
    }
    
    .blog-author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .author-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.7rem;
    }
    
    /* Sidebar Widgets */
    .sidebar-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    
    .sidebar-card:hover {
        border-color: var(--primary-light);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .widget-head {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-light);
        display: inline-block;
    }
    
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .category-list li {
        margin-bottom: 0.7rem;
    }
    
    .category-list a {
        color: var(--dark);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        transition: color 0.2s;
    }
    
    .category-list a:hover {
        color: var(--primary);
    }
    
    .category-list span {
        background: var(--gray-light);
        padding: 0.125rem 0.5rem;
        border-radius: 1rem;
        font-size: 0.65rem;
        color: var(--gray);
    }
    
    .tag-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .tag-cloud a {
        background: var(--gray-light);
        padding: 0.25rem 0.875rem;
        border-radius: 1.5rem;
        font-size: 0.75rem;
        color: var(--dark);
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .tag-cloud a:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .recent-item {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .recent-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .recent-img {
        width: 55px;
        height: 55px;
        border-radius: 0.5rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .recent-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .recent-info h4 {
        font-size: 0.8rem;
        margin: 0 0 0.25rem 0;
        line-height: 1.4;
        font-weight: 600;
    }
    
    .recent-info a {
        text-decoration: none;
        color: var(--dark);
    }
    
    .recent-info a:hover {
        color: var(--primary);
    }
    
    .recent-info span {
        font-size: 0.65rem;
        color: var(--gray);
    }
    
    /* ============================================ */
    /* CUSTOM PAGINATION - BEAUTIFUL & MODERN */
    /* ============================================ */
    .custom-pagination {
        margin-top: 3rem;
        text-align: center;
    }
    
    .custom-pagination nav {
        display: inline-block;
    }
    
    .custom-pagination ul {
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    
    .custom-pagination li {
        display: inline-block;
        margin: 0;
    }
    
    .custom-pagination a,
    .custom-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        height: 44px;
        padding: 0 1rem;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #334155;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.25s ease;
        cursor: pointer;
        font-family: inherit;
    }
    
    /* Hover Effect */
    .custom-pagination a:hover {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(15, 118, 110, 0.15);
    }
    
    /* Active Page */
    .custom-pagination .active span {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);
        transform: scale(1.05);
        font-weight: 700;
    }
    
    /* Disabled State (Previous/Next when on first/last page) */
    .custom-pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        background: #f8fafc;
        transform: none;
    }
    
    /* Previous & Next Buttons - Special Styling */
    .custom-pagination li:first-child a,
    .custom-pagination li:first-child span,
    .custom-pagination li:last-child a,
    .custom-pagination li:last-child span {
        min-width: auto;
        padding: 0 1.25rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .custom-pagination li:first-child a:hover,
    .custom-pagination li:last-child a:hover {
        transform: translateX(0) translateY(-2px);
    }
    
    /* Dots / Ellipsis Styling */
    .custom-pagination .disabled:not(.active) span {
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: default;
        min-width: auto;
        padding: 0 0.5rem;
        box-shadow: none;
        transform: none;
    }
    
    .custom-pagination .disabled:not(.active) span:hover {
        background: transparent;
        transform: none;
        box-shadow: none;
    }
    
    /* Pagination Info */
    .pagination-stats {
        text-align: center;
        margin-top: 1.25rem;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }
    
    .pagination-stats i {
        margin: 0 0.25rem;
        font-size: 0.75rem;
    }
    
    /* Newsletter */
    .newsletter-box {
        background: linear-gradient(135deg, var(--primary-light) 0%, #e6f7f5 100%);
        border: none;
    }
    
    .newsletter-box input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 2rem;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
        outline: none;
        transition: all 0.2s;
    }
    
    .newsletter-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(15, 118, 110, 0.1);
    }
    
    .newsletter-box button {
        width: 100%;
        background: var(--primary);
        border: none;
        padding: 0.7rem;
        border-radius: 2rem;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .newsletter-box button:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero {
            padding: 3rem 0;
        }
        
        .hero h1 {
            font-size: 2rem;
        }
        
        .hero p {
            font-size: 1rem;
        }
        
        .blog-image {
            height: 180px;
        }
        
        .orb-1, .orb-2, .orb-3 {
            display: none;
        }
        
        .custom-pagination ul {
            gap: 0.4rem;
        }
        
        .custom-pagination a,
        .custom-pagination span {
            min-width: 38px;
            height: 38px;
            font-size: 0.85rem;
            padding: 0 0.75rem;
            border-radius: 10px;
        }
        
        .custom-pagination li:first-child a,
        .custom-pagination li:first-child span,
        .custom-pagination li:last-child a,
        .custom-pagination li:last-child span {
            padding: 0 1rem;
        }
        
        .pagination-stats {
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero h1 {
            font-size: 1.6rem;
        }
        
        .blog-title {
            font-size: 1rem;
        }
        
        .custom-pagination ul {
            gap: 0.3rem;
        }
        
        .custom-pagination a,
        .custom-pagination span {
            min-width: 34px;
            height: 34px;
            font-size: 0.8rem;
            padding: 0 0.6rem;
            border-radius: 8px;
        }
        
        .custom-pagination li:first-child a,
        .custom-pagination li:first-child span,
        .custom-pagination li:last-child a,
        .custom-pagination li:last-child span {
            padding: 0 0.8rem;
        }
        
        .pagination-stats {
            font-size: 0.7rem;
        }
    }
</style>

<!-- Hero Section with Animations -->
<section class="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="container">
        <div class="hero-content">
            <h1>📖 Islamic Insights</h1>
            <p>Discover authentic Islamic articles, duas, and spiritual guidance for your journey</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Column - Blog Posts -->
            <div class="col-lg-8">
                <!-- Search Container with Suggestions -->
                <div class="search-container">
                    <div class="search-modern">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search articles by title or category..." autocomplete="off">
                    </div>
                    <div id="searchSuggestions" class="search-suggestions"></div>
                    <div class="search-counter" id="searchCounter" style="display: none;">
                        Found <span id="resultCount">0</span> articles
                    </div>
                </div>
                
                <!-- Blog Grid -->
                <div class="row g-4" id="blogsGrid">
                    @forelse($blogs as $blog)
                    <div class="col-md-6 blog-item" 
                         data-id="{{ $blog->id }}"
                         data-title="{{ strtolower($blog->title) }}" 
                         data-category="{{ strtolower($blog->category->name ?? '') }}"
                         data-url="{{ url('/blog') }}/{{$blog->slug}}">
                        <div class="blog-card">
                            <div class="blog-image" style="background-image: url('https://nextprayertime.com/{{$blog->image}}')">
                                <span class="blog-category">{{ $blog->category->name ?? 'General' }}</span>
                            </div>
                            <div class="blog-content">
                                <h3 class="blog-title">
                                    <a href="{{ url('/blog') }}/{{$blog->slug}}">{{ $blog->title }}</a>
                                </h3>
                                <p class="blog-excerpt">{{ Str::limit($blog->excerpt, 95) }}</p>
                                <div class="blog-meta">
                                    <div class="blog-author">
                                        <div class="author-avatar">{{ substr($blog->user->name ?? 'AU', 0, 2) }}</div>
                                        <span>{{ $blog->user->name ?? 'Editor' }}</span>
                                    </div>
                                    <span><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5 bg-white rounded-4">
                            <i class="fas fa-book-open" style="font-size: 3rem; color: #cbd5e1;"></i>
                            <h4 class="mt-3">No articles found</h4>
                            <p class="text-muted">Check back later for new content</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- CUSTOM PAGINATION - Beautiful & Modern -->
                @if($blogs instanceof \Illuminate\Pagination\LengthAwarePaginator && $blogs->hasPages())
                <div class="custom-pagination">
                    {{ $blogs->appends(request()->query())->links() }}
                </div>
                @if($blogs->total() > 0)
                <div class="pagination-stats">
                    <i class="fas fa-book-open"></i> Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} articles
                </div>
                @endif
                @endif
            </div>
            
            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="sidebar-card">
                    <h3 class="widget-head">📚 Categories</h3>
                    <ul class="category-list">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ url('category') }}/{{$category->slug}}">
                                {{ $category->name }}
                                <span>{{ $category->blogs_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Recent Posts -->
                <div class="sidebar-card">
                    <h3 class="widget-head">🕋 Recent Posts</h3>
                    @foreach($recentPosts as $post)
                    <div class="recent-item">
                        <div class="recent-img">
                            <img src="https://nextprayertime.com/{{$post->image}}" alt="{{$post->title}}" loading="lazy">
                        </div>
                        <div class="recent-info">
                            <h4><a href="{{ url('blog', $post->slug) }}">{{ Str::limit($post->title, 45) }}</a></h4>
                            <span><i class="far fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Tags -->
                <div class="sidebar-card">
                    <h3 class="widget-head">🏷️ Popular Tags</h3>
                    <div class="tag-cloud">
                        @foreach($popularTags as $tag)
                        <a href="{{ url('tag', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="sidebar-card newsletter-box">
                    <h3 class="widget-head">✉️ Newsletter</h3>
                    <p style="font-size: 0.8rem; color: var(--gray); margin-bottom: 1rem;">Get the latest articles straight to your inbox</p>
                    <form id="newsletterForm">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe <i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
    (function() {
        // Get all blog items
        const blogItems = document.querySelectorAll('.blog-item');
        const blogsGrid = document.getElementById('blogsGrid');
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('searchSuggestions');
        const searchCounter = document.getElementById('searchCounter');
        const resultCountSpan = document.getElementById('resultCount');
        
        // Store all blog data for suggestions
        const blogData = Array.from(blogItems).map(item => ({
            id: item.getAttribute('data-id'),
            title: item.getAttribute('data-title'),
            category: item.getAttribute('data-category'),
            url: item.getAttribute('data-url')
        }));
        
        // Live search function
        function performLiveSearch() {
            const query = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;
            
            blogItems.forEach(item => {
                const title = item.getAttribute('data-title') || '';
                const category = item.getAttribute('data-category') || '';
                const matches = query === '' || title.includes(query) || category.includes(query);
                
                if (matches) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update search counter
            if (query !== '') {
                searchCounter.style.display = 'block';
                resultCountSpan.textContent = visibleCount;
            } else {
                searchCounter.style.display = 'none';
            }
            
            // Handle no results message
            let noResultsDiv = document.getElementById('noResultsMsg');
            if (visibleCount === 0 && query !== '') {
                if (!noResultsDiv) {
                    noResultsDiv = document.createElement('div');
                    noResultsDiv.id = 'noResultsMsg';
                    noResultsDiv.className = 'col-12';
                    noResultsDiv.innerHTML = `
                        <div class="text-center py-5 bg-white rounded-4">
                            <i class="fas fa-search" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                            <h5 class="mt-3">No matching articles found</h5>
                            <p class="text-muted">Try a different keyword or browse categories</p>
                        </div>
                    `;
                    blogsGrid.appendChild(noResultsDiv);
                }
            } else if (noResultsDiv) {
                noResultsDiv.remove();
            }
        }
        
        // Show suggestions function
        function showSuggestions() {
            const query = searchInput.value.trim().toLowerCase();
            
            if (query === '') {
                suggestionsDiv.classList.remove('show');
                return;
            }
            
            const matches = blogData.filter(blog => 
                blog.title.includes(query) || blog.category.includes(query)
            ).slice(0, 5);
            
            if (matches.length > 0) {
                suggestionsDiv.innerHTML = matches.map(blog => `
                    <div class="suggestion-item" data-url="${blog.url}">
                        <div class="suggestion-title">${blog.title}</div>
                        <div class="suggestion-category">Category: ${blog.category || 'General'}</div>
                    </div>
                `).join('');
                suggestionsDiv.classList.add('show');
                
                document.querySelectorAll('.suggestion-item').forEach(item => {
                    item.addEventListener('click', function() {
                        window.location.href = this.getAttribute('data-url');
                    });
                });
            } else {
                suggestionsDiv.classList.remove('show');
            }
        }
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.classList.remove('show');
            }
        });
        
        // Event listeners for search
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                performLiveSearch();
                showSuggestions();
            });
        }
        
        // Newsletter form
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('✓ Thank you for subscribing! You\'ll receive our latest articles.');
                this.reset();
            });
        }
        
        // Footer year
        const yearSpan = document.getElementById('currentYear');
        if (yearSpan) yearSpan.textContent = new Date().getFullYear();
    })();
</script>