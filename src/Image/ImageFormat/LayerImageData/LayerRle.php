<?php

namespace Psd\Image\ImageFormat\LayerImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;
use Psd\Image\ImageFormat\BaseData\DecodeRLEChannel\DecodeRLEChannel;
use Psd\Image\ImageFormat\BaseData\DecodeRLEChannel\DecodeRLEChannelInterface;

class LayerRle extends LayerImageDataBase {
  protected DecodeRLEChannelInterface $decodeRLEChannel;

  public function __construct(FileInterface $file, HeaderInterface $header, ImageChannels $channelData)
  {
      parent::__construct($file, $header, $channelData);
      $this->decodeRLEChannel = $this->buildDecodeRLEChannel($file);
  }

  protected function parseData(int $chanPos, int $chanLength, int $height): int {
    $byteCounts = $this->parseByteCounts($height);
    return $this->parseChannelData($byteCounts, $chanPos, $height);
  }

  protected function parseByteCounts(int $height): array {
    $data = [];

    for ($i = 0; $i < $height; $i++) {
      $data[] = $this->file->readShort();
    }

    return $data;
  }

    protected function parseChannelData(array $byteCounts, int $chanPos, int $height): int {
        return $this->decodeRLEChannel->decode(
                $this->channelData,
                $chanPos,
                $height,
                0,
                $byteCounts
        );
  }

  protected function buildDecodeRLEChannel(FileInterface $file): DecodeRLEChannelInterface {
    return new DecodeRLEChannel($file);
  }
}
