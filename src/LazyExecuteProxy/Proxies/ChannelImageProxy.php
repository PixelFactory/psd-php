<?php

namespace Psd\LazyExecuteProxy\Proxies;

use Psd\Image\ImageChannels\RgbaJson;
use Psd\Image\ImageExport\Exports\ImageExportInterface;
use Psd\LazyExecuteProxy\Interfaces\ChannelImageInterface;
use Psd\LazyExecuteProxy\LazyExecuteProxy;

class ChannelImageProxy extends LazyExecuteProxy implements ChannelImageInterface
{
    public function getExporter(string $type): ImageExportInterface
    {
        $this->parse();
        return $this->obj->getExporter($type);
    }

    public function getLayerData(): array
    {
        $this->parse();
        return $this->obj->getLayerData();
    }

    public function getPixelData(): RgbaJson
    {
        $this->parse();
        return $this->obj->getPixelData();
    }
}
