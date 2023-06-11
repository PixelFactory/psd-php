<?php

namespace Psd\FileStructure\LayerMask\Layer;

use Psd\FileStructure\LayerMask\Layer\Info\InfoInterface;
use Psd\LazyExecuteProxy\Interfaces\ChannelImageInterface;

interface LayerInterface
{
    public function parse(): void;

    public function export(): array;

    public function getPosition(): array;

    public function getName(): string;

    public function getInfo(): InfoInterface;

    public function isFolder(): bool;

    public function isFolderEnd(): bool;

    public function getChannelImage(): ChannelImageInterface;

    public function parseChannelImage(): void;
}
