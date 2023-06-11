<?php

namespace Psd\Image\ImageMode\Modes;

use Psd\Helper;
use Psd\Image\ImageChannels\RgbaJson;

class Greyscale extends ImageModeBase
{

    public function initChannelsInfo(int $channels): void
    {
        $channelsInfo = [['id' => 0]];

        if ($channels === 2) {
            $channelsInfo[] = ['id' => -1];
        }

        $this->channelsInfo = $channelsInfo;
    }

    public function combineChannel(): RgbaJson
    {
        for ($i = 0; $i < $this->numPixels; $i += 1) {
            $grey = (int)$this->channelData->getChanelData($i);

            $a = ($this->channels === 2)
                ? $this->channelData->getChanelData($i + 1)
                : 255;

            [, $r, $g, $b] = array_map(function (string $color): string {
                return str_pad($color, 3, "0", STR_PAD_LEFT);
            }, Helper::colorToArgb($grey * 0x00010101));

            $this->pixelData->addRgba($r, $g, $b, $a);
        }

        return $this->pixelData;
    }
}
