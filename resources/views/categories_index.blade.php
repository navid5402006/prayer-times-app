@section('title', 'FInd blog ')

@section('description', translate('Read authentic Islamic blog articles about prayer times, daily duas, hadith of the day, Ramadan timetable, Islamic calendar, and spiritual guidance for Muslims worldwide.'))

@section('keywords', translate('islamic blog, prayer time blog, salah articles, daily dua, hadith of the day, ramadan timetable, islamic calendar, muslim guidance, islamic articles'))

@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
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
        
        /* Category Cards */
        .category-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            background: white;
            text-align: center;
            padding: 40px 30px;
            border: 1px solid #f0f0f0;
            height: 100%;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: var(--primary-color);
        }
        
        .category-title {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--text-dark);
        }
        
        .category-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .category-title a:hover {
            color: var(--primary-color);
        }
        
        .category-count {
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .category-description {
            color: var(--text-light);
            margin-bottom: 25px;
            font-size: 0.95rem;
        }
        
        .category-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .category-link:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }
        
        /* Stats Section */
        .stats-section {
            background: var(--accent-color);
            padding: 60px 0;
        }
        
        .stat-card {
            text-align: center;
            padding: 30px 20px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1.1rem;
            color: var(--text-dark);
            font-weight: 600;
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
        
        /* Newsletter Widget */
        .newsletter-form {
            display: flex;
            flex-direction: column;
        }
        
        .newsletter-form input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .newsletter-form button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #267349;
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
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: var(--text-dark);
            margin-bottom: 15px;
        }
        
        .empty-state p {
            color: var(--text-light);
            font-size: 1.1rem;
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
            
            .category-card {
                padding: 30px 20px;
            }
        }
    </style>

    @include('header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Blog Categories</h1>
            <p>Explore Islamic knowledge through our organized categories</p>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ $categories->count() }}</div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ $categories->sum('blogs_count') }}</div>
                        <div class="stat-label">Articles</div>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-number">{{ \App\Models\Blog::sum('views') }}+</div>
                        <div class="stat-label">Readers</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section bg-light">
        <div class="container">
            <h2 class="section-title">All Categories</h2>
            
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    @if($categories->count() > 0)
                    <div class="row">
                        @foreach($categories as $category)
                        <div class="col-md-6 col-lg-4">
                            <div class="category-card">
                                <div class="category-icon">
                                    @php
                                        $icons = [
                                            'quran' => 'fas fa-quran',
                                            'hadith' => 'fas fa-book',
                                            'sunnah' => 'fas fa-book',
                                            'spirituality' => 'fas fa-heart',
                                            'fiqh' => 'fas fa-balance-scale',
                                            'jurisprudence' => 'fas fa-balance-scale',
                                            'history' => 'fas fa-history',
                                            'family' => 'fas fa-home',
                                            'society' => 'fas fa-home',
                                            'current affairs' => 'fas fa-globe',
                                            'seerah' => 'fas fa-graduation-cap',
                                            'charity' => 'fas fa-hands-helping',
                                            'social justice' => 'fas fa-hands-helping',
                                            'prayer' => 'fas fa-pray',
                                            'ramadan' => 'fas fa-moon',
                                            'hajj' => 'fas fa-kaaba',
                                            'zakat' => 'fas fa-hand-holding-usd',
                                            'islamic finance' => 'fas fa-coins'
                                        ];
                                        
                                        $icon = 'fas fa-folder';
                                        $categoryName = strtolower($category->name);
                                        
                                        foreach($icons as $keyword => $iconClass) {
                                            if (str_contains($categoryName, $keyword)) {
                                                $icon = $iconClass;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <i class="{{ $icon }}"></i>
                                </div>
                                <h3 class="category-title">
                                    <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                </h3>
                                <div class="category-count">{{ $category->blogs_count }} Articles</div>
                                <p class="category-description">
                                    {{ $category->description ?? 'Explore insightful articles and knowledge in this category.' }}
                                </p>
                                <a href="{{ route('category.show', $category->slug) }}" class="category-link">
                                    Explore Category <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>No Categories Found</h3>
                        <p>There are no categories available at the moment. Please check back later.</p>
                    </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Popular Categories Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Popular Categories</h3>
                        <ul class="category-list">
                            @foreach($categories->sortByDesc('blogs_count')->take(5) as $popularCategory)
                            <li>
                                <a href="{{ route('category.show', $popularCategory->slug) }}">
                                    {{ $popularCategory->name }} 
                                    <span>({{ $popularCategory->blogs_count }})</span>
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
                                        {{ $recentPost->title }}
                                    </a>
                                </h4>
                                <span>{{ $recentPost->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Popular Tags</h3>
                        <div class="tag-list">
                            @foreach($popularTags as $tag)
                            <a href="{{ route('tag.show', $tag->slug) }}">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Newsletter Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Newsletter</h3>
                        <p>Subscribe to our newsletter to receive updates on new articles.</p>
                        <form class="newsletter-form" action="" method="POST">
                            @csrf
                            <input type="text" name="name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <button type="submit">Subscribe</button>
                        </form>
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
    </script>
</body>
</html>