<?php

namespace App\Actions;

use App\Services\Tinify;

class CropImage
{
    /**
     * @var Tinify
     */
    private $service;

    public function __construct(Tinify $service)
    {
        $this->service = $service;
    }

    /**
     * @param object $photo
     *
     * @return string
     */
    public function execute(object $photo): string
    {
        $sourceData = file_get_contents($photo);
        $resultData = $this->service->fromBuffer($sourceData);

        $resized = $resultData->resize(array(
            "method" => "cover", //thumb, fit
            "width" => 70,
            "height" => 70
        ));

        $resized = $resized->toBuffer();

        return $resized;
    }
}
