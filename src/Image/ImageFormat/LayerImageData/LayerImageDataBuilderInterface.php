<?php

namespace Psd\Image\ImageFormat\LayerImageData;


use Psd\Image\ImageChannels\ImageChannels;

interface LayerImageDataBuilderInterface
{
    public function build(int $type, ImageChannels $channelData): LayerImageDataBase;
}
