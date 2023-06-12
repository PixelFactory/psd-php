<?php

namespace Psd\LazyExecuteProxy\Interfaces;

use Psd\Image\ImageChannels\RgbaJson;
use Psd\Image\ImageExport\Exports\ImageExportInterface;

interface ImageInterface extends LazyExecuteInterface
{
    public function getExporter(string $type): ImageExportInterface;

    public function getPixelData(): RgbaJson;
}
