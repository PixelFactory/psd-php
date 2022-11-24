<?php

namespace Psd\FileStructure\LayerMask\Layer\PositionAndChannels;

use Exception;
use Psd\File\FileInterface;

class PositionAndChannels implements PositionAndChannelsInterface
{
    protected FileInterface $file;

    protected int $top;

    protected int $left;

    protected int $bottom;

    protected int $right;

    protected int $channels;

    protected array $channelsInfo = [];

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    public function parse(): void
    {
        $this->top = $this->file->readInt();
        $this->left = $this->file->readInt();
        $this->bottom = $this->file->readInt();
        $this->right = $this->file->readInt();
        $this->channels = $this->file->readShort();

        // Every color channel has both an ID and a length. The ID correlates to
        // the color channel, e.g. 0 = R, 1 = G, 2 = B, -1 = A, and the length is
        // the size of the data.
        for ($i = 0; $i < $this->channels; $i++) {
            $this->channelsInfo[] = [
                'id' => $this->file->readShort(),
                'dataLength' => $this->file->readInt(),
            ];
        }
    }

    public function getTop(): int
    {
        if (!isset($this->top)) {
            throw new Exception('PositionAndChannels not parsed. Top is undefined.');
        }

        return $this->top;
    }

    public function getLeft(): int
    {
        if (!isset($this->left)) {
            throw new Exception('PositionAndChannels not parsed. Left is undefined.');
        }

        return $this->left;
    }

    public function getBottom(): int
    {
        if (!isset($this->bottom)) {
            throw new Exception('PositionAndChannels not parsed. Bottom is undefined.');
        }

        return $this->bottom;
    }

    public function getRight(): int
    {
        if (!isset($this->right)) {
            throw new Exception('PositionAndChannels not parsed. Right is undefined.');
        }

        return $this->right;
    }

    public function getChannels(): int
    {
        if (!isset($this->channels)) {
            throw new Exception('PositionAndChannels not parsed. Channels is undefined.');
        }

        return $this->channels;
    }

    public function getChannelsInfo(): array
    {
        if (count($this->channelsInfo) === 0) {
            throw new Exception('PositionAndChannels not parsed. ChannelsInfo is empty.');
        }

        return $this->channelsInfo;
    }

    public function getRows(): int
    {
        return $this->getBottom() - $this->getTop();
    }

    public function getHeight(): int
    {
        return $this->getRows();
    }

    public function getCols(): int
    {
        return $this->getRight() - $this->getLeft();
    }

    public function getWidth(): int
    {
        return $this->getCols();
    }
}
