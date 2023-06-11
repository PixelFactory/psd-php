<?php

namespace Psd\Image\ImageMode\Modes;

use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;
use Psd\Image\ImageChannels\RgbaJson;

abstract class ImageModeBase
{
    protected HeaderInterface $header;

    protected RgbaJson $pixelData;

    protected ImageChannels $channelData;

    protected array $channelsInfo;

    protected int $numPixels;

    protected int $channelLength;

    protected int $channels;

    public function __construct(
        HeaderInterface $header,
        ImageChannels   $channelData,
        int             $channels,
        int             $numPixels,
        int             $channelLength
    )
    {
        $this->header = $header;
        $this->pixelData = new RgbaJson();
        $this->channelData = $channelData;
        $this->numPixels = $numPixels;
        $this->channelLength = $channelLength;
        $this->channels = $channels;

        $this->initChannelsInfo($channels);
    }

    abstract public function initChannelsInfo(int $channels): void;

    abstract public function combineChannel(): RgbaJson;
}
