<?php

namespace Psd\Image\ImageFormat\BaseData\DecodeRLEChannel;

use Psd\Image\ImageChannels\ImageChannels;

interface DecodeRLEChannelInterface
{
    public function decode(ImageChannels $channelData, int $chanPos, int $height, int $lineIndex, array $byteCounts): int;
}
