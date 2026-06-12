@section('title', $blog->title)
@section('description', $blog->excerpt)
@section('keywords', $blog->title)
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@section('meta_image', asset($blog->image))
@include('header')

<!-- Add CSRF Token Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --primary-color: #0d6e6e;
        --secondary-color: #054545;
        --primary-light: rgba(13, 110, 110, 0.1);
        --accent-color: #d4af37;
        --text-dark: #333;
        --text-light: #666;
        --white: #ffffff;
        --border-color: #eee;
    }

    body {
        font-family: 'Inter', 'Open Sans', 'Roboto', 'Lato', sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
        line-height: 1.3;
        margin-top: 1.8em;
        margin-bottom: 0.5em;
        color: #0b1c2f;
    }
    h1 { font-size: 2.2rem; }
    h2 { font-size: 1.8rem; }
    h3 { font-size: 1.5rem; }
    h4 { font-size: 1.3rem; }
    h5 { font-size: 1.1rem; }
    h6 { font-size: 1rem; }
    
    blockquote {
        background: #f4f7fb;
        padding: 0.8rem 1.5rem;
        border-left: 4px solid #2c6b9c;
        margin: 1.2rem 0;
        font-style: normal;
    }
    
    hr {
        margin: 2rem 0;
        border: 0;
        border-top: 1px solid #d0dae8;
    }
    
    p {
        margin: 0 0 1rem 0;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
        padding: 100px 0 60px;
        color: var(--white) !important;
        position: relative;
        overflow: hidden;
    }
    .hero h1 {
        color: var(--white) !important;
    }
    .hero:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.3);
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .hero h1 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }

    /* Post Meta */
    .post-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    .post-category {
        background: rgba(255,255,255,0.2);
        color: var(--white);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-right: 15px;
    }
    .post-date {
        margin-right: 15px;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Featured Image */
    .post-featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
        margin: 40px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* Section Title */
    .section-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 40px;
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

    /* Post Content */
    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .post-content h2 {
        font-size: 1.8rem;
        border-left: 4px solid var(--primary-color);
        padding-left: 15px;
    }
    .post-content h3 {
        font-size: 1.5rem;
    }
    .post-content blockquote {
        border-left: 4px solid var(--primary-color);
        padding: 20px 30px;
        background: var(--accent-color);
        margin: 30px 0;
        font-style: italic;
        border-radius: 0 5px 5px 0;
    }
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 30px 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .post-content ul, .post-content ol {
        padding-left: 20px;
        margin-bottom: 20px;
    }
    .post-content li {
        margin-bottom: 10px;
    }

    /* Author Box */
    .author-box {
        background: var(--white);
        border-radius: 10px;
        padding: 30px;
        margin: 60px 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
    }
    .author-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-right: 20px;
        background-color: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: bold;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .author-info h4 {
        margin-bottom: 5px;
        font-weight: 700;
    }
    .author-title {
        color: var(--text-light);
        margin-bottom: 10px;
        font-size: 0.85rem;
    }
    .author-bio {
        color: var(--text-dark);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Related Posts */
    .related-post-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 30px;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .related-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .related-post-image {
        width: 100%;
        height: 180px;
        overflow: hidden;
        position: relative;
    }
    .related-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .related-post-category {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #2E8B57;
        color: #fff;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .related-post-content {
        padding: 15px;
        flex: 1;
    }
    .related-post-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 8px;
        color: #333;
        text-decoration: none;
        display: block;
    }
    .related-post-title:hover {
        color: #2E8B57;
    }
    .related-post-excerpt {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
        line-height: 1.5;
    }

    /* Sidebar Widgets */
    .sidebar-widget {
        background: var(--white);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .widget-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--accent-color);
        font-size: 1.1rem;
    }
    .category-list, .tag-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .category-list li, .tag-list li {
        margin-bottom: 8px;
    }
    .category-list a, .tag-list a {
        color: var(--text-dark);
        text-decoration: none;
        display: flex;
        justify-content: space-between;
        transition: color 0.3s;
        font-size: 0.9rem;
    }
    .category-list a:hover, .tag-list a:hover {
        color: var(--primary-color);
    }
    .tag-list a {
        background: var(--accent-color);
        padding: 4px 12px;
        border-radius: 20px;
        margin-right: 5px;
        margin-bottom: 8px;
        display: inline-block;
        font-size: 0.8rem;
    }
    .recent-post {
        display: flex;
        margin-bottom: 15px;
    }
    .recent-post-image {
        width: 60px;
        height: 60px;
        border-radius: 5px;
        background-size: cover;
        background-position: center;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .recent-post-content h4 {
        font-size: 0.9rem;
        margin-bottom: 5px;
        font-weight: 600;
    }
    .recent-post-content h4 a {
        color: #333;
        text-decoration: none;
    }
    .recent-post-content span {
        font-size: 0.7rem;
        color: var(--text-light);
    }

    /* Social Sharing */
    .nsp-social-share {
        margin: 30px 0;
        padding: 20px 0;
        border-top: 1px solid #eef2f6;
        border-bottom: 1px solid #eef2f6;
    }
    .nsp-share-label {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 12px;
    }
    .nsp-share-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .nsp-btn {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 25px;
        color: white;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .nsp-facebook { background: #1877f2; }
    .nsp-twitter { background: #1da1f2; }
    .nsp-whatsapp { background: #25d366; }
    .nsp-linkedin { background: #0a66c2; }
    .nsp-telegram { background: #26a5e4; }
    .nsp-reddit { background: #ff4500; }
    .nsp-pinterest { background: #bd081c; }
    .nsp-email { background: #6c757d; }
    .nsp-copy { background: #6c5ce7; }
    .nsp-btn:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        color: white;
        text-decoration: none;
    }

    /* Comments Section */
    .comments-section {
        margin-top: 50px;
    }
    .comments-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f6;
    }
    .comments-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #030303;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .comments-count {
        background: #eef2f6;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        color: #5f5f5f;
    }
    .comment-form-wrapper {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
    }
    .comment-avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .comment-input-wrapper {
        flex: 1;
    }
    .comment-input-field {
        width: 100%;
        border: none;
        border-bottom: 1px solid #eef2f6;
        padding: 10px 0;
        font-size: 0.9rem;
        resize: none;
        font-family: inherit;
        background: transparent;
    }
    .comment-input-field:focus {
        outline: none;
        border-bottom-color: #2E8B57;
    }
    .comment-actions-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 10px;
    }
    .btn-cancel-comment, .btn-submit-comment {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
    }
    .btn-cancel-comment {
        background: #f2f2f2;
        color: #5f5f5f;
    }
    .btn-submit-comment {
        background: #2E8B57;
        color: white;
    }
    .comment-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .comment-author-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: #030303;
    }
    .comment-date {
        font-size: 0.65rem;
        color: #7f7f7f;
        margin-left: 8px;
    }
    .comment-text-content {
        font-size: 0.9rem;
        line-height: 1.5;
        color: #0f0f0f;
        margin: 4px 0 8px 0;
    }
    .comment-action-link {
        background: none;
        border: none;
        font-size: 0.7rem;
        font-weight: 500;
        color: #5f5f5f;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 16px;
    }
    .comment-action-link:hover {
        background: #f2f2f2;
        color: #2E8B57;
    }
    .reply-form-wrapper {
        margin-top: 10px;
        margin-left: 48px;
        display: none;
    }
    .reply-form-wrapper.active {
        display: block;
    }
    .reply-input-field {
        width: 100%;
        border: none;
        border-bottom: 1px solid #eef2f6;
        padding: 8px 0;
        font-size: 0.85rem;
        background: transparent;
    }
    .reply-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
    }
    .replies-container {
        margin-left: 48px;
        margin-top: 12px;
    }
    .reply-item {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
    .reply-avatar-sm {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
    }
    .reply-author-name {
        font-weight: 600;
        font-size: 0.8rem;
        color: #030303;
    }
    .reply-date {
        font-size: 0.6rem;
        color: #7f7f7f;
    }
    .reply-text-content {
        font-size: 0.85rem;
        line-height: 1.4;
        color: #0f0f0f;
        margin: 4px 0 6px 0;
    }
    .alert-info-custom {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #7f7f7f;
    }
    .toast-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 18px;
        border-radius: 8px;
        color: white;
        font-size: 0.8rem;
        font-weight: 500;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toast-success { background: #2E8B57; }
    .toast-error { background: #dc2626; }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @media (max-width: 768px) {
        .post-featured-image { height: 250px; }
        .author-box { flex-direction: column; text-align: center; }
        .author-avatar-large { margin-right: 0; margin-bottom: 15px; }
        .reply-form-wrapper, .replies-container { margin-left: 40px; }
    }
</style>

<!-- Hero Section -->
<section class="hero" style="background-image: url('{{ $blog->image ? asset($blog->image) : 'https://images.unsplash.com/photo-1566378246598-5b11a0d486cc?q=80&w=1470&auto=format&fit=crop' }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="hero-content">
            <div class="post-meta">
                <span class="post-category">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                <span class="post-date"><i class="far fa-calendar me-1"></i> {{ $blog->created_at->format('M d, Y') }}</span>
            </div>
            <h1>{{ $blog->title }}</h1>
            <p class="lead">{{ $blog->excerpt }}</p>
            <div class="post-meta">
                <span>By {{ $blog->user->name ?? 'Admin User' }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($blog->image)
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="post-featured-image">
                @endif
                
                <article class="post-content">
                    {!! $blog->content !!}
                </article>
                
                <!-- Tags -->
                <div class="post-tags mt-4">
                    <h5>Tags:</h5>
                    <div class="tag-list">
                        @foreach($blog->tags as $tag)
                            <a href="{{ url('tag') }}/{{ $tag->slug }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Social Sharing -->
                <div class="nsp-social-share">
                    <span class="nsp-share-label"><i class="fas fa-share-alt me-2"></i> Share this article:</span>
                    <div class="nsp-share-buttons">
                        @php
                            $currentUrl = urlencode(url()->current());
                            $title = urlencode($blog->title);
                            $excerpt = urlencode(Str::limit($blog->excerpt, 150));
                        @endphp
                        
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" target="_blank" class="nsp-btn nsp-facebook" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f me-1"></i> Facebook
                        </a>
                        
                        <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $currentUrl }}" target="_blank" class="nsp-btn nsp-twitter" rel="noopener noreferrer">
                            <i class="fab fa-twitter me-1"></i> Twitter
                        </a>
                        
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $currentUrl }}&title={{ $title }}&summary={{ $excerpt }}" target="_blank" class="nsp-btn nsp-linkedin" rel="noopener noreferrer">
                            <i class="fab fa-linkedin-in me-1"></i> LinkedIn
                        </a>
                        
                        <a href="https://wa.me/?text={{ $title . ' ' . $currentUrl }}" target="_blank" class="nsp-btn nsp-whatsapp" rel="noopener noreferrer">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                        
                        <a href="https://t.me/share/url?url={{ $currentUrl }}&text={{ $title }}" target="_blank" class="nsp-btn nsp-telegram" rel="noopener noreferrer">
                            <i class="fab fa-telegram-plane me-1"></i> Telegram
                        </a>
                        
                        <a href="https://www.reddit.com/submit?url={{ $currentUrl }}&title={{ $title }}" target="_blank" class="nsp-btn nsp-reddit" rel="noopener noreferrer">
                            <i class="fab fa-reddit-alien me-1"></i> Reddit
                        </a>
                        
                        <a href="https://pinterest.com/pin/create/button/?url={{ $currentUrl }}&media={{ urlencode(asset($blog->image)) }}&description={{ $title }}" target="_blank" class="nsp-btn nsp-pinterest" rel="noopener noreferrer">
                            <i class="fab fa-pinterest-p me-1"></i> Pinterest
                        </a>
                        
                        <a href="mailto:?subject={{ $title }}&body={{ $currentUrl }}" class="nsp-btn nsp-email">
                            <i class="fas fa-envelope me-1"></i> Email
                        </a>
                        
                        <a href="javascript:void(0);" onclick="copyLink('{{ url()->current() }}')" class="nsp-btn nsp-copy">
                            <i class="fas fa-link me-1"></i> Copy Link
                        </a>
                    </div>
                </div>
                
                <!-- Author Box -->
                <div class="author-box">
                    @if($blog->user && $blog->user->avatar_url)
                        <img src="{{ $blog->user->avatar_url }}" class="author-avatar-large" alt="{{ $blog->user->name }}" style="object-fit: cover;">
                    @else
                        <div class="author-avatar-large">{{ substr($blog->user->name ?? 'AD', 0, 2) }}</div>
                    @endif
                    <div class="author-info">
                        <h4>{{ $blog->user->name ?? 'Admin' }}</h4>
                        <div class="author-title">{{ '@' . ($blog->user->username ?? 'admin') }}</div>
                        <p class="author-bio">{{ $blog->user->bio ?? 'Writer and Islamic scholar dedicated to sharing knowledge and insights about Islam.' }}</p>
                    </div>
                </div>
                
                <!-- Related Posts -->
                <div class="related-posts mt-4">
                    <h3 class="section-title">Related Articles</h3>
                    <div class="row">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="col-md-4">
                                <div class="related-post-card">
                                    <div class="related-post-image">
                                        <img src="{{ asset($relatedPost->image) }}" alt="{{ $relatedPost->title }}">
                                        <div class="related-post-category">{{ $relatedPost->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                    <div class="related-post-content">
                                        <a class="related-post-title" href="{{ url('blog') }}/{{ $relatedPost->slug }}">{{ Str::limit($relatedPost->title, 50) }}</a>
                                        <p class="related-post-excerpt">{{ Str::limit($relatedPost->excerpt, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <div class="comments-header">
                        <div class="comments-title">
                            <i class="fas fa-comment"></i> Comments
                            <span class="comments-count" id="commentCount">{{ $blog->comments()->count() }}</span>
                        </div>
                    </div>
                    
                    <!-- Comment Form -->
                    @auth
                        <div class="comment-form-wrapper">
                            <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" class="comment-avatar-sm" alt="{{ Auth::user()->name ?? 'User' }}">
                            <div class="comment-input-wrapper">
                                <form id="commentForm" method="POST" action="{{ route('comments.store', $blog->slug) }}">
                                    @csrf
                                    <textarea class="comment-input-field" id="commentContent" name="content" rows="1" placeholder="Add a comment..." required></textarea>
                                    <div class="comment-actions-buttons" id="commentActions" style="display: none;">
                                        <button type="button" class="btn-cancel-comment" onclick="cancelComment()">Cancel</button>
                                        <button type="submit" class="btn-submit-comment" id="submitCommentBtn">Comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="alert-info-custom">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Please <a href="{{ route('user.login') }}">sign in</a> to leave a comment.</span>
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div id="commentsList">
                        @forelse($blog->comments()->with('user')->latest()->get() as $comment)
                            <div class="comment-item" id="comment-{{ $comment->id }}">
                                <img src="{{ $comment->user->avatar_url ?? asset('images/default-avatar.png') }}" class="comment-avatar-sm" alt="{{ $comment->user->name ?? 'User' }}">
                                <div class="comment-content-wrapper">
                                    <div>
                                        <span class="comment-author-name">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="comment-text-content" id="comment-text-{{ $comment->id }}">
                                        {{ $comment->content }}
                                    </div>
                                    <div>
                                        @auth
                                            <button class="comment-action-link" onclick="showReplyForm({{ $comment->id }})">
                                                <i class="fas fa-reply"></i> Reply
                                            </button>
                                            @if(Auth::id() == $comment->user_id)
                                                <button class="comment-action-link" onclick="editComment({{ $comment->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="comment-action-link text-danger" onclick="deleteComment({{ $comment->id }})">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                    
                                    <!-- Reply Form -->
                                    <div class="reply-form-wrapper" id="replyForm-{{ $comment->id }}">
                                        <form onsubmit="submitReply(event, {{ $comment->id }})">
                                            @csrf
                                            <input type="text" class="reply-input-field" placeholder="Write a reply..." required>
                                            <div class="reply-actions">
                                                <button type="button" class="comment-action-link" onclick="hideReplyForm({{ $comment->id }})">Cancel</button>
                                                <button type="submit" class="comment-action-link" style="color: #2E8B57;">Reply</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- Replies -->
                                    <div class="replies-container" id="replies-{{ $comment->id }}">
                                        @foreach($comment->replies as $reply)
                                            <div class="reply-item" id="reply-{{ $reply->id }}">
                                                <img src="{{ $reply->user->avatar_url ?? asset('images/default-avatar.png') }}" class="reply-avatar-sm" alt="{{ $reply->user->name ?? 'User' }}">
                                                <div>
                                                    <div>
                                                        <span class="reply-author-name">{{ $reply->user->name ?? 'Anonymous' }}</span>
                                                        <span class="reply-date">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="reply-text-content" id="reply-text-{{ $reply->id }}">
                                                        {{ $reply->content }}
                                                    </div>
                                                    @if(Auth::id() == $reply->user_id)
                                                        <div>
                                                            <button class="comment-action-link" onclick="editReply({{ $reply->id }})">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button>
                                                            <button class="comment-action-link text-danger" onclick="deleteReply({{ $reply->id }})">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state" id="emptyState">
                                <i class="fas fa-comment-dots fa-2x mb-2"></i>
                                <p>No comments yet. Be the first to share your thoughts!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Author Card -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-user-circle me-2"></i> About Author</h3>
                    <div class="text-center">
                        @if($blog->user && $blog->user->avatar_url)
                            <img src="{{ $blog->user->avatar_url }}" class="rounded-circle mb-3" width="80" height="80" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ substr($blog->user->name ?? 'A', 0, 1) }}
                            </div>
                        @endif
                        <h5>{{ $blog->user->name ?? 'Admin' }}</h5>
                        <p class="text-muted small">@ {{ $blog->user->username ?? 'admin' }}</p>
                        <p class="small">{{ $blog->user->bio ?? 'Islamic scholar and writer dedicated to sharing knowledge.' }}</p>
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-folder-open me-2"></i> Categories</h3>
                    <ul class="category-list">
                        @foreach($categories as $category)
                            <li><a href="{{ url('category') }}/{{ $category->slug }}">{{ $category->name }} <span>({{ $category->blogs_count ?? $category->blogs()->count() }})</span></a></li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Recent Posts Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-clock me-2"></i> Recent Posts</h3>
                    @foreach($recentPosts as $recentPost)
                        <div class="recent-post">
                            <div class="recent-post-image" style="background-image: url('{{ asset($recentPost->image) }}');"></div>
                            <div class="recent-post-content">
                                <h4><a href="{{ route('blog_detail', $recentPost->slug) }}">{{ Str::limit($recentPost->title, 45) }}</a></h4>
                                <span><i class="far fa-calendar me-1"></i>{{ $recentPost->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Tags Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><i class="fas fa-tags me-2"></i> Popular Tags</h3>
                    <div class="tag-list">
                        @foreach($popularTags as $tag)
                            <a href="{{ url('/tag/') }}/{{ $tag->slug }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('footer')

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    const commentInput = document.getElementById('commentContent');
    const commentActions = document.getElementById('commentActions');
    
    if (commentInput) {
        commentInput.addEventListener('focus', () => commentActions.style.display = 'flex');
        commentInput.addEventListener('input', function() {
            document.getElementById('submitCommentBtn').classList.toggle('disabled', !this.value.trim());
        });
    }
    
    function cancelComment() {
        commentInput.value = '';
        commentActions.style.display = 'none';
    }
    
    function showToast(message, type = 'success') {
        document.querySelectorAll('.toast-notification').forEach(t => t.remove());
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    
    function copyLink(url) {
        navigator.clipboard.writeText(url);
        showToast('Link copied!', 'success');
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function updateCommentCount(change) {
        const countSpan = document.getElementById('commentCount');
        const current = parseInt(countSpan.innerText);
        countSpan.innerText = current + change;
        if (current + change === 0 && !document.getElementById('emptyState')) {
            document.getElementById('commentsList').innerHTML = `<div class="empty-state" id="emptyState"><i class="fas fa-comment-dots fa-2x mb-2"></i><p>No comments yet. Be the first to share your thoughts!</p></div>`;
        } else if (current + change > 0 && document.getElementById('emptyState')) {
            document.getElementById('emptyState').remove();
        }
    }
    
    // Submit Comment
    document.getElementById('commentForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const content = document.getElementById('commentContent').value.trim();
        const submitBtn = document.getElementById('submitCommentBtn');
        if (!content) { showToast('Please enter a comment.', 'error'); return; }
        
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ content })
            });
            const data = await response.json();
            if (data.success) {
                if (document.getElementById('emptyState')) document.getElementById('emptyState').remove();
                document.getElementById('commentsList').insertAdjacentHTML('afterbegin', createCommentHTML(data.comment));
                document.getElementById('commentContent').value = '';
                commentActions.style.display = 'none';
                updateCommentCount(1);
                showToast('Comment posted!', 'success');
            } else showToast(data.message || 'Error posting comment.', 'error');
        } catch (error) { showToast('Error posting comment.', 'error'); }
        finally { submitBtn.innerHTML = originalText; submitBtn.disabled = false; }
    });
    
    window.showReplyForm = function(commentId) {
        document.querySelectorAll('.reply-form-wrapper').forEach(f => f.classList.remove('active'));
        document.getElementById(`replyForm-${commentId}`)?.classList.add('active');
    };
    
    window.hideReplyForm = function(commentId) {
        const form = document.getElementById(`replyForm-${commentId}`);
        if (form) { form.classList.remove('active'); form.querySelector('input').value = ''; }
    };
    
    window.submitReply = async function(event, commentId) {
        event.preventDefault();
        const input = event.target.querySelector('input');
        const content = input.value.trim();
        if (!content) { showToast('Please enter a reply.', 'error'); return; }
        
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch(`/comments/${commentId}/reply`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ content })
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById(`replies-${commentId}`).insertAdjacentHTML('beforeend', createReplyHTML(data.reply));
                input.value = '';
                hideReplyForm(commentId);
                updateCommentCount(1);
                showToast('Reply posted!', 'success');
            } else showToast(data.message || 'Error posting reply.', 'error');
        } catch (error) { showToast('Error posting reply.', 'error'); }
        finally { submitBtn.innerHTML = originalText; submitBtn.disabled = false; }
    };
    
    window.editComment = function(commentId) {
        const textDiv = document.getElementById(`comment-text-${commentId}`);
        const current = textDiv.innerText;
        textDiv.innerHTML = `<div class="edit-form"><textarea id="edit-${commentId}" rows="2" class="w-100 border-bottom">${escapeHtml(current)}</textarea><div class="mt-2"><button class="comment-action-link" onclick="updateComment(${commentId})">Save</button><button class="comment-action-link" onclick="location.reload()">Cancel</button></div></div>`;
    };
    
    window.updateComment = async function(commentId) {
        const content = document.getElementById(`edit-${commentId}`).value.trim();
        if (!content) { showToast('Comment cannot be empty.', 'error'); return; }
        try {
            const response = await fetch(`/comments/${commentId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ content })
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById(`comment-text-${commentId}`).innerHTML = escapeHtml(data.content);
                showToast('Comment updated!', 'success');
            } else showToast(data.message || 'Error updating comment.', 'error');
        } catch (error) { showToast('Error updating comment.', 'error'); }
    };
    
    window.deleteComment = async function(commentId) {
        if (!confirm('Delete this comment?')) return;
        try {
            const response = await fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById(`comment-${commentId}`).remove();
                updateCommentCount(-1);
                showToast('Comment deleted!', 'success');
            } else showToast(data.message || 'Error deleting comment.', 'error');
        } catch (error) { showToast('Error deleting comment.', 'error'); }
    };
    
    window.editReply = function(replyId) {
        const textDiv = document.getElementById(`reply-text-${replyId}`);
        const current = textDiv.innerText;
        textDiv.innerHTML = `<div class="edit-form"><textarea id="edit-reply-${replyId}" rows="2" class="w-100 border-bottom">${escapeHtml(current)}</textarea><div class="mt-1"><button class="comment-action-link" onclick="updateReply(${replyId})">Save</button><button class="comment-action-link" onclick="location.reload()">Cancel</button></div></div>`;
    };
    
    window.updateReply = async function(replyId) {
        const content = document.getElementById(`edit-reply-${replyId}`).value.trim();
        if (!content) { showToast('Reply cannot be empty.', 'error'); return; }
        try {
            const response = await fetch(`/comments/${replyId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ content })
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById(`reply-text-${replyId}`).innerHTML = escapeHtml(data.content);
                showToast('Reply updated!', 'success');
            } else showToast(data.message || 'Error updating reply.', 'error');
        } catch (error) { showToast('Error updating reply.', 'error'); }
    };
    
    window.deleteReply = async function(replyId) {
        if (!confirm('Delete this reply?')) return;
        try {
            const response = await fetch(`/comments/${replyId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();
            if (data.success) {
                document.getElementById(`reply-${replyId}`).remove();
                updateCommentCount(-1);
                showToast('Reply deleted!', 'success');
            } else showToast(data.message || 'Error deleting reply.', 'error');
        } catch (error) { showToast('Error deleting reply.', 'error'); }
    };
    
    function createCommentHTML(comment) {
        const avatarUrl = comment.user.avatar_url || '{{ asset('images/default-avatar.png') }}';
        return `<div class="comment-item" id="comment-${comment.id}">
            <img src="${avatarUrl}" class="comment-avatar-sm">
            <div class="comment-content-wrapper">
                <div><span class="comment-author-name">${escapeHtml(comment.user.name)}</span><span class="comment-date">Just now</span></div>
                <div class="comment-text-content" id="comment-text-${comment.id}">${escapeHtml(comment.content)}</div>
                <div>
                    <button class="comment-action-link" onclick="showReplyForm(${comment.id})"><i class="fas fa-reply"></i> Reply</button>
                    <button class="comment-action-link" onclick="editComment(${comment.id})"><i class="fas fa-edit"></i> Edit</button>
                    <button class="comment-action-link text-danger" onclick="deleteComment(${comment.id})"><i class="fas fa-trash-alt"></i> Delete</button>
                </div>
                <div class="reply-form-wrapper" id="replyForm-${comment.id}">
                    <form onsubmit="submitReply(event, ${comment.id})"><input type="text" class="reply-input-field" placeholder="Write a reply..."><div class="reply-actions"><button type="button" class="comment-action-link" onclick="hideReplyForm(${comment.id})">Cancel</button><button type="submit" class="comment-action-link" style="color:#2E8B57;">Reply</button></div></form>
                </div>
                <div class="replies-container" id="replies-${comment.id}"></div>
            </div>
        </div>`;
    }
    
    function createReplyHTML(reply) {
        const avatarUrl = reply.user.avatar_url || '{{ asset('images/default-avatar.png') }}';
        return `<div class="reply-item" id="reply-${reply.id}">
            <img src="${avatarUrl}" class="reply-avatar-sm">
            <div>
                <div><span class="reply-author-name">${escapeHtml(reply.user.name)}</span><span class="reply-date">Just now</span></div>
                <div class="reply-text-content" id="reply-text-${reply.id}">${escapeHtml(reply.content)}</div>
                <div><button class="comment-action-link" onclick="editReply(${reply.id})"><i class="fas fa-edit"></i> Edit</button><button class="comment-action-link text-danger" onclick="deleteReply(${reply.id})"><i class="fas fa-trash-alt"></i> Delete</button></div>
            </div>
        </div>`;
    }
    
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>

<!-- Schema.org Markup -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ $blog->title }}",
    "description": "{{ $blog->excerpt }}",
    "image": "{{ $blog->image ? asset($blog->image) : asset('images/default-blog-image.jpg') }}",
    "datePublished": "{{ $blog->created_at->toIso8601String() }}",
    "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": "{{ $blog->user->name ?? 'Admin User' }}",
        "url": "{{ url('/author/' . ($blog->user->username ?? 'admin')) }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url()->current() }}"
    }
}
</script>
</body>
</html>