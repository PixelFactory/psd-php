<?php

namespace Psd\Image\ImageFormat\ImageData;

class Raw extends ImageDataBase
{
    /**
     * @throws \Exception
     */
    protected function parseData(): void
    {
        $bytes = $this->file->readBytes($this->header->getFileLength(), function ($val) {
            return str_pad($val, 3, "0", STR_PAD_LEFT);
        });

        $this->channelData->setChannelsData(implode($bytes));
    }
}
