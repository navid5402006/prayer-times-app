<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
{
    // Get all tags with blog count
    $tags = BlogTag::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])
    ->orderBy('name', 'asc')
    ->get();

    // Get total articles count
    $totalArticles = Blog::where('status', 'published')->count();

    // Get recent posts for sidebar
    $recentPosts = Blog::with('category')
                      ->where('status', 'published')
                      ->orderBy('created_at', 'desc')
                      ->limit(5)
                      ->get();

    // Get categories for sidebar
    $categories = BlogCategory::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])->get();

    return view('tags_index', compact(
        'tags', 
        'totalArticles',
        'recentPosts', 
        'categories'
    ));
}

    public function show($slug)
    {
        // Get specific tag
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        // Get blogs for this tag
        $blogs = Blog::with(['category', 'user', 'tags'])
                    ->whereHas('tags', function($query) use ($tag) {
                        $query->where('blog_tags.id', $tag->id);
                    })
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        // Get recent posts for sidebar
        $recentPosts = Blog::with('category')
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        // Get categories for sidebar
        $categories = BlogCategory::withCount(['blogs' => function($query) {
            $query->where('status', 'published');
        }])->get();

        return view('tag_show', compact(
            'tag',
            'blogs',
            'recentPosts', 
            'categories'
        ));
    }

    public function tagBlogs($slug)
    {
        // Alternative method for tag-wise blog listing
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $blogs = Blog::with(['category', 'user', 'tags'])
                    ->whereHas('tags', function($query) use ($tag) {
                        $query->where('blog_tags.id', $tag->id);
                    })
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        return view('tag_blogs', compact('tag', 'blogs'));
    }
}