<?php

namespace Psd\LazyExecuteProxy\Interfaces;

use Psd\Image\ImageChannels\RgbaJson;
use Psd\Image\ImageExport\Exports\ImageExportInterface;

interface ChannelImageInterface extends LazyExecuteInterface
{
    public function getExporter(string $type): ImageExportInterface;

    public function getLayerData(): array;

    public function getPixelData(): RgbaJson;
}
