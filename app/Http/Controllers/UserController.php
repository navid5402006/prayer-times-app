<?php

namespace App\Http\Controllers;

use App\Models\NxUser;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\BlogCategory;
use App\Models\BlogTag;

class UserController extends Controller
{
    // ==================== AUTHENTICATION ====================
    
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }
    
    /**
     * Process login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = NxUser::where('email', $request->email)
            ->where('status', 'active')
            ->first();
            
        if (!$user) {
            return back()->withErrors(['email' => 'Invalid credentials or account inactive.']);
        }
        
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Update last login
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
            
            return redirect()->intended(route('user.dashboard'));
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    /**
     * Show registration page
     */
    public function showRegister()
    {
        return view('auth.register');
    }
    
    /**
     * Process registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:nx_users,email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted'
        ]);
        
        // Generate username
        $username = NxUser::generateUsername($validated['name']);
        
        // Generate verification token
        $verificationToken = Str::random(64);
        
        // Create user
        $user = NxUser::create([
            'name' => $validated['name'],
            'username' => $username,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'verification_token' => $verificationToken,
            'status' => 'inactive',
        ]);
        
        // Send verification email
        $this->sendVerificationEmail($user);
        
        return redirect()->route('user.login')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }
    
    /**
     * Send verification email
     */
    protected function sendVerificationEmail($user)
    {
        $verificationUrl = route('user.verify-email', [
            'token' => $user->verification_token,
            'email' => $user->email
        ]);
        
        try {
            Mail::send('emails.verify', ['user' => $user, 'url' => $verificationUrl], function($message) use ($user) {
                $message->to($user->email)
                        ->subject('Verify Your Email Address - NextPrayerTime')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            \Log::info('Verification email sent to: ' . $user->email);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }
    }
    
    /**
     * Verify email
     */
    public function verifyEmail(Request $request)
    {
        $user = NxUser::where('email', $request->email)
            ->where('verification_token', $request->token)
            ->first();
            
        if (!$user) {
            return redirect()->route('user.login')
                ->with('error', 'Invalid verification link.');
        }
        
        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
            'status' => 'active'
        ]);
        
        return redirect()->route('user.login')
            ->with('success', 'Email verified successfully! You can now login.');
    }
    
    /**
     * Process logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Logged out successfully.');
    }
    
    // ==================== PROFILE & DASHBOARD ====================
    
    /**
     * Show user dashboard
     */
    /**
 * Show user dashboard
 */
public function dashboard()
{
    $user = Auth::user();
    
    // Get user's blog posts
    $userPosts = Blog::where('user_id', $user->id)->latest()->get();
    
    // Get user's comments with null check for commentable
    $userComments = $user->comments()->with('commentable')->latest()->get();
    
    // Calculate statistics
    $totalComments = $user->comments()->count();
    $totalPosts = $user->blogPosts()->count();
    $publishedPosts = $user->blogPosts()->where('status', 'published')->count();
    $draftPosts = $user->blogPosts()->where('status', 'draft')->count();
    
    // Recent activities with null safety
    $recentActivities = [];
    
    foreach ($userComments->take(5) as $comment) {
        // Check if commentable exists and has title property
        $commentableTitle = optional($comment->commentable)->title ?? 'Deleted Content';
        
        $recentActivities[] = [
            'title' => 'Commented on: ' . Str::limit($commentableTitle, 50),
            'time' => $comment->created_at->diffForHumans(),
            'type' => 'comment'
        ];
    }
    
    foreach ($userPosts->take(5) as $post) {
        $postTitle = $post->title ?? 'Untitled Post';
        
        $recentActivities[] = [
            'title' => 'Created post: ' . Str::limit($postTitle, 50),
            'time' => $post->created_at->diffForHumans(),
            'type' => 'post'
        ];
    }
    
    $recentActivities = collect($recentActivities)->sortByDesc(function($activity) {
        return strtotime($activity['time']);
    })->take(5)->values()->all();
    
    // Get categories and tags for the modal
    $categories = BlogCategory::all();
    $tags = BlogTag::all();
    
    return view('profile.dashboard', compact(
        'user', 'userPosts', 'userComments', 'totalComments', 'totalPosts',
        'publishedPosts', 'draftPosts', 'recentActivities', 'categories', 'tags'
    ));
}

/**
 * Update profile (AJAX)
 */
public function updateProfile(Request $request)
{
    try {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:nx_users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Handle avatar upload to public_html/storage/avatars
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                $oldAvatarPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $user->avatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            
            // Upload path: public_html/storage/avatars
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/storage/avatars';
            
            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move file to public_html/storage/avatars
            $avatar->move($uploadPath, $avatarName);
            
            // Store relative path in database
            $validated['avatar'] = '/avatars/' . $avatarName;
        }
        
        $user->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'bio' => $user->bio,
                'location' => $user->location,
                'website' => $user->website,
                'phone' => $user->phone,
                'avatar_url' => asset($user->avatar)
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Profile update error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error updating profile: ' . $e->getMessage()
        ], 500);
    }
}
/**
 * Update password (AJAX)
 */
public function updatePassword(Request $request)
{
    $user = Auth::user();
    
    $validated = $request->validate([
        'current_password' => 'required|current_password',
        'new_password' => 'required|min:6|confirmed'
    ]);
    
    $user->update([
        'password' => Hash::make($validated['new_password'])
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Password changed successfully!'
    ]);
}

/**
 * Delete account (AJAX)
 */
public function deleteAccount(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'password' => 'required|current_password'
    ]);
    
    if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
        Storage::delete('public/' . $user->avatar);
    }
    
    Auth::logout();
    $user->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'Account deleted successfully.'
    ]);
}

    
    // ==================== COMMENTS ====================
    
    /**
     * Store a new comment on blog
     */
   public function storeComment(Request $request, $slug)
{
    $blog = Blog::where('slug', $slug)->firstOrFail();
    
    $validated = $request->validate([
        'content' => 'required|string|min:2|max:1000'
    ]);
    
    $comment = Comment::create([
        'content' => $validated['content'],
        'user_id' => Auth::id(),
        'commentable_id' => $blog->id,
        'commentable_type' => Blog::class,
        'parent_id' => null
    ]);
    
    $comment->load('user');
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'avatar_url' => $comment->user->avatar_url
                ],
                'created_at' => $comment->created_at->diffForHumans()
            ],
            'message' => 'Comment posted successfully!'
        ]);
    }
    
    return back()->with('success', 'Comment posted successfully!');
}

/**
 * Store a reply to a comment
 */
public function storeReply(Request $request, Comment $comment)
{
    $validated = $request->validate([
        'content' => 'required|string|min:2|max:500'
    ]);
    
    $reply = Comment::create([
        'content' => $validated['content'],
        'user_id' => Auth::id(),
        'commentable_id' => $comment->commentable_id,
        'commentable_type' => $comment->commentable_type,
        'parent_id' => $comment->id
    ]);
    
    $reply->load('user');
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'id' => $reply->user->id,
                    'name' => $reply->user->name,
                    'avatar_url' => $reply->user->avatar_url
                ],
                'created_at' => $reply->created_at->diffForHumans()
            ],
            'message' => 'Reply posted!'
        ]);
    }
    
    return back()->with('success', 'Reply posted!');
}

/**
 * Update a comment
 */
public function updateComment(Request $request, Comment $comment)
{
    // Check if user owns the comment
    if ($comment->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    $validated = $request->validate([
        'content' => 'required|string|min:2|max:1000'
    ]);
    
    $comment->update($validated);
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'content' => $comment->content,
            'message' => 'Comment updated!'
        ]);
    }
    
    return back()->with('success', 'Comment updated!');
}

/**
 * Delete a comment
 */
public function deleteComment(Comment $comment)
{
    // Check if user owns the comment
    if ($comment->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    $comment->delete();
    
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Comment deleted!'
        ]);
    }
    
    return back()->with('success', 'Comment deleted!');
}

    public function myComments()
    {
        $comments = Auth::user()
            ->comments()
            ->with('commentable')
            ->latest()
            ->paginate(20);
            
        return view('comments.my', compact('comments'));
    }


        // ==================== USER BLOG POSTS ====================
    
    /**
     * Show create blog form
     */
    public function showCreateBlog()
    {
        $categories = BlogCategory::where('status', 'active')->get();
        $tags = BlogTag::where('status', 'active')->get();
        
        return view('profile.create-blog', compact('categories', 'tags'));
    }
    
    /**
     * Store blog post (AJAX)
     */
  /**
 * Store blog post (AJAX)
 */
public function storeBlog(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        // Handle image upload to public_html/blog-images
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Upload path: public_html/blog-images
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/blog-images';
            
            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move file to public_html/blog-images
            $image->move($uploadPath, $imageName);
            
            // Store relative path in database
            $validated['image'] = 'blog-images/' . $imageName;
        }

        $validated['user_id'] = Auth::id();
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['featured'] = false;
        $validated['views'] = 0;

        $blog = Blog::create($validated);

        // Sync tags
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        // For AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Blog post created successfully!',
                'blog' => $blog,
                'redirect' => route('user.dashboard')
            ]);
        }
        
        // For regular form submission
        return redirect()->route('user.dashboard')
            ->with('success', 'Blog post created successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Blog creation error: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating blog post: ' . $e->getMessage()
            ], 500);
        }
        
        return back()->with('error', 'Error creating blog post: ' . $e->getMessage());
    }
}

/**
 * Edit blog post
 */
public function editBlog($id)
{
    $blog = Blog::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();
    
    $categories = BlogCategory::where('status', 'active')->get();
    $tags = BlogTag::where('status', 'active')->get();
    
    return view('profile.edit-blog', compact('blog', 'categories', 'tags'));
}

/**
 * Update blog post (AJAX)
 */
public function updateBlog(Request $request, $id)
{
    try {
        $blog = Blog::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published'
        ]);

        // Handle image upload to public_html/blog-images
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image) {
                $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $blog->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Upload path: public_html/blog-images
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/blog-images';
            
            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move file to public_html/blog-images
            $image->move($uploadPath, $imageName);
            
            // Store relative path in database
            $validated['image'] = 'blog-images/' . $imageName;
        }

        // Generate new slug only if title changed
        if ($blog->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $blog->id);
        }

        $blog->update($validated);

        // Sync tags
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        } else {
            $blog->tags()->detach();
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog post updated successfully!',
            'blog' => $blog,
            'redirect' => route('user.dashboard')
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Blog update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error updating blog post: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Delete blog post (AJAX)
 */
public function deleteBlog($id)
{
    try {
        $blog = Blog::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Delete image from public_html/blog-images
        if ($blog->image) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $blog->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $blog->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Blog post deleted successfully!'
            ]);
        }
        
        return back()->with('success', 'Blog post deleted successfully!');
        
    } catch (\Exception $e) {
        \Log::error('Blog delete error: ' . $e->getMessage());
        
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting blog post: ' . $e->getMessage()
            ], 500);
        }
        
        return back()->with('error', 'Error deleting blog post');
    }
}

/**
 * Upload image for Summernote editor
 */
public function uploadBlogImage(Request $request)
{
    try {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);
        
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Upload path: public_html/blog-images
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/blog-images';
        
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        $image->move($uploadPath, $imageName);
        $imageUrl = asset('blog-images/' . $imageName);
        
        return response()->json([
            'success' => true,
            'url' => $imageUrl
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Image upload error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error uploading image: ' . $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug . '-' . Str::random(6);
        
        $query = Blog::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $counter = 1;
        while ($query->exists()) {
            $slug = $baseSlug . '-' . Str::random(6) . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }


}