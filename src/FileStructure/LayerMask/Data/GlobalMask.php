<?php

namespace Psd\FileStructure\LayerMask\Data;

class GlobalMask
{
    protected int $overlayColorSpace;
    protected array $colorComponents;
    protected float $opacity;
    protected float $kind;

    /**
     * @param int $overlayColorSpace
     * @return $this
     */
    public function setOverlayColorSpace(int $overlayColorSpace): self
    {
        $this->overlayColorSpace = $overlayColorSpace;
        return $this;
    }

    /**
     * @param array $colorComponents
     * @return $this
     */
    public function setColorComponents(array $colorComponents): self
    {
        $this->colorComponents = $colorComponents;
        return $this;
    }

    /**
     * @param float $opacity
     * @return $this
     */
    public function setOpacity(float $opacity): self
    {
        $this->opacity = $opacity;
        return $this;
    }

    /**
     * @param int $kind
     * @return $this
     */
    public function setKind(int $kind): self
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return int
     */
    public function getOverlayColorSpace(): int
    {
        return $this->overlayColorSpace;
    }

    /**
     * @return array
     */
    public function getColorComponents(): array
    {
        return $this->colorComponents;
    }

    /**
     * @return float
     */
    public function getOpacity(): float
    {
        return $this->opacity;
    }

    /**
     * @return int
     */
    public function getKind(): int
    {
        return $this->kind;
    }
}
