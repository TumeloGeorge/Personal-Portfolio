<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'job_title', 'company', 'start_year', 'end_year',
        'description', 'sort_order',
    ];

    /**
     * Returns "2022 – Present" or "2020 – 2022"
     */
    public function getYearRangeAttribute(): string
    {
        return $this->start_year . ' – ' . ($this->end_year ?? 'Present');
    }
}