<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class StorageUrl
{
    public static function for(string $path): string
    {
        $disk = Storage::disk();

        if (config('filesystems.default') === 's3') {
            return $disk->temporaryUrl($path, now()->addHour());
        }

        return $disk->url($path);
    }
}
