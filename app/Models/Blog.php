<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'category_id',
        'user_id',
        'image',
        'status',
        'featured',
        'views',
        
    ];

    /**
     * Get the category that owns the blog post.
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get the user that owns the blog post.
     */
   public function user()
    {
        return $this->belongsTo(NxUser::class, 'user_id');
    }

    /**
     * The tags that belong to the blog post.
     */
    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_blog_tag', 'blog_id', 'blog_tag_id');
    }

        public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

}