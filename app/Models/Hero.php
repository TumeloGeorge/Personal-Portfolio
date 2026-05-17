<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'hero';
    protected $fillable = [
        'headline', 'subheadline', 'bio',
        'projects_count', 'years_experience', 'clients_count',
        'cta_primary_label', 'cta_secondary_label',
    ];

    public static function instance(): self
    {
        return self::firstOrCreate([], [
            'headline'            => 'Your Name',
            'subheadline'         => 'UI/UX & Graphic Designer',
            'bio'                 => 'Crafting digital experiences that feel human.',
            'projects_count'      => 0,
            'years_experience'    => 0,
            'clients_count'       => 0,
            'cta_primary_label'   => 'View Projects',
            'cta_secondary_label' => 'Download CV',
        ]);
    }
}