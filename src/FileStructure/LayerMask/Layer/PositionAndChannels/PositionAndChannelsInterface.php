<?php

namespace Psd\FileStructure\LayerMask\Layer\PositionAndChannels;

interface PositionAndChannelsInterface
{
    public function parse(): void;

    public function getTop(): int;

    public function getLeft(): int;

    public function getBottom(): int;

    public function getRight(): int;

    public function getChannels(): int;

    public function getChannelsInfo(): array;

    public function getRows(): int;

    public function getHeight(): int;

    public function getCols(): int;

    public function getWidth(): int;
}
