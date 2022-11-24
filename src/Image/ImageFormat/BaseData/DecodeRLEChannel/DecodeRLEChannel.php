<?php

namespace Psd\Image\ImageFormat\BaseData\DecodeRLEChannel;

use Psd\File\FileInterface;
use Psd\Image\ImageChannels\ImageChannels;

class DecodeRLEChannel implements DecodeRLEChannelInterface {
  protected FileInterface $file;

  public function __construct(FileInterface $file) {
    $this->file = $file;
  }

  public function decode(ImageChannels $channelData, int $chanPos, int $height, int $lineIndex, array $byteCounts): int
  {
      $chanPosSum = $chanPos;

      for ($j = 0; $j < $height; $j++) {

          $byte_count = $byteCounts[$lineIndex + $j];
          $finish = $this->file->ftell() + $byte_count;

          while ($this->file->ftell() < $finish) {
              $len = $this->file->readByte();
              $array = [];

              if ($len < 128) {
                  $len += 1;

                  //Read many bytes
                  $array = $this->file->readBytes($len, function($val) {
                      return str_pad($val, 3, "0", STR_PAD_LEFT);
                  });
              } elseif ($len > 128) {
                  $len ^= 0xff;
                  $len += 2;

                  $val = $this->file->readByte();
                  $val = str_pad($val, 3, "0", STR_PAD_LEFT);
                  $array = array_fill(0 ,$len, $val);
              }

              $channelData->addChannelsData(implode($array));

              $chanPosSum += $len;
          }
      }
      return $chanPosSum;
  }
}