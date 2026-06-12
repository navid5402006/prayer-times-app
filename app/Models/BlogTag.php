<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    /**
     * Get the blogs that belong to the tag.
     */
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_tag', 'blog_tag_id', 'blog_id');
    }
}