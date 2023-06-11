<?php

namespace Psd\Image\ImageMode\Modes;

use Psd\Helper;
use Psd\Image\ImageChannels\RgbaJson;
use Exception;

class Cmyk extends ImageModeBase
{

    public function initChannelsInfo(int $channels): void
    {
        $channelsInfo = [
            ['id' => 0],
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        if ($channels === 5) {
            $channelsInfo[] = ['id' => -1];
        }

        $this->channelsInfo = $channelsInfo;
    }

    public function combineChannel(): RgbaJson
    {
        $cmykChannels = array_filter(
            array_map(static function ($ch) {
                return $ch['id'];
            }, $this->channelsInfo), static function ($ch) {
            return $ch >= -1;
        });

        for ($i = 0; $i < $this->numPixels; $i++) {
            $c = 0;
            $m = 0;
            $y = 0;
            $k = 0;
            $a = 255;

            for ($index = 0; $index < count($cmykChannels); $index++) {
                $chan = $cmykChannels[$index];
                $val = $this->channelData[$i + ($this->channelLength * $index)];

                switch ($chan) {
                    case -1:
                        $a = $val;
                        break;
                    case 0:
                        $c = $val;
                        break;
                    case 1:
                        $m = $val;
                        break;
                    case 2:
                        $y = $val;
                        break;
                    case 3:
                        $k = $val;
                        break;
                    default:
                        throw new Exception('Error cmyk channels');
                }
            }

            $rgb = Helper::cmykToRgb(255 - $c, 255 - $m, 255 - $y, 255 - $k);
            $this->pixelData->addRgba(
                str_pad($rgb['r'], 3, "0", STR_PAD_LEFT),
                str_pad($rgb['g'], 3, "0", STR_PAD_LEFT),
                str_pad($rgb['b'], 3, "0", STR_PAD_LEFT),
                str_pad($a, 3, "0", STR_PAD_LEFT)
            );
        }

        return $this->pixelData;
    }
}
