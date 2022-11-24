<?php

namespace Psd\FileStructure\LayerMask\Layer\Mask;

interface MaskInterface
{
    public function parse(): void;
    public function getSize(): int;
    public function getDefaultColor(): float;
    public function getFlags(): float;
    public function getTop(): int;
    public function getLeft(): int;
    public function getBottom(): int;
    public function getRight(): int;
    public function getWidth(): int;
    public function getHeight(): int;
    public function getRelative(): bool;
    public function getDisabled(): bool;
    public function getInvert(): bool;
    public function getFromOtherData(): bool;
    public function export(): array;
}
