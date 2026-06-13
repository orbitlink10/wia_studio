<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'published_at',
        'image_url',
        'body',
        'source_label',
        'source_url',
        'published',
    ];

    protected $casts = [
        'published_at' => 'date',
        'published' => 'boolean',
    ];
}
