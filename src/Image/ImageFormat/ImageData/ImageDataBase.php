<?php

namespace Psd\Image\ImageFormat\ImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;

abstract class ImageDataBase
{
    protected FileInterface $file;

    protected ImageChannels $channelData;

    protected HeaderInterface $header;

    public function __construct(FileInterface $file, HeaderInterface $header)
    {
        $this->file = $file;
        $this->header = $header;
        //$this->channelData = []; //array_fill(0, $this->header->getFileLength(), 0);

        $this->channelData = new ImageChannels($this->header->getChannelLength());
    }

    abstract protected function parseData(): void;

    public function parse(): ImageChannels
    {
        $this->parseData();

        return $this->channelData;
    }
}
