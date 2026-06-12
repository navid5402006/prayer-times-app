@section('title', $category->name)

@section('description', $category->description )

@section('keywords', $category->name )

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
        
        .category-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
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
        
        /* Blog Cards */
        .blog-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            background: white;
            height: 100%;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .blog-card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .blog-card-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .blog-card-content {
            padding: 25px;
        }
        
        .blog-card-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--text-dark);
        }
        
        .blog-card-title a {
            color: inherit;
            text-decoration: none;
        }
        
        .blog-card-title a:hover {
            color: var(--primary-color);
        }
        
        .blog-card-excerpt {
            color: var(--text-light);
            margin-bottom: 20px;
        }
        
        .blog-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        .blog-card-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
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
        
        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 50px;
        }
        
        .page-link {
            color: var(--text-dark);
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin: 0 5px;
            border-radius: 5px;
        }
        
        .page-link:hover, .page-item.active .page-link {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
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
        }
    </style>

    @include('header')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="category-badge">
                <i class="fas fa-folder me-2"></i>Category
            </div>
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description ?? 'Explore all articles in this category' }}</p>
            <div class="mt-4">
                <span class="badge bg-light text-dark fs-6">
                    <i class="fas fa-newspaper me-1"></i>
                    {{ $blogs->total() }} Articles
                </span>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <h2 class="section-title">Articles in {{ $category->name }}</h2>
                    
                    @if($blogs->count() > 0)
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-6">
                            <div class="blog-card">
                                <div class="blog-card-image" style="background-image: url('{{ $blog->image ? Storage::url($blog->image) : 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}');">
                                    <div class="blog-card-category">{{ $blog->category->name ?? 'Uncategorized' }}</div>
                                </div>
                                <div class="blog-card-content">
                                    <h3 class="blog-card-title">
                                        <a href="{{ route('blog_detail', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h3>
                                    <p class="blog-card-excerpt">{{ Str::limit($blog->excerpt, 120) }}</p>
                                    <div class="blog-card-meta">
                                        <div class="blog-card-author">
                                            <div class="author-avatar">{{ substr($blog->user->name ?? 'AU', 0, 2) }}</div>
                                            <span>{{ $blog->user->name ?? 'Admin User' }}</span>
                                        </div>
                                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($blogs->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if($blogs->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $blogs->previousPageUrl() }}">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                                @if($page == $blogs->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($blogs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $blogs->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    @endif
                    
                    @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3>No Articles Found</h3>
                        <p>There are no published articles in this category at the moment. Please check back later.</p>
@if(Route::has('blogs.index'))
    <a href="{{ route('blogs.index') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left me-2"></i>Back to All Articles
    </a>
@else
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left me-2"></i>Back to Home
    </a>
@endif
                    </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Category Info Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Category Info</h3>
                        <div class="text-center">
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
                            <div class="category-icon-large mb-3">
                                <i class="{{ $icon }} fa-3x" style="color: var(--primary-color);"></i>
                            </div>
                            <h4>{{ $category->name }}</h4>
                            <p class="text-muted">{{ $blogs->total() }} Articles</p>
                            @if($category->description)
                            <p class="small text-muted">{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>
                    
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