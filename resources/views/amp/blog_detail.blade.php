<!DOCTYPE html>
<html amp lang="{{ $lang ?? 'en' }}">
<head>
    <!-- AMP required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>{{ $blog->title }}</title>
    <meta name="description" content="{{ $blog->excerpt }}">
    <meta name="keywords" content="{{ $blog->title }}">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ $blog->excerpt }}">
    <meta property="og:image" content="{{ $blog->image ? asset($blog->image) : asset('images/default-blog-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="https://nextprayertime.com/nextprayertime.ico" type="image/x-icon">
    
    <!-- AMP Script -->
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    
    <!-- AMP Components -->
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
    
    <!-- AMP Boilerplate -->
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    
    <style amp-custom>
        :root {
            --primary: #0d6e6e;
            --primary-dark: #054545;
            --text-dark: #1a1a1a;
            --text-light: #666;
            --bg-white: #ffffff;
            --bg-gray: #f8f9fa;
            --border-light: #e9ecef;
            --radius: 16px;
            --success: #2E8B57;
            --error: #dc2626;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: var(--bg-gray);
            color: var(--text-dark);
            line-height: 1.5;
            padding-top: 70px;
        }

        /* Navbar */
        .navbar {
            background: var(--primary);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .navbar-toggler {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 4px;
            padding: 8px 12px;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
        }

        /* Sidebar */
        amp-sidebar {
            background: var(--primary-dark);
            width: 280px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px;
        }

        .sidebar-nav-item { margin: 15px 0; }
        .sidebar-nav-link {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
            padding: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .close-btn {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            width: 100%;
        }

        /* Hero */
        .hero-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            margin: 16px;
            padding: 24px 20px;
            border-radius: var(--radius);
            color: white;
        }
        .hero-category {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 4px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .hero-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 12px; }
        .hero-excerpt { font-size: 1rem; opacity: 0.9; margin-bottom: 20px; }
        .hero-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.2);
            flex-wrap: wrap;
        }

        /* Cards */
        .featured-image-card, .content-card, .tags-card, .share-card, .author-card, .comments-card {
            background: var(--bg-white);
            margin: 16px;
            padding: 20px;
            border-radius: var(--radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .post-content { font-size: 1rem; line-height: 1.7; color: var(--text-light); }
        .post-content h2 { color: var(--text-dark); font-size: 1.5rem; margin: 32px 0 16px; }
        .post-content p { margin-bottom: 20px; }
        .post-content amp-img { border-radius: 12px; margin: 20px 0; }
        img{
            width: 100%;
            border-radius: 13px
        }
        /* Tags */
        .tags-wrapper { display: flex; flex-wrap: wrap; gap: 8px; }
        .tag {
            background: var(--bg-gray);
            color: var(--text-light);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
            text-decoration: none;
        }

        /* Social Share */
        .share-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        amp-social-share { border-radius: 30px; height: 44px; width: 44px; }

        /* Author */
        .author-card { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .author-avatar-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
        }
        .author-details h4 { font-size: 1.2rem; font-weight: 700; margin-bottom: 4px; }
        .author-bio { color: var(--text-light); font-size: 0.9rem; }

        /* Comments */
        .comments-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }
        .comments-title { font-size: 1.2rem; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .comments-count {
            background: var(--bg-gray);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
        }
        .comment-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }
        .comment-content { flex: 1; }
        .comment-author-name { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
        .comment-date { font-size: 0.7rem; color: #999; margin-left: 8px; }
        .comment-text { font-size: 0.9rem; color: var(--text-light); margin-top: 6px; line-height: 1.5; }

        /* AMP Form */
        .comment-form-wrapper {
            display: flex;
            gap: 12px;
            margin: 20px 0;
        }
        .comment-input {
            flex: 1;
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-family: inherit;
        }
        .comment-input:focus {
            outline: none;
            border-color: var(--primary);
        }
        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 24px;
            font-weight: 600;
            cursor: pointer;
        }
        .login-prompt {
            background: var(--bg-gray);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-bottom: 20px;
        }
        .login-prompt a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .empty-state { text-align: center; padding: 40px 20px; color: #999; }

        /* Toast Messages */
        .toast-message {
            background: var(--success);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            margin-top: 12px;
            font-size: 0.85rem;
            text-align: center;
        }
        .toast-error {
            background: var(--error);
        }

        /* Related Posts */
        .related-section { margin: 16px; }
        .related-header { display: flex; justify-content: space-between; margin-bottom: 16px; }
        .related-header h3 { font-size: 1.2rem; font-weight: 700; }
        .view-link { color: var(--primary); text-decoration: none; }
        .related-grid { display: flex; flex-direction: column; gap: 12px; }
        .related-item {
            background: var(--bg-white);
            border-radius: var(--radius);
            display: flex;
            text-decoration: none;
            color: inherit;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .related-item-image { width: 80px; height: 80px; flex-shrink: 0; position: relative; }
        .related-item-content { padding: 12px; flex: 1; }
        .related-item-title { font-weight: 600; font-size: 0.9rem; margin-bottom: 4px; }
        .related-item-date { font-size: 0.7rem; color: #999; }

        /* Footer */
        .site-footer {
            background: #1a1a1a;
            color: white;
            padding: 24px 16px;
            margin-top: 24px;
            text-align: center;
        }
        .footer-bottom { color: #666; font-size: 0.85rem; }

        @media (max-width: 480px) {
            .author-card { flex-direction: column; text-align: center; }
            .hero-title { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <!-- Google Analytics -->
    <amp-analytics type="gtag" data-credentials="include">
        <script type="application/json">
        { "vars": { "gtag_id": "AW-17957861346", "config": { "AW-17957861346": { "groups": "default" } } } }
        </script>
    </amp-analytics>

    <!-- Header -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ $lang ? '/' . $lang : '/' }}">🕌 {{ config('app.name') }}</a>
            <button class="navbar-toggler" on="tap:sidebar.open">☰</button>
        </div>
    </nav>

    <!-- Sidebar -->
    <amp-sidebar id="sidebar" layout="nodisplay" side="left">
        <div class="sidebar-nav">
            <button class="close-btn" on="tap:sidebar.close">✕ Close</button>
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item"><a class="sidebar-nav-link" href="{{ $lang ? '/' . $lang : '/' }}">Home</a></li>
                <li class="sidebar-nav-item"><a class="sidebar-nav-link" href="{{ $lang ? '/' . $lang . '/blogs' : '/blogs' }}">Blogs</a></li>
                <li class="sidebar-nav-item"><a class="sidebar-nav-link" href="{{ $lang ? '/' . $lang . '/ramadan-timing' : '/ramadan-timing' }}">Ramadan Timings</a></li>
                <li class="sidebar-nav-item"><a class="sidebar-nav-link" href="{{ $lang ? '/' . $lang . '/qibla-direction' : '/qibla-direction' }}">Qibla Finder</a></li>
            </ul>
        </div>
    </amp-sidebar>

    <!-- Hero -->
    <div class="hero-card">
        <span class="hero-category">{{ $blog->category->name ?? 'Uncategorized' }}</span>
        <h1 class="hero-title">{{ $blog->title }}</h1>
        <p class="hero-excerpt">{{ $blog->excerpt }}</p>
        <div class="hero-meta">
            <span>✍️ {{ $blog->user->name ?? 'Admin' }}</span>
            <span>📅 {{ $blog->created_at->format('M d, Y') }}</span>
            <span>⏱️ {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
        </div>
    </div>

    <!-- Featured Image -->
    @if($blog->image)
    <div class="featured-image-card">
        <amp-img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" width="1200" height="630" layout="responsive"></amp-img>
    </div>
    @endif

    <!-- Content -->
    <div class="content-card">
        <article class="post-content">
            {!! $blog->content !!}
        </article>
    </div>

    <!-- Tags -->
    @if($blog->tags->count() > 0)
    <div class="tags-card">
        <div class="tags-wrapper">
            @foreach($blog->tags as $tag)
            <a href="{{ url($lang ? $lang . '/tag/' . $tag->slug : 'tag/' . $tag->slug) }}" class="tag">#{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Social Share -->
    <div class="share-card">
        <div class="share-grid">
            <amp-social-share type="facebook" width="44" height="44"></amp-social-share>
            <amp-social-share type="twitter" width="44" height="44"></amp-social-share>
            <amp-social-share type="whatsapp" width="44" height="44"></amp-social-share>
            <amp-social-share type="telegram" width="44" height="44"></amp-social-share>
            <amp-social-share type="system" width="44" height="44"></amp-social-share>
        </div>
    </div>

    <!-- Author -->
    <div class="author-card">
        <div class="author-avatar-large">{{ substr($blog->user->name ?? 'AD', 0, 2) }}</div>
        <div class="author-details">
            <h4>{{ $blog->user->name ?? 'Admin' }}</h4>
            <p class="author-bio">{{ $blog->user->bio ?? 'Writer and Islamic scholar dedicated to sharing knowledge about Islam.' }}</p>
        </div>
    </div>

    <!-- Comments Section - FIXED: Simple AMP Form with proper action handling -->
    <div class="comments-card">
        <div class="comments-header">
            <div class="comments-title">
                💬 Comments
                <span class="comments-count" id="commentCount">{{ $blog->comments()->count() }}</span>
            </div>
        </div>

        <!-- Comments List Container -->
        <div id="commentsList">
            @forelse($blog->comments()->with('user')->latest()->get() as $comment)
            <div class="comment-item">
                <div class="comment-avatar">{{ substr($comment->user->name ?? 'GU', 0, 2) }}</div>
                <div class="comment-content">
                    <div>
                        <span class="comment-author-name">{{ $comment->user->name }}</span>
                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="comment-text">{{ $comment->content }}</div>
                </div>
            </div>
            @empty
            <div class="empty-state" id="emptyState">
                💬 No comments yet. Be the first to share your thoughts!
            </div>
            @endforelse
        </div>
        
        <!-- Login Prompt -->
        @guest
        <div class="login-prompt">
            🔐 Please <a href="{{ route('user.login') }}">sign in</a> to leave a comment.
        </div>
        @endguest

        <!-- AMP Comment Form - FIXED: Simple submit-success that redirects to reload page (AMP best practice) -->
        @auth
        <form method="POST" 
              action-xhr="{{ route('comments.store', $blog->slug) }}" 
              target="_top"
              on="submit-success: AMP.setState({ showSuccessMsg: true, commentContent: '' }); commentsList.innerHTML = event.response.html; commentCount.innerText = event.response.count;"
              on="submit-error: AMP.setState({ showErrorMsg: true })">
            @csrf
            <input type="hidden" name="amp_form" value="1">
            <div class="comment-form-wrapper">
                <input type="text" 
                       name="content" 
                       id="commentContent"
                       class="comment-input" 
                       placeholder="Add a comment..." 
                       required
                       style="width: 100%;">
                <button type="submit" class="btn-submit">Post</button>
            </div>
        </form>
        
        <!-- Success Message (shows briefly then fades) -->
        <div id="successMsg" 
             [class]="showSuccessMsg ? 'toast-message' : ''" 
             hidden 
             style="transition: all 0.3s ease;">
            ✅ Comment posted successfully!
        </div>
        
        <!-- Error Message -->
        <div id="errorMsg" 
             [class]="showErrorMsg ? 'toast-message toast-error' : ''" 
             hidden>
            ❌ Failed to post comment. Please try again.
        </div>
        
        <!-- Auto-hide messages after 3 seconds -->
        <amp-bind-macro id="hideMessages" arguments="" expression="AMP.setState({ showSuccessMsg: false, showErrorMsg: false })"></amp-bind-macro>
        <amp-state id="messageTimer">
            <script type="application/json">null</script>
        </amp-state>
        <script type="application/json" id="autoHideScript">
        {
            "vars": {
                "timeout": 3000
            }
        }
        </script>
        @endauth
    </div>

    <!-- Related Posts -->
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
    <div class="related-section">
        <div class="related-header">
            <h3>📚 Related Articles</h3>
            <a href="{{ $lang ? '/' . $lang . '/blogs' : '/blogs' }}" class="view-link">View All →</a>
        </div>
        <div class="related-grid">
            @foreach($relatedPosts as $relatedPost)
            <a href="{{ url($lang ? $lang . '/blog/' . $relatedPost->slug : 'blog/' . $relatedPost->slug) }}" class="related-item">
                <div class="related-item-image">
                    @if($relatedPost->image)
                    <amp-img src="{{ asset($relatedPost->image) }}" alt="{{ $relatedPost->title }}" width="80" height="80" layout="fill" object-fit="cover"></amp-img>
                    @endif
                </div>
                <div class="related-item-content">
                    <div class="related-item-title">{{ $relatedPost->title }}</div>
                    <div class="related-item-date">{{ $relatedPost->created_at->format('M d, Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-bottom">
            &copy; {{ date('Y') }} NextPrayerTimes. All Rights Reserved.
        </div>
    </footer>

    <!-- AMP State for messages -->
    <amp-state id="showSuccessMsg">
        <script type="application/json">false</script>
    </amp-state>
    <amp-state id="showErrorMsg">
        <script type="application/json">false</script>
    </amp-state>
</body>
</html>