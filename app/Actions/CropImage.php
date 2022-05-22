<?php

namespace App\Actions;

use App\Tinify\Facades\Tinify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CropImage
{
    private $service;

    public function __construct(Tinify $service)
    {
        $this->service = $service;
    }


    public function execute($photo)
    {
        $sourceData = file_get_contents($photo);
        $resultData = $this->service::fromBuffer($sourceData);

        $resized = $resultData->resize(array(
            "method" => "fit", //thumb
            "width" => 70,
            "height" => 70
        ));

        $resized = $resized->toBuffer();

        $fileName = Str::random(60);
        $path = 'photo/'.$fileName.'.jpg';

        Storage::disk('public')->put($path, $resized);

        return $path;
    }
}
