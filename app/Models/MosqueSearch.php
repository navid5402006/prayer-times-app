<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueSearch extends Model
{
    protected $fillable = [
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'timezone',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'main_description',
        'total_mosques',
        'last_fetched_at'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'total_mosques' => 'integer',
        'last_fetched_at' => 'datetime'
    ];

    // Get nearby cities in same country
    public function scopeInSameCountry($query, $country, $currentCity)
    {
        return $query->where('country', $country)
            ->where('city', '!=', $currentCity)
            ->orderBy('city');
    }
}