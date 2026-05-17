<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'category',
        'thumbnail_path', 'project_url', 'case_study_url',
        'featured', 'sort_order',
    ];

    protected $casts = ['featured' => 'boolean'];

    /** @param Builder<Project> $query */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    /** @param Builder<Project> $query */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}