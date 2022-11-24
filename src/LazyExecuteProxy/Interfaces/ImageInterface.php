<?php

namespace Psd\LazyExecuteProxy\Interfaces;

use Psd\Image\ImageChannels\RgbaJson;

interface ImageInterface extends LazyExecuteInterface {
    public function getExporter(string $type);
    public function getPixelData(): RgbaJson;
}
