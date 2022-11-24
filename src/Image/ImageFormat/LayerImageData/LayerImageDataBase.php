<?php

namespace Psd\Image\ImageFormat\LayerImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;

abstract class LayerImageDataBase
{
    protected FileInterface $file;

    protected ImageChannels $channelData;

    protected HeaderInterface $header;

    public function __construct(FileInterface $file, HeaderInterface $header, ImageChannels $channelDataa)
    {
        $this->file = $file;
        $this->header = $header;
        $this->channelData = $channelDataa;
    }

    abstract protected function parseData(int $chanPos, int $chanLength, int $height): int;

    public function parse(int $chanPos, int $chanLength, int $height): int
    {
        return $this->parseData($chanPos, $chanLength, $height);
    }
}
