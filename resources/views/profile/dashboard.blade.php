@section('title', 'My Dashboard')
@section('description', 'Manage your profile, blog posts, comments and activity')
@section('keywords', 'dashboard, profile, blog, comments, user account')
@section('robot', 'index, follow')
@section('googlebot', 'index, follow')
@section('meta_image', asset('images/default-profile.jpg'))
@include('header')

<!-- Unique Dashboard Styles with Prefix to Avoid Conflicts -->
<style>
    /* Dashboard Container - Unique Prefix "dash" */
    .dash-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: calc(100vh - 400px);
        padding: 40px 0;
    }

    /* Profile Sidebar */
    .dash-profile-card {
        background: white;
        border-radius: 24px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        transition: all 0.3s ease;
        border: 1px solid #eef2f6;
    }

    .dash-profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .dash-profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #2E8B57;
        box-shadow: 0 5px 15px rgba(46, 139, 86, 0.2);
        margin-bottom: 15px;
    }

    .dash-profile-name {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .dash-profile-username {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 12px;
    }

    .dash-profile-bio {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .dash-stats-row {
        display: flex;
        justify-content: space-around;
        border-top: 1px solid #eef2f6;
        padding-top: 20px;
        margin-top: 10px;
    }

    .dash-stat-box {
        text-align: center;
    }

    .dash-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2E8B57;
    }

    .dash-stat-label {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Navigation Menu */
    .dash-nav-menu {
        background: white;
        border-radius: 20px;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .dash-nav-item {
        padding: 12px 20px;
        margin: 5px 0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        color: #4a5568;
    }

    .dash-nav-item:hover {
        background: #f0fdf4;
        color: #2E8B57;
        transform: translateX(5px);
    }

    .dash-nav-item.active {
        background: linear-gradient(135deg, #2E8B57, #1B5E20);
        color: white;
    }

    .dash-nav-item i {
        width: 24px;
        margin-right: 10px;
    }

    /* Dashboard Cards */
    .dash-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: 1px solid #eef2f6;
    }

    .dash-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .dash-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #eef2f6;
    }

    .dash-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .dash-card-title i {
        color: #2E8B57;
        margin-right: 8px;
    }

    /* Stats Grid */
    .dash-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .dash-stat-card {
        background: linear-gradient(135deg, #2E8B57 0%, #1B5E20 100%);
        border-radius: 20px;
        padding: 20px;
        color: white;
        text-align: center;
        transition: all 0.3s;
    }

    .dash-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(46, 139, 86, 0.3);
    }

    .dash-stat-card-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .dash-stat-card-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    /* Blog Post Items */
    .dash-post-item {
        padding: 18px;
        border-radius: 16px;
        margin-bottom: 15px;
        background: #f8fafc;
        transition: all 0.3s;
        border: 1px solid #eef2f6;
    }

    .dash-post-item:hover {
        background: white;
        transform: translateX(5px);
        border-color: #2E8B57;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .dash-post-title {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .dash-post-title a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.2s;
    }

    .dash-post-title a:hover {
        color: #2E8B57;
    }

    .dash-post-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .dash-status-published {
        background: #d4edda;
        color: #155724;
    }

    .dash-status-draft {
        background: #fff3cd;
        color: #856404;
    }

    .dash-post-meta {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 10px;
    }

    .dash-post-meta i {
        margin-right: 4px;
    }

    /* Activity Items */
    .dash-activity-item {
        padding: 15px 0;
        border-bottom: 1px solid #eef2f6;
        transition: all 0.2s;
    }

    .dash-activity-item:hover {
        background: #f8fafc;
        padding-left: 10px;
    }

    .dash-activity-item:last-child {
        border-bottom: none;
    }

    .dash-activity-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .dash-activity-meta {
        font-size: 0.7rem;
        color: #6c757d;
    }

    /* Buttons */
    .dash-btn {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border: none;
    }

    .dash-btn-primary {
        background: linear-gradient(135deg, #2E8B57, #1B5E20);
        color: white;
    }

    .dash-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46, 139, 86, 0.3);
    }

    .dash-btn-outline {
        border: 2px solid #2E8B57;
        color: #2E8B57;
        background: transparent;
    }

    .dash-btn-outline:hover {
        background: #2E8B57;
        color: white;
        transform: translateY(-2px);
    }

    .dash-btn-danger {
        background: #dc2626;
        color: white;
    }

    .dash-btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }

    .dash-btn-sm {
        padding: 5px 12px;
        font-size: 0.8rem;
        border-radius: 8px;
    }

    /* Form Controls */
    .dash-form-control {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #eef2f6;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .dash-form-control:focus {
        border-color: #2E8B57;
        box-shadow: 0 0 0 3px rgba(46, 139, 86, 0.1);
        outline: none;
    }

    .dash-form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        color: #2c3e50;
    }

    /* Toast */
    .dash-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        padding: 14px 24px;
        border-radius: 12px;
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
        z-index: 9999;
        animation: dashSlideInRight 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dash-toast-success { background: linear-gradient(135deg, #2E8B57, #1B5E20); }
    .dash-toast-error { background: linear-gradient(135deg, #dc2626, #b91c1c); }

    @keyframes dashSlideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Modal */
    .dash-modal-content {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .dash-modal-header {
        background: linear-gradient(135deg, #2E8B57, #1B5E20);
        color: white;
        padding: 20px 25px;
        border: none;
    }

    /* Tabs */
    .dash-tab-pane {
        display: none;
    }

    .dash-tab-pane.active {
        display: block;
        animation: dashFadeIn 0.4s ease;
    }

    @keyframes dashFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .dash-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dash-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .dash-card {
            padding: 20px;
        }
        
        .dash-profile-card {
            margin-bottom: 20px;
        }
    }
</style>

<div class="dash-wrapper">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <div class="dash-profile-card">
                    <img src="{{ $user->avatar_url }}" class="dash-profile-avatar" alt="Profile Avatar">
                    <h3 class="dash-profile-name">{{ $user->name }}</h3>
                    <p class="dash-profile-username">@ {{ $user->username }}</p>
                    <p class="dash-profile-bio">{{ $user->bio ?? 'Islamic knowledge seeker passionate about learning and sharing.' }}</p>
                    <div class="dash-stats-row">
                        <div class="dash-stat-box">
                            <div class="dash-stat-number">{{ $totalComments ?? 0 }}</div>
                            <div class="dash-stat-label">Comments</div>
                        </div>
                        <div class="dash-stat-box">
                            <div class="dash-stat-number">{{ $totalPosts ?? 0 }}</div>
                            <div class="dash-stat-label">Posts</div>
                        </div>
                        <div class="dash-stat-box">
                            <div class="dash-stat-number">{{ $user->reputation ?? 0 }}</div>
                            <div class="dash-stat-label">Reputation</div>
                        </div>
                    </div>
                </div>
                
                <div class="dash-nav-menu">
                    <div class="dash-nav-item active" data-dash-tab="overview">
                        <i class="fas fa-chart-line"></i> Overview
                    </div>
                    <div class="dash-nav-item" data-dash-tab="posts">
                        <i class="fas fa-newspaper"></i> My Posts
                    </div>
                    <div class="dash-nav-item" data-dash-tab="comments">
                        <i class="fas fa-comment-dots"></i> My Comments
                    </div>
                    <div class="dash-nav-item" data-dash-tab="profile">
                        <i class="fas fa-user-circle"></i> Edit Profile
                    </div>
                    <div class="dash-nav-item" data-dash-tab="settings">
                        <i class="fas fa-shield-alt"></i> Settings
                    </div>
                    <div class="dash-nav-item" onclick="dashLogoutUser()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </div>
                    <form id="dashLogoutForm" action="{{ route('user.logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
            
            <!-- Main Content Column -->
            <div class="col-lg-8">
                <!-- Overview Tab -->
                <div id="dash-overview-tab" class="dash-tab-pane active">
                    <div class="dash-stats-grid">
                        <div class="dash-stat-card">
                            <div class="dash-stat-card-number">{{ $totalComments ?? 0 }}</div>
                            <div class="dash-stat-card-label">Total Comments</div>
                        </div>
                        <div class="dash-stat-card">
                            <div class="dash-stat-card-number">{{ $totalPosts ?? 0 }}</div>
                            <div class="dash-stat-card-label">Blog Posts</div>
                        </div>
                        <div class="dash-stat-card">
                            <div class="dash-stat-card-number">{{ $publishedPosts ?? 0 }}</div>
                            <div class="dash-stat-card-label">Published</div>
                        </div>
                        <div class="dash-stat-card">
                            <div class="dash-stat-card-number">{{ $draftPosts ?? 0 }}</div>
                            <div class="dash-stat-card-label">Drafts</div>
                        </div>
                    </div>
                    
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-history"></i> Recent Activity</h5>
                        </div>
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="dash-activity-item">
                                <div class="dash-activity-title">{{ $activity['title'] }}</div>
                                <div class="dash-activity-meta"><i class="far fa-clock me-1"></i> {{ $activity['time'] }}</div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No recent activity yet</p>
                                <a href="{{ route('blogs') }}" class="dash-btn dash-btn-outline dash-btn-sm">Start Engaging</a>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-bolt"></i> Quick Actions</h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('user.blog.create') }}" class="dash-btn dash-btn-outline w-100 py-3 text-center">
                                    <i class="fas fa-pen-alt me-2"></i> Write New Post
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="dash-btn dash-btn-outline w-100 py-3 text-center" onclick="document.querySelector('[data-dash-tab=\'profile\']').click()">
                                    <i class="fas fa-user-edit me-2"></i> Edit Profile
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- My Posts Tab -->
                <div id="dash-posts-tab" class="dash-tab-pane">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-newspaper"></i> My Blog Posts</h5>
                            <a href="{{ route('user.blog.create') }}" class="dash-btn dash-btn-outline dash-btn-sm">
                                <i class="fas fa-plus"></i> New Post
                            </a>
                        </div>
                        
                        @forelse($userPosts ?? [] as $post)
                            <div class="dash-post-item" id="dash-post-{{ $post->id }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="dash-post-title mb-1">
                                            <a href="{{ route('blog_detail', $post->slug) }}" target="_blank">{{ $post->title }}</a>
                                        </h6>
                                        <p class="text-muted small mb-2">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}</p>
                                        <div class="dash-post-meta">
                                            <span><i class="far fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
                                            <span class="ms-3"><i class="fas fa-eye"></i> {{ $post->views ?? 0 }}</span>
                                            <span class="ms-3"><i class="fas fa-comment"></i> {{ $post->comments_count ?? $post->comments()->count() }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="dash-post-status dash-status-{{ $post->status }}">{{ ucfirst($post->status) }}</span>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex gap-2">
                                    <a href="{{ route('user.blog.edit', $post->id) }}" class="dash-btn dash-btn-outline dash-btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button class="dash-btn dash-btn-outline dash-btn-sm" style="border-color: #dc2626; color: #dc2626;" onclick="dashDeletePost({{ $post->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No blog posts yet</p>
                                <a href="{{ route('user.blog.create') }}" class="dash-btn dash-btn-outline dash-btn-sm">Create Your First Post</a>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- My Comments Tab -->
                <div id="dash-comments-tab" class="dash-tab-pane">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-comment-dots"></i> My Comments</h5>
                        </div>
                        
                        @forelse($userComments ?? [] as $comment)
                            <div class="dash-activity-item" id="dash-comment-{{ $comment->id }}">
                                <div class="dash-activity-title">{{ Str::limit($comment->content, 100) }}</div>
                                <div class="dash-activity-meta">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $comment->created_at->format('M d, Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-book me-1"></i> On: 
                                    <a href="{{ route('blog_detail', $comment->commentable->slug) }}" target="_blank">{{ $comment->commentable->title }}</a>
                                </div>
                                <div class="mt-2 d-flex gap-2">
                                    <button class="dash-btn dash-btn-outline dash-btn-sm" onclick="dashEditComment({{ $comment->id }}, '{{ addslashes($comment->content) }}')">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="dash-btn dash-btn-outline dash-btn-sm" style="border-color: #dc2626; color: #dc2626;" onclick="dashDeleteComment({{ $comment->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No comments yet</p>
                                <a href="{{ route('blogs') }}" class="dash-btn dash-btn-outline dash-btn-sm">Start Commenting</a>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Edit Profile Tab -->
                <div id="dash-profile-tab" class="dash-tab-pane">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-user-edit"></i> Edit Profile</h5>
                        </div>
                        <form id="dashProfileForm" enctype="multipart/form-data" action="{{ route('user.profile.update') }}" method="POST">
                            @csrf 
                            <input type="hidden" name="_method" value="PUT">
                            <div class="text-center mb-4">
                                <img src="{{ $user->avatar_url }}" class="dash-profile-avatar" id="dashAvatarPreview" alt="Profile Avatar">
                                <div class="mt-2">
                                    <label class="dash-btn dash-btn-outline dash-btn-sm" style="cursor: pointer;">
                                        <i class="fas fa-camera me-1"></i> Change Avatar
                                        <input type="file" name="avatar" id="dashAvatarInput" class="d-none" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="dash-form-label">Full Name</label>
                                    <input type="text" class="dash-form-control" name="name" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="dash-form-label">Username</label>
                                    <input type="text" class="dash-form-control" name="username" value="{{ $user->username }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="dash-form-label">Bio</label>
                                <textarea class="dash-form-control" name="bio" rows="4">{{ $user->bio }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="dash-form-label">Location</label>
                                    <input type="text" class="dash-form-control" name="location" value="{{ $user->location }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="dash-form-label">Website</label>
                                    <input type="url" class="dash-form-control" name="website" value="{{ $user->website }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="dash-form-label">Phone</label>
                                <input type="text" class="dash-form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                            <button type="submit" class="dash-btn dash-btn-primary w-100">Update Profile</button>
                        </form>
                    </div>
                </div>
                
                <!-- Settings Tab -->
                <div id="dash-settings-tab" class="dash-tab-pane">
                    <div class="dash-card">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title"><i class="fas fa-lock"></i> Change Password</h5>
                        </div>
                        <form id="dashPasswordForm" action="{{ route('user.profile.password') }}" method="POST">
                            @csrf 
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label class="dash-form-label">Current Password</label>
                                <input type="password" class="dash-form-control" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="dash-form-label">New Password</label>
                                <input type="password" class="dash-form-control" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="dash-form-label">Confirm New Password</label>
                                <input type="password" class="dash-form-control" name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="dash-btn dash-btn-primary w-100">Change Password</button>
                        </form>
                    </div>
                    
                    <div class="dash-card" style="border: 1px solid #fed7d7;">
                        <div class="dash-card-header">
                            <h5 class="dash-card-title text-danger"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h5>
                        </div>
                        <p class="text-muted small">Once you delete your account, there is no going back. All your data will be permanently removed.</p>
                        <button class="dash-btn dash-btn-danger" data-bs-toggle="modal" data-bs-target="#dashDeleteAccountModal">
                            <i class="fas fa-trash-alt me-1"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Comment Modal -->
<div class="modal fade" id="dashEditCommentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content dash-modal-content">
            <div class="modal-header dash-modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="dashEditCommentForm">
                @csrf 
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="comment_id" id="dashEditCommentId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="dash-form-label">Comment</label>
                        <textarea class="dash-form-control" name="content" id="dashEditCommentContent" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="dash-btn dash-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="dash-btn dash-btn-primary">Update Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="dashDeleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content dash-modal-content">
            <div class="modal-header dash-modal-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account?</p>
                <p class="text-muted small">This action cannot be undone. All your posts, comments, and activity will be permanently removed.</p>
                <form id="dashDeleteAccountForm">
                    @csrf 
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="mb-3">
                        <label class="dash-form-label">Enter your password to confirm</label>
                        <input type="password" class="dash-form-control" name="password" id="dashDeletePassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="dash-btn dash-btn-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="dash-btn dash-btn-danger" onclick="dashConfirmDeleteAccount()">Delete Account</button>
            </div>
        </div>
    </div>
</div>

@include('footer')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    function dashShowToast(message, type) {
        const existingToasts = document.querySelectorAll('.dash-toast');
        existingToasts.forEach(toast => toast.remove());
        const toast = document.createElement('div');
        toast.className = `dash-toast dash-toast-${type}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    
    // Tab switching
    const navItems = document.querySelectorAll('.dash-nav-item');
    const tabPanes = document.querySelectorAll('.dash-tab-pane');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const tabId = this.getAttribute('data-dash-tab');
            
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            if (tabId) {
                const activePane = document.getElementById(`dash-${tabId}-tab`);
                if (activePane) activePane.classList.add('active');
            }
        });
    });
    
    // Avatar preview
    const avatarInput = document.getElementById('dashAvatarInput');
    const avatarPreview = document.getElementById('dashAvatarPreview');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (avatarPreview) avatarPreview.src = e.target.result;
            }
            if (e.target.files[0]) reader.readAsDataURL(e.target.files[0]);
        });
    }
    
    // Logout function
    window.dashLogoutUser = function() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('dashLogoutForm')?.submit();
        }
    };
    
    // Delete Post - FIXED: Using the correct route name
    window.dashDeletePost = async function(postId) {
        if (!confirm('Delete this post? This action cannot be undone.')) return;
        
        const deleteUrl = `/user/blog/${postId}`; // This matches your route
        
        try {
            const response = await fetch(deleteUrl, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            // Check if response is redirect (302)
            if (response.redirected) {
                console.error('Redirected to:', response.url);
                dashShowToast('Session expired. Please refresh the page.', 'error');
                return;
            }
            
            const data = await response.json();
            
            if (data.success) {
                const postElement = document.getElementById(`dash-post-${postId}`);
                if (postElement) {
                    postElement.remove();
                }
                dashShowToast('Post deleted successfully!', 'success');
                // Reload after 1.5 seconds to update stats
                setTimeout(() => location.reload(), 1500);
            } else {
                dashShowToast(data.message || 'Error deleting post.', 'error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            dashShowToast('Network error. Please try again.', 'error');
        }
    };
    
    // Edit Comment
    window.dashEditComment = function(commentId, content) {
        document.getElementById('dashEditCommentId').value = commentId;
        document.getElementById('dashEditCommentContent').value = content;
        new bootstrap.Modal(document.getElementById('dashEditCommentModal')).show();
    };
    
    // Submit Edit Comment
    const editCommentForm = document.getElementById('dashEditCommentForm');
    if (editCommentForm) {
        editCommentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const commentId = document.getElementById('dashEditCommentId')?.value;
            const content = document.getElementById('dashEditCommentContent')?.value.trim();
            
            if (!content) {
                dashShowToast('Comment cannot be empty.', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/comments/${commentId}`, {
                    method: 'PUT',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify({ content })
                });
                
                if (response.redirected) {
                    dashShowToast('Session expired. Please refresh the page.', 'error');
                    return;
                }
                
                const data = await response.json();
                
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('dashEditCommentModal')).hide();
                    dashShowToast('Comment updated!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    dashShowToast(data.message || 'Error updating comment.', 'error');
                }
            } catch (error) {
                console.error('Update error:', error);
                dashShowToast('Error updating comment.', 'error');
            }
        });
    }
    
    // Delete Comment
    window.dashDeleteComment = async function(commentId) {
        if (!confirm('Delete this comment?')) return;
        
        try {
            const response = await fetch(`/comments/${commentId}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json' 
                }
            });
            
            if (response.redirected) {
                dashShowToast('Session expired. Please refresh the page.', 'error');
                return;
            }
            
            const data = await response.json();
            
            if (data.success) {
                const commentElement = document.getElementById(`dash-comment-${commentId}`);
                if (commentElement) {
                    commentElement.remove();
                }
                dashShowToast('Comment deleted!', 'success');
                // Update comment count in stats
                setTimeout(() => location.reload(), 1000);
            } else {
                dashShowToast(data.message || 'Error deleting comment.', 'error');
            }
        } catch (error) {
            console.error('Delete error:', error);
            dashShowToast('Error deleting comment.', 'error');
        }
    };
    
    // Profile Update
    const profileForm = document.getElementById('dashProfileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Updating...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json' 
                    },
                    body: formData
                });
                
                if (response.redirected) {
                    dashShowToast('Session expired. Please refresh the page.', 'error');
                    return;
                }
                
                const data = await response.json();
                
                if (data.success) {
                    dashShowToast('Profile updated!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    dashShowToast(data.message || 'Error updating profile.', 'error');
                }
            } catch (error) {
                console.error('Update error:', error);
                dashShowToast('Error updating profile.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Password Update
    const passwordForm = document.getElementById('dashPasswordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Changing...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': csrfToken, 
                        'Accept': 'application/json' 
                    },
                    body: formData
                });
                
                if (response.redirected) {
                    dashShowToast('Session expired. Please refresh the page.', 'error');
                    return;
                }
                
                const data = await response.json();
                
                if (data.success) {
                    dashShowToast('Password changed!', 'success');
                    this.reset();
                } else {
                    dashShowToast(data.message || 'Error changing password.', 'error');
                }
            } catch (error) {
                console.error('Password error:', error);
                dashShowToast('Error changing password.', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Delete Account
    window.dashConfirmDeleteAccount = async function() {
        const password = document.getElementById('dashDeletePassword')?.value;
        
        if (!password) {
            dashShowToast('Please enter your password.', 'error');
            return;
        }
        
        if (!confirm('Are you absolutely sure? This will delete all your data permanently.')) return;
        
        try {
            const response = await fetch('{{ route("user.profile.destroy") }}', {
                method: 'DELETE',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({ password })
            });
            
            if (response.redirected) {
                dashShowToast('Session expired. Please refresh the page.', 'error');
                return;
            }
            
            const data = await response.json();
            
            if (data.success) {
                dashShowToast('Account deleted. Redirecting...', 'success');
                setTimeout(() => window.location.href = '/', 2000);
            } else {
                dashShowToast(data.message || 'Error deleting account.', 'error');
            }
        } catch (error) {
            console.error('Delete account error:', error);
            dashShowToast('Error deleting account.', 'error');
        }
    };
    
    // Set current year
    const yearElement = document.getElementById('currentYear');
    if (yearElement) yearElement.textContent = new Date().getFullYear();
});
</script>