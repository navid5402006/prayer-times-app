<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        // EXISTING
        'city',
        'country',
        'state',
        'slug',
        'timezone',

        // NEW ADMIN / SEO (ALL OPTIONAL)
        'meta_title',
        'meta_description',
        'meta_keywords',
        'description',
        'image',
        'Cal_Method',
        'is_updated',
    ];
}
