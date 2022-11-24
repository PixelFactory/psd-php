<?php

namespace Psd\FileStructure\LayerMask\Layer\Mask;

use Exception;
use Psd\File\FileInterface;

class Mask implements MaskInterface
{
    private FileInterface $file;

    private int $top = 0;

    private int $right = 0;

    private int $bottom = 0;

    private int $left = 0;

    private int $size;

    private float $defaultColor;

    private float $flags;

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    public function parse(): void
    {
        $this->size = $this->file->readInt();
        if ($this->size === 0) {
            return;
        }

        $maskEnd = $this->file->tell() + $this->size;

        // First, we parse the coordinates of the mask.
        $this->top = $this->file->readInt();
        $this->left = $this->file->readInt();
        $this->bottom = $this->file->readInt();
        $this->right = $this->file->readInt();

        $this->defaultColor = $this->file->readByte();
        $this->flags = $this->file->readByte();

        $this->file->ffseek($maskEnd);
    }

    public function getSize(): int
    {
        if (!isset($this->size)) {
            throw new Exception('Mask not parsed. Size is undefined.');
        }

        return $this->size;
    }

    public function getDefaultColor(): float
    {
        if (!isset($this->defaultColor)) {
            throw new Exception('Mask not parsed. DefaultColor is undefined.');
        }

        return $this->defaultColor;
    }

    public function getFlags(): float
    {
        if (!isset($this->flags)) {
            throw new Exception('Mask not parsed. Flags is undefined.');
        }

        return $this->flags;
    }

    public function getTop(): int
    {
        return $this->top;
    }

    public function getLeft(): int
    {
        return $this->left;
    }

    public function getBottom(): int
    {
        return $this->bottom;
    }

    public function getRight(): int
    {
        return $this->right;
    }

    public function getWidth(): int
    {
        return $this->getRight() - $this->getLeft();
    }

    public function getHeight(): int
    {
        return $this->getBottom() - $this->getTop();
    }

    public function getRelative(): bool
    {
        return ($this->getFlags() & 0x01) > 0;
    }

    public function getDisabled(): bool
    {
        return ($this->getFlags() & (0x01 << 1)) > 0;
    }

    public function getInvert(): bool
    {
        return ($this->getFlags() & (0x01 << 2)) > 0;
    }

    public function getFromOtherData(): bool
    {
        return ($this->getFlags() & (0x01 << 3)) > 0;
    }

    public function export(): array
    {
        if ($this->getSize() === 0) {
            return [];
        }

        return [
            'top' => $this->getTop(),
            'left' => $this->getLeft(),
            'bottom' => $this->getBottom(),
            'right' => $this->getRight(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'defaultColor' => $this->getDefaultColor(),
            'relative' => $this->getRelative(),
            'disabled' => $this->getDisabled(),
            'invert' => $this->getInvert(),
            'fromOtherData' => $this->getFromOtherData(),
        ];
    }
}
