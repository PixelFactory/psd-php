<?php

namespace Psd\Image\ImageMode\Modes;

use Exception;
use Psd\Image\ImageChannels\RgbaJson;

class Rgb extends ImageModeBase
{
    public function initChannelsInfo(int $channels): void
    {
        $channelsInfo = [
            ['id' => 0],
            ['id' => 1],
            ['id' => 2],
        ];

        if ($channels === 4) {
            $channelsInfo[] = ['id' => -1];
        }

        $this->channelsInfo = $channelsInfo;
    }

    public function combineChannel(): RgbaJson
    {
        $rgbChannels = array_filter(
            array_map(static function ($ch) {
                return $ch['id'];
            }, $this->channelsInfo), static function ($ch) {
            return $ch >= -1;
        });

        for ($i = 0; $i < $this->numPixels; $i += 1) {
            $r = $g = $b = 0;
            $a = 255;

            foreach ($rgbChannels as $index => $chan) {
                $pos = $i + ($this->channelData->getChannelLength() * $index);

                $val = $this->channelData->getChanelData($pos);

                switch ($chan) {
                    case -1:
                        $a = $val;
                        break;
                    case 0:
                        $r = $val;
                        break;
                    case 1:
                        $g = $val;
                        break;
                    case 2:
                        $b = $val;
                        break;
                }
            }

            $this->pixelData->addRgba($r, $g, $b, $a);
        }

        return $this->pixelData;
    }
}
