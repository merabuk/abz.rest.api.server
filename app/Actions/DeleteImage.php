<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class DeleteImage
{
    /**
     * @param object $photo
     *
     * @return string
     */
    public function execute(string $photoPath): void
    {
        Storage::disk('public')->delete($photoPath);
    }
}
