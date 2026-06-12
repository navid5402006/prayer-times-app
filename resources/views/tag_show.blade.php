@section('title', $tag->name )  
 @section('description',  $tag->description)
 @section('keywords',$tag->name)
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
    

    @include('header')
<style>
        :root {
            --tag-primary: #146568;
            --tag-secondary: #4cf0b9;
            --tag-accent: #F0F8FF;
            --tag-dark: #1A1A2E;
            --tag-light: #6C757D;
            --tag-bg: #F8FAFC;
        }
        
       
        
        /* Hero Section - Tag Specific */
        .tag-hero {
            background: linear-gradient(135deg, var(--tag-primary) 0%, var(--tag-secondary) 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .tag-hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }
        
        .tag-hero h1 {
            font-weight: 800;
            margin-bottom: 20px;
            font-size: 2.8rem;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .tag-hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
        }
        
        .tag-badge {
            background: rgba(255,255,255,0.25);
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .tag-count-badge {
            background: rgba(255,255,255,0.9);
            color: var(--tag-primary);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 700;
            display: inline-block;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        /* Section Styles */
        .tag-section {
            padding: 80px 0;
        }
        
        .section-title {
            font-weight: 800;
            color: var(--tag-dark);
            margin-bottom: 50px;
            position: relative;
            text-align: center;
            font-size: 2rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 5px;
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
        }
        
        /* Blog Cards - Tag Specific */
        .tag-blog-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            margin-bottom: 30px;
            background: white;
            height: 100%;
            border: 1px solid rgba(67, 97, 238, 0.1);
        }
        
        .tag-blog-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.2);
            border-color: rgba(67, 97, 238, 0.3);
        }
        
        .tag-blog-card-image {
            height: 220px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.5s;
        }
        
        .tag-blog-card:hover .tag-blog-card-image {
            transform: scale(1.05);
        }
        
        .tag-blog-card-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            color: white;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .tag-blog-card-content {
            padding: 25px;
        }
        
        .tag-blog-card-title {
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--tag-dark);
            line-height: 1.4;
        }
        
        .tag-blog-card-title a {
            color: inherit;
            text-decoration: none;
            background-image: linear-gradient(to right, var(--tag-primary), var(--tag-primary));
            background-position: 0% 100%;
            background-repeat: no-repeat;
            background-size: 0% 2px;
            transition: background-size 0.3s, color 0.3s;
            padding-bottom: 2px;
        }
        
        .tag-blog-card-title a:hover {
            color: var(--tag-primary);
            background-size: 100% 2px;
        }
        
        .tag-blog-card-excerpt {
            color: var(--tag-light);
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .tag-blog-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: var(--tag-light);
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-top: 15px;
        }
        
        .tag-blog-card-author {
            display: flex;
            align-items: center;
        }
        
        .tag-author-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            background: linear-gradient(135deg, var(--tag-primary), var(--tag-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        /* Sidebar Styles - Tag Specific */
        .tag-sidebar-widget {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.08);
            border: 1px solid rgba(67, 97, 238, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .tag-sidebar-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.12);
        }
        
        .widget-title {
            font-weight: 800;
            color: var(--tag-dark);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--tag-accent);
            font-size: 1.3rem;
            position: relative;
        }
        
        .widget-title:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            bottom: -3px;
            left: 0;
        }
        
        .category-list, .tag-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-list li, .tag-list li {
            margin-bottom: 12px;
        }
        
        .category-list a, .tag-list a {
            color: var(--tag-dark);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            padding: 12px 15px;
            border-radius: 10px;
            transition: all 0.3s;
            background-color: var(--tag-bg);
            align-items: center;
        }
        
        .category-list a:hover, .tag-list a:hover {
            color: var(--tag-primary);
            background-color: var(--tag-accent);
            transform: translateX(5px);
            box-shadow: 0 5px 10px rgba(67, 97, 238, 0.1);
        }
        
        .category-list a span, .tag-list a span {
            background: var(--tag-primary);
            color: white;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
        }
        
        .tag-list a {
            background: linear-gradient(to right, var(--tag-accent), white);
            padding: 8px 20px;
            border-radius: 25px;
            margin-right: 8px;
            margin-bottom: 12px;
            display: inline-block;
            border: 1px solid rgba(67, 97, 238, 0.1);
            font-weight: 600;
        }
        
        .tag-list a:hover {
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            color: white;
            transform: translateY(-3px);
        }
        
        .recent-post {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .recent-post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .recent-post-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            margin-right: 15px;
            flex-shrink: 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .recent-post-content h4 {
            font-size: 1rem;
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .recent-post-content h4 a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .recent-post-content h4 a:hover {
            color: var(--tag-primary);
        }
        
        .recent-post-content span {
            font-size: 0.85rem;
            color: var(--tag-light);
        }
        
        /* Tag Info Widget */
        .tag-info-widget {
            background: linear-gradient(135deg, var(--tag-primary) 0%, var(--tag-secondary) 100%);
            color: white;
        }
        
        .tag-info-widget .widget-title {
            color: white;
            border-bottom-color: rgba(255,255,255,0.3);
        }
        
        .tag-info-widget .widget-title:after {
            background: white;
        }
        
        .tag-icon-large {
            font-size: 3.5rem;
            margin-bottom: 20px;
            display: block;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        /* Pagination */
        .tag-pagination {
            justify-content: center;
            margin-top: 50px;
        }
        
        .page-link {
            color: var(--tag-dark);
            border: 2px solid rgba(67, 97, 238, 0.1);
            padding: 10px 18px;
            margin: 0 5px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            color: white;
            border-color: var(--tag-primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        .page-item.active .page-link {
            background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary));
            color: white;
            border-color: var(--tag-primary);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        /* Empty State */
        .tag-empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.08);
        }
        
        .tag-empty-state-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, var(--tag-primary), var(--tag-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 25px;
        }
        
        .tag-empty-state h3 {
            color: var(--tag-dark);
            margin-bottom: 15px;
            font-weight: 800;
        }
        
        .tag-empty-state p {
            color: var(--tag-light);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 25px;
        }
        
        /* Footer */
        footer {
            background: var(--tag-dark);
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
            background: var(--tag-primary);
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
            .tag-hero {
                padding: 60px 0;
            }
            
            .tag-hero h1 {
                font-size: 2.2rem;
            }
            
            .tag-section {
                padding: 60px 0;
            }
            
            .section-title {
                font-size: 1.7rem;
            }
        }
        
        /* Tag Cloud Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .tag-hero h1 {
            animation: float 6s ease-in-out infinite;
        }
    </style>
    <!-- Hero Section -->
    <section class="tag-hero">
        <div class="container">
            <div class="tag-badge">
                <i class="fas fa-tag me-2"></i>Tag
            </div>
            <h1>{{ $tag->name }}</h1>
            <p>{{ $tag->description ?? 'Explore all articles tagged with ' . $tag->name }}</p>
            <div class="tag-count-badge">
                <i class="fas fa-newspaper me-2"></i>
                {{ $blogs->total() }} Articles
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="tag-section">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    <h2 class="section-title">Articles Tagged: <span style="color: var(--tag-primary);">#{{ $tag->name }}</span></h2>
                   <!-- <hr> -->
                    <!-- <p>{{$tag->description}}</p> -->
                   <!-- <hr> -->
                    @if($blogs->count() > 0)
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-6">
                            <div class="tag-blog-card">
                                <div class="tag-blog-card-image" style="background-image: url('https://nextprayertime.com/{{$blog->image}}');">
                                    <div class="tag-blog-card-category">{{ $blog->category->name ?? 'Uncategorized' }}</div>
                                </div>
                                <div class="tag-blog-card-content">
                                    <h3 class="tag-blog-card-title">
                                        <a href="{{ route('blog_detail', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h3>
                                    <p class="tag-blog-card-excerpt">{{ Str::limit($blog->excerpt, 130) }}</p>
                                    <div class="tag-blog-card-meta">
                                        <div class="tag-blog-card-author">
                                            <div class="tag-author-avatar">{{ substr($blog->user->name ?? 'AU', 0, 2) }}</div>
                                            <span>{{ $blog->user->name ?? 'Admin User' }}</span>
                                        </div>
                                        <span><i class="far fa-calendar me-1"></i>{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if($blogs->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination tag-pagination">
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
                    <div class="tag-empty-state">
                        <div class="tag-empty-state-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3>No Articles Found</h3>
                        <p>There are no published articles with the tag <strong>"{{ $tag->name }}"</strong> at the moment. Please check back later or explore other tags.</p>
                        @if(Route::has('blogs.index'))
                        <a href="{{ route('blogs.index') }}" class="btn btn-primary mt-3" style="background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary)); border: none;">
                            <i class="fas fa-arrow-left me-2"></i>Back to All Articles
                        </a>
                        @else
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3" style="background: linear-gradient(to right, var(--tag-primary), var(--tag-secondary)); border: none;">
                            <i class="fas fa-arrow-left me-2"></i>Back to Home
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Tag Info Widget -->
                    <div class="tag-sidebar-widget tag-info-widget">
                        <h3 class="widget-title">Tag Info</h3>
                        <div class="text-center">
                            @php
                                $tagIcons = [
                                    'quran' => 'fas fa-quran',
                                    'hadith' => 'fas fa-book-hadith',
                                    'sunnah' => 'fas fa-sun',
                                    'islam' => 'fas fa-star-and-crescent',
                                    'muslim' => 'fas fa-mosque',
                                    'prayer' => 'fas fa-pray',
                                    'ramadan' => 'fas fa-moon',
                                    'hajj' => 'fas fa-kaaba',
                                    'charity' => 'fas fa-hand-holding-heart',
                                    'family' => 'fas fa-home',
                                    'society' => 'fas fa-users',
                                    'history' => 'fas fa-history',
                                    'science' => 'fas fa-microscope',
                                    'education' => 'fas fa-graduation-cap',
                                    'fiqh' => 'fas fa-balance-scale-right',
                                    'aqeedah' => 'fas fa-brain',
                                    'tasawwuf' => 'fas fa-heart',
                                    'dua' => 'fas fa-hands-praying'
                                ];
                                
                                $tagIcon = 'fas fa-tag';
                                $tagName = strtolower($tag->name);
                                
                                foreach($tagIcons as $keyword => $iconClass) {
                                    if (str_contains($tagName, $keyword)) {
                                        $tagIcon = $iconClass;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="mb-3">
                                <i class="{{ $tagIcon }} tag-icon-large"></i>
                            </div>
                            <h4 class="mb-2" style="color: white;">#{{ $tag->name }}</h4>
                            <p class="mb-3">{{ $blogs->total() }} Articles</p>
                            <!-- @if($tag->description)
                            <p class="small" style="opacity: 0.9;">{{ $tag->description }}</p>
                            @endif -->
                            <div class="mt-4">
                                <a href="{{ route('tags.index') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-tags me-1"></i>All Tags
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Popular Categories Widget -->
                    <div class="tag-sidebar-widget">
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
                    <div class="tag-sidebar-widget">
                        <h3 class="widget-title">Recent Posts</h3>
                        @foreach($recentPosts as $recentPost)
                        <div class="recent-post">
                            <div class="recent-post-image" style="background-image: url('https://nextprayertime.com/{{$recentPost->image}}');"></div>
                            <div class="recent-post-content">
                                <h4>
                                    <a href="{{ route('blog_detail', $recentPost->slug) }}">
                                        {{ Str::limit($recentPost->title, 50) }}
                                    </a>
                                </h4>
                                <span><i class="far fa-calendar me-1"></i>{{ $recentPost->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @php
    // Get popular tags directly if not passed from controller
    $popularTags = App\Models\BlogTag::withCount('blogs')
        ->orderBy('blogs_count', 'desc')
        ->limit(15)
        ->get();
@endphp
                    <!-- Tags Widget -->
                    <div class="tag-sidebar-widget">
                        <h3 class="widget-title">Popular Tags</h3>
                        <div class="tag-list">
                            @foreach($popularTags as $popularTag)
                            <a href="{{ route('tag.show', $popularTag->slug) }}">#{{ $popularTag->name }}</a>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('tags.index') }}" class="btn btn-sm" style="background: var(--tag-accent); color: var(--tag-primary);">
                                <i class="fas fa-plus me-1"></i>View All Tags
                            </a>
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
        
        // Add animation to cards on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.tag-blog-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>