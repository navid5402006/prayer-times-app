<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class UserSideBlogsController extends Controller
{

       public function index()
{
    // Get published blogs with pagination - ENSURE UNIQUE POSTS
    $blogs = Blog::with(['category', 'user', 'tags'])
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc') // Add this to ensure consistent ordering
                ->distinct() // Add distinct to prevent duplicates
                ->paginate(6); // 6 blogs per page

    // Get categories with post count
    $categories = BlogCategory::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])->get();

    // Get recent posts
    $recentPosts = Blog::with('category')
                      ->where('status', 'published')
                      ->orderBy('created_at', 'desc')
                      ->limit(5)
                      ->get();

    // Get popular tags
    $popularTags = BlogTag::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])
    ->orderBy('blogs_count', 'desc')
    ->limit(10)
    ->get();

    return view('blogs_index', compact(
        'blogs', 
        'categories', 
        'recentPosts', 
        'popularTags'
    ));
}


   public function blog_detail($slug)
{
    // Get the blog post by slug
    $blog = Blog::with(['category', 'user', 'tags'])
                ->where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

    // Get related posts (same category)
    $relatedPosts = Blog::with('category')
                        ->where('category_id', $blog->category_id)
                        ->where('id', '!=', $blog->id)
                        ->where('status', 'published')
                        ->limit(3)
                        ->get();

    // Get recent posts
    $recentPosts = Blog::with('category')
                      ->where('status', 'published')
                      ->orderBy('created_at', 'desc')
                      ->limit(5)
                      ->get();

    // Get categories with post count
    $categories = BlogCategory::withCount('blogs')->get();

    // Get popular tags
    $popularTags = BlogTag::withCount('blogs')
                         ->orderBy('blogs_count', 'desc')
                         ->limit(10)
                         ->get();

    // Increment view count
    $blog->increment('views');

    // Manual mobile detection
    $userAgent = request()->header('User-Agent');
    $isMobile = preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone|opera mini|iemobile)/i', $userAgent);
    
    if ($isMobile) {
        // Return AMP version for mobile
        return view('amp.blog_detail', compact(
            'blog', 
            'relatedPosts', 
            'recentPosts', 
            'categories', 
            'popularTags'
        ));
    }

    // Return regular version for desktop
    return view('blog_detail', compact(
        'blog', 
        'relatedPosts', 
        'recentPosts', 
        'categories', 
        'popularTags'
    ));
}

    // Remove the storeComment method entirely since we don't have comments system
    // public function storeComment(Request $request, $id) {...}
}