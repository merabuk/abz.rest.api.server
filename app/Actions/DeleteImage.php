<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class DeleteImage
{
    /**
     * @var Storage
     */
    private $storage;


    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param object $photo
     *
     * @return string
     */
    public function execute(string $photoPath): void
    {
        $this->storage->disk('public')->delete($photoPath);
    }
}
