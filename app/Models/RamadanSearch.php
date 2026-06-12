<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RamadanSearch extends Model
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
        'main_description'
    ];
}
