<?php

namespace Psd\Image\ImageFormat\ImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageFormat\BaseData\DecodeRLEChannel\DecodeRLEChannel;
use Psd\Image\ImageFormat\BaseData\DecodeRLEChannel\DecodeRLEChannelInterface;

class Rle extends ImageDataBase
{
    protected DecodeRLEChannelInterface $decodeRLEChannel;

    public function __construct(FileInterface $file, HeaderInterface $header)
    {
        parent::__construct($file, $header);

        $this->decodeRLEChannel = $this->buildDecodeRLEChannel($file);
    }

    protected function parseData(): void
    {
        $byteCounts = $this->parseByteCounts();
        $this->parseChannelData($byteCounts);
    }

    protected function parseByteCounts(): array
    {
        $byteCounts = [];

        for ($i = 0; $i < ($this->header->getChannels() * $this->header->getHeight()); $i += 1) {
            $byteCounts[] = $this->file->readShort();
        }

        return $byteCounts;
    }

    protected function parseChannelData(array $byteCounts): void
    {
        $lineIndex = 0;
        $chanPos = 0;

        for ($i = 0; $i < $this->header->getChannels(); $i++) {
            $chanPos = $this->decodeRLEChannel->decode(
                $this->channelData,
                $chanPos,
                $this->header->getHeight(),
                $lineIndex,
                $byteCounts
            );

            $lineIndex += $this->header->getHeight();
        }
    }

    protected function buildDecodeRLEChannel(FileInterface $file): DecodeRLEChannelInterface
    {
        return new DecodeRLEChannel($file);
    }
}
