<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = BlogTag::withCount('blogs')
            ->latest()
            ->paginate(10);

        return view('admin.blog-tags-index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-tags-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags',
            'slug' => 'nullable|string|max:255|unique:blog_tags',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        BlogTag::create($validated);

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogTag $blogTag)
    {
        return view('admin.blog-tags-edit', compact('blogTag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogTag $blogTag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_tags,name,' . $blogTag->id,
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug,' . $blogTag->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $blogTag->update($validated);

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogTag $blogTag)
    {
        // Check if tag has associated blogs
        if ($blogTag->blogs()->count() > 0) {
            return redirect()->route('admin.blog-tags.index')
                ->with('error', 'Cannot delete tag with associated blogs.');
        }

        $blogTag->delete();

        return redirect()->route('admin.blog-tags.index')
            ->with('success', 'Tag deleted successfully.');
    }
}