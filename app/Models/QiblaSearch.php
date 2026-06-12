<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QiblaSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'qibla_direction',
        'slug',
        'main_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}