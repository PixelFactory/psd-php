<?php

namespace Psd\Image\ImageFormat\LayerImageData;

class LayerRaw extends LayerImageDataBase
{
    /**
     * @throws \Exception
     */
    protected function parseData(int $chanPos, int $chanLength, int $height): int
    {
//    for ($i = $chanPos; $i < ($chanPos + $chanLength - 2); $i++) {
//      $this->channelData[$i] = $this->file->readByte();
//    }
        $bytes = $this->file->readBytes($chanLength - 2, function ($val) {
            return str_pad($val, 3, "0", STR_PAD_LEFT);
        });

        $this->channelData->addChannelsData(implode($bytes));

        return ($chanPos + $chanLength - 2);
    }
}
