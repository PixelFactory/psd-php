<?php

namespace Psd;

use Psd\File\FileInterface;
use Psd\File\File;
use Psd\FileStructure\Header\Header;
use Psd\FileStructure\Image\Image;
use Psd\FileStructure\LayerMask\LayerMask;
use Psd\FileStructure\Resources\Resources;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\LazyExecuteProxy\Interfaces\ImageInterface;
use Psd\LazyExecuteProxy\Interfaces\LayerMaskInterface;
use Psd\LazyExecuteProxy\Interfaces\ResourcesInterface;
use Psd\LazyExecuteProxy\Proxies\ImageProxy;
use Psd\LazyExecuteProxy\Proxies\LayerMaskProxy;
use Psd\LazyExecuteProxy\Proxies\ResourcesProxy;
use Psd\Node\Node;
use Psd\Node\NodeInterface;

class Psd
{
    protected bool $parsed = false;

    protected FileInterface $file;

    protected HeaderInterface $header;

    protected ResourcesInterface $resources;

    protected LayerMaskInterface $layerMask;

    protected ImageInterface $image;

    protected NodeInterface $node;

    public function __construct(string $fileName)
    {
        $this->file = $this->buildFile($fileName);
        $this->header = $this->buildHeader($this->file);
        $this->resources = $this->buildResources($this->file);
        $this->layerMask = $this->buildLayerMask($this->file, $this->header);
        $this->image = $this->buildImage($this->file, $this->header);
    }

    public function parse(): bool
    {
        if ($this->parsed) {
            return false;
        }

        $this->parseHeader();
        $this->parseResources();
        $this->parseLayerMask();
        $this->parseImage();

        $this->parsed = true;
        return $this->parsed;
    }

    protected function parseHeader(): void
    {
        $this->header->parse();
    }

    protected function parseResources(): void
    {
        $this->resources = new ResourcesProxy($this->resources, $this->file);
    }

    protected function parseLayerMask(): void
    {
        $this->layerMask = new LayerMaskProxy($this->layerMask, $this->file);
    }

    public function getHeader(): HeaderInterface
    {
        if (!$this->parsed) {
            $this->parse();
        }

        return $this->header;
    }

    public function getResources(): ResourcesInterface
    {
        if (!$this->parsed) {
            $this->parse();
        }

        return $this->resources;
    }

    public function getImage(): ImageInterface
    {
        if (!$this->parsed) {
            $this->parse();
        }

        return $this->image;
    }

    public function getLayers(): array
    {
        if (!$this->parsed) {
            $this->parse();
        }

        return $this->layerMask->getLayers();
    }

    public function getTree(): NodeInterface
    {
        if (!$this->parsed) {
            $this->parse();
        }

        if (!isset($this->node)) {
            $this->node = $this->buildNode($this->getLayers());
        }

        return $this->node;
    }

    public function getWidth(): int
    {
        return $this->header->getWidth();
    }

    public function getHeight(): int
    {
        return $this->header->getHeight();
    }

    protected function buildFile(string $fileName): FileInterface
    {
        return new File($fileName);
    }

    protected function buildHeader(FileInterface $file): HeaderInterface
    {
        return new Header($file);
    }

    protected function buildResources(FileInterface $file): ResourcesInterface
    {
        return new Resources($file);
    }

    protected function buildLayerMask(FileInterface $file, HeaderInterface $header): LayerMaskInterface
    {
        return new LayerMask($file, $header);
    }

    protected function buildImage(FileInterface $file, HeaderInterface $header): ImageInterface
    {
        return new Image($file, $header);
    }

    protected function buildNode(array $layers): NodeInterface
    {
        return Node::build($layers);
    }

    protected function parseImage(): void
    {
        $this->image = new ImageProxy($this->image, $this->file);
    }
}
