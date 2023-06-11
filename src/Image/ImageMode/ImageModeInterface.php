<?php

namespace Psd\Image\ImageMode;

use Psd\Image\ImageMode\Modes\ImageModeBase;

interface ImageModeInterface
{
    public function build($channelData, int $channels, int $numPixels, int $channelLength): ImageModeBase;
}
