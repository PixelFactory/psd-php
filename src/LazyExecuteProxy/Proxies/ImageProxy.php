<?php

namespace Psd\LazyExecuteProxy\Proxies;

use Psd\Image\ImageChannels\RgbaJson;
use Psd\LazyExecuteProxy\Interfaces\ImageInterface;
use Psd\LazyExecuteProxy\LazyExecuteProxy;

class ImageProxy extends LazyExecuteProxy implements ImageInterface
{
    public function getExporter(string $type)
    {
        $this->parse();
        return $this->obj->getExporter($type);
    }

    public function getPixelData(): RgbaJson
    {
        $this->parse();
        return $this->obj->getPixelData();
    }
}
