<?php

namespace Psd\Image\ImageChannels;

use Exception;

final class ImageChannels
{
    protected const CHANNEL_DATA_LENGTH = 3;

    protected int $channelLength;
    protected string $channelsData = '';

    /**
     * @param int $channelLength
     */
    public function __construct(int $channelLength)
    {
        $this->channelLength = $channelLength;
    }

    /**
     * @return int
     */
    public function getChannelLength(): int
    {
        return $this->channelLength;
    }

    /**
     * @return string
     */
    public function getChannelsData(): string
    {
        return $this->channelsData;
    }

    /**
     * @param int $position
     * @return string
     */
    public function getChanelData(int $position): string
    {
        return substr($this->channelsData, $position * self::CHANNEL_DATA_LENGTH, self::CHANNEL_DATA_LENGTH);
    }

    /**
     * @param string $channelsData
     * @return $this
     * @throws Exception
     */
    public function setChannelsData(string $channelsData): self
    {
        $this->channelsData = $this->validateChannelsData($channelsData);

        return $this;
    }

    /**
     * @param string $channelsData
     * @return $this
     * @throws Exception
     */
    public function addChannelsData(string $channelsData): self
    {
        $this->channelsData .= $this->validateChannelsData($channelsData);

        return $this;
    }

    /**
     * @param string $channelsData
     * @return string
     * @throws Exception
     */
    protected function validateChannelsData(string $channelsData): string
    {
        if (strlen($channelsData) % self::CHANNEL_DATA_LENGTH === 0) {
            return $channelsData;
        }

        throw new Exception('Wrong channels format.');
    }
}
