<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class NxUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nx_users';
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
        'website',
        'phone',
        'gender',
        'birth_date',
        'role',
        'status',
        'verification_token',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Avatar accessor with default random avatar
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Generate random avatar from UI Avatars with name
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?background=2E8B57&color=fff&name={$name}&size=200";
    }

    // Username generator
    public static function generateUsername($name)
    {
        $baseUsername = Str::slug($name, '_');
        $username = $baseUsername;
        $counter = 1;
        
        while (self::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }
        
        return $username;
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is moderator
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    // Check if user is active
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Relationship with comments
       public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get all blog posts by this user
     */
    public function blogPosts()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

}