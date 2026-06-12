<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\NxUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with(['category', 'user', 'tags'])
                    ->latest()
                    ->paginate(10);
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        
        return view('admin.blog_index', compact('blogs', 'categories', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog_create', compact('categories', 'tags'));
    }

    /**
     * Ensure admin user exists in nx_users table
     */
    private function ensureAdminUserExists()
    {
        // Check if user with ID 2 exists in nx_users
        $adminUser = NxUser::find(2);
        
        if (!$adminUser) {
            // Create admin user if not exists
            $adminUser = NxUser::create([
                'id' => 2,
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@nextprayertime.com',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            \Log::info('Admin user created with ID: 2');
        }
        
        return $adminUser;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'featured' => 'boolean'
        ]);

        // ✅ IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/blog-images';
            
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $image->move($uploadPath, $imageName);
            $validated['image'] = 'blog-images/' . $imageName;
        }

        // ✅ ENSURE ADMIN USER EXISTS IN NX_USERS
        $this->ensureAdminUserExists();
        
        // ✅ SET USER_ID = 2 FOR ALL ADMIN POSTS
        $validated['user_id'] = 2;  // Fixed admin user ID
        $validated['featured'] = $request->has('featured');
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['views'] = 0;

        // Debug log
        \Log::info('Creating blog post with user_id: 2', [
            'title' => $validated['title'],
            'user_id_exists' => NxUser::where('id', 2)->exists()
        ]);

        $blog = Blog::create($validated);

        // Sync tags
        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog created successfully with Admin User (ID: 2).');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->increment('views');
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog_edit', compact('blog', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'featured' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image) {
                $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $blog->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/blog-images';
            
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $image->move($uploadPath, $imageName);
            $validated['image'] = 'blog-images/' . $imageName;
        }

        $validated['featured'] = $request->has('featured');

        if ($blog->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $blog->id);
        }

        $blog->update($validated);

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        } else {
            $blog->tags()->detach();
        }

        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $blog->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Create a new tag directly from blog controller
     */
    public function createTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags',
        ]);

        $tag = BlogTag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'tag' => $tag
        ]);
    }

    /**
     * Get tags for select2
     */
    public function getTags(Request $request)
    {
        $tags = BlogTag::where('name', 'like', '%' . $request->q . '%')
                      ->where('status', 'active')
                      ->get();

        return response()->json($tags);
    }

    /**
     * Publish the specified blog.
     */
    public function publish(Blog $blog)
    {
        $blog->update(['status' => 'published']);
        return redirect()->back()->with('success', 'Blog published successfully.');
    }

    /**
     * Unpublish the specified blog.
     */
    public function unpublish(Blog $blog)
    {
        $blog->update(['status' => 'draft']);
        return redirect()->back()->with('success', 'Blog unpublished successfully.');
    }

    /**
     * Toggle featured status of the specified blog.
     */
    public function feature(Blog $blog)
    {
        $blog->update(['featured' => !$blog->featured]);
        $status = $blog->featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Blog {$status} successfully.");
    }

    /**
     * Generate unique slug with random string
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