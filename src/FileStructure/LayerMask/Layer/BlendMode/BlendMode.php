<?php

namespace Psd\FileStructure\LayerMask\Layer\BlendMode;

use Exception;
use Psd\File\FileInterface;

class BlendMode implements BlendModeInterface
{
    protected FileInterface $file;

    protected string $blendKey;

    protected float $opacity;

    protected float $clipping;

    protected float $flags;

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    public function parse(): void
    {
        $this->file->ffseek(4, true);

        $this->blendKey = $this->parseBlendKey();
        $this->opacity = $this->file->readByte();
        $this->clipping = $this->file->readByte();
        $this->flags = $this->file->readByte();

        $this->file->ffseek(1, true);
    }

    public function getBlendKey(): string
    {
        if (!isset($this->blendKey)) {
            throw new Exception('BlendMode not parsed. BlendKey is undefined.');
        }

        return $this->blendKey;
    }

    public function getOpacity(): float
    {
        if (!isset($this->opacity)) {
            throw new Exception('BlendMode not parsed. Opacity is undefined.');
        }

        return $this->opacity;
    }

    public function getClipping(): float
    {
        if (!isset($this->clipping)) {
            throw new Exception('BlendMode not parsed. Clipping is undefined.');
        }

        return $this->clipping;
    }

    public function getFlags(): float
    {
        if (!isset($this->flags)) {
            throw new Exception('BlendMode not parsed. Flags is undefined.');
        }

        return $this->flags;
    }

    public function getMode(): string
    {
        return static::BLEND_MODE_KEY[$this->getBlendKey()];
    }

    public function getClipped(): bool
    {
        return $this->getClipping() === 1;
    }

    public function getVisible(): bool
    {
        return !(($this->getFlags() & (0x01 << 1)) > 0);
    }

    public function opacityPercentage(): float
    {
        return ($this->getOpacity() * 100) / 255;
    }

    public function parseBlendKey(): string
    {
        $blendKey = trim($this->file->readString(4));

        if (!isset(static::BLEND_MODE_KEY[$blendKey])) {
            throw new Exception(sprintf('BlendKey not found. Key: %s', $blendKey));
        }

        return $blendKey;
    }
}
