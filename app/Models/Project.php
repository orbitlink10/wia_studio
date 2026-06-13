<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'location',
        'year',
        'client',
        'typology',
        'size',
        'status',
        'hero_image',
        'summary',
        'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(ProjectChapter::class)->orderBy('position');
    }

    public function credits(): HasMany
    {
        return $this->hasMany(ProjectCredit::class);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }
}
