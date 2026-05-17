<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'full_name', 'role_title', 'short_bio',
        'accent_color', 'email', 'phone', 'location',
        'linkedin_url', 'behance_url', 'dribbble_url', 'github_url',
        'available_for_work', 'avatar_path', 'cv_path',
    ];

    protected $casts = [
        'available_for_work' => 'boolean',
    ];

    /**
     * Always retrieve the single settings row, creating it if absent.
     */
    public static function instance(): self
    {
        return self::firstOrCreate([], [
            'site_name'    => 'My Portfolio',
            'full_name'    => 'Your Name',
            'role_title'   => 'UI/UX Designer',
            'short_bio'    => 'Welcome to my portfolio.',
            'accent_color' => '#38bdf8',
        ]);
    }
}