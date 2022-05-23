<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveImage
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Str
     */
    private $str;

    public function __construct(Storage $storage, Str $str)
    {
        $this->storage = $storage;
        $this->str = $str;
    }

    /**
     * @param object $photo
     *
     * @return string
     */
    public function execute(object $photo): string
    {
        $fileName = $this->str->random(60);
        $path = 'photo/'.$fileName.'.jpg';

        $this->storage->disk('public')->put($path, $photo);

        return $path;
    }
}
