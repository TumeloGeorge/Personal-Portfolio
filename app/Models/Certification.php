<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name', 'issuing_body', 'year',
        'certificate_file_path', 'badge_image_path',
        'credential_url', 'sort_order',
    ];
}