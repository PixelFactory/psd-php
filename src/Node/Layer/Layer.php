<?php

namespace Psd\Node\Layer;

class Layer
{
    protected string $name;
    protected int $top;
    protected int $right;
    protected int $bottom;
    protected int $left;
    protected int $width;
    protected int $height;
    protected LayerInterface $layerData;

    public function __construct(
        string         $name,
        int            $top,
        int            $right,
        int            $bottom,
        int            $left,
        int            $width,
        int            $height,
        LayerInterface $layerData
    )
    {
        $this->name = $name;
        $this->top = $top;
        $this->right = $right;
        $this->bottom = $bottom;
        $this->left = $left;
        $this->width = $width;
        $this->height = $height;
        $this->layerData = $layerData;
    }

    public function isFolder(): bool
    {
        return false;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getTop(): int
    {
        return $this->top;
    }

    public function getRight(): int
    {
        return $this->right;
    }

    public function getBottom(): int
    {
        return $this->bottom;
    }

    public function getLeft(): int
    {
        return $this->left;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getLayerData(): LayerInterface
    {
        return $this->layerData;
    }
}
