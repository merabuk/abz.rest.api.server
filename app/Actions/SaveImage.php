<?php

namespace App\Actions;

use App\Services\Tinify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveImage
{
    /**
     * @param string $photo
     *
     * @return string
     */
    public function execute(string $photo): string
    {
        $fileName = Str::random(60);
        $path = 'photo/'.$fileName.'.jpg';

        Storage::disk('public')->put($path, $photo);

        return $path;
    }
}
