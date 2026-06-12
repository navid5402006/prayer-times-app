<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all categories with blog count
        $categories = BlogCategory::withCount(['blogs' => function($query) {
            $query->where('status', 'published');
        }])->get();

        // Get recent posts for sidebar
        $recentPosts = Blog::with('category')
                          ->where('status', 'published')
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        // Get popular tags for sidebar
        $popularTags = BlogTag::withCount(['blogs' => function($query) {
            $query->where('status', 'published');
        }])
        ->orderBy('blogs_count', 'desc')
        ->limit(10)
        ->get();

        return view('categories_index', compact(
            'categories', 
            'recentPosts', 
            'popularTags'
        ));
    }

public function show($slug)
{
    // Get specific category
    $category = BlogCategory::where('slug', $slug)->firstOrFail();

    // Get blogs for this category
    $blogs = Blog::with(['category', 'user', 'tags'])
                ->where('category_id', $category->id)
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

    // Get recent posts for sidebar
    $recentPosts = Blog::with('category')
                      ->where('status', 'published')
                      ->orderBy('created_at', 'desc')
                      ->limit(5)
                      ->get();

    // Get popular tags for sidebar
    $popularTags = BlogTag::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])
    ->orderBy('blogs_count', 'desc')
    ->limit(10)
    ->get();

    // Get all categories for sidebar
    $categories = BlogCategory::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])->get();

    return view('category_show', compact(
        'category',
        'blogs',
        'recentPosts', 
        'popularTags',
        'categories'
    ));
}

    public function categoryBlogs($slug)
    {
        // Alternative method for category-wise blog listing
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $blogs = Blog::with(['category', 'user', 'tags'])
                    ->where('category_id', $category->id)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        return view('category_blogs', compact('category', 'blogs'));
    }
}