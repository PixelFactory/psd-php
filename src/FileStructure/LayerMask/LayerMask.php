<?php

namespace Psd\FileStructure\LayerMask;

use Exception;
use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\FileStructure\LayerMask\Data\GlobalMask;
use Psd\FileStructure\LayerMask\Layer\Layer;
use Psd\FileStructure\LayerMask\Layer\LayerInterface;
use Psd\Helper;
use Psd\LazyExecuteProxy\Interfaces\LayerMaskInterface;

class LayerMask implements LayerMaskInterface {
  protected FileInterface $file;

  protected HeaderInterface $header;

  private array $layers;

  private bool $mergedAlpha;

  protected GlobalMask $globalMask;

  public function __construct(FileInterface $file, HeaderInterface $header) {
    $this->file = $file;
    $this->header = $header;
    $this->mergedAlpha = false;
  }

  public function getLayers(): array {
    if (!isset($this->layers)) {
      throw new Exception('LayerMask not parsed. Layers is undefined.');
    }

    return $this->layers;
  }

  public function getGlobalMask(): GlobalMask {
    if (!isset($this->globalMask)) {
      throw new Exception('LayerMask not parsed. GlobalMask is undefined.');
    }

    return $this->globalMask;
  }

  public function skip(): void {
    $this->file->ffseek($this->file->readInt(), true);
  }

  public function parse(): void {
    $maskSize = $this->file->readInt();
    $finish = $maskSize + $this->file->tell();

    if ($maskSize <= 0) { return; }

    $this->layers = array_reverse($this->parseLayers());
    $this->parseGlobalMask();

    $this->file->ffseek($finish);
  }

  protected function parseGlobalMask(): void {
    $length = $this->file->readInt();
    if ($length <= 0) { return; }

    $maskEnd = $this->file->tell() + $length;

    $overlayColorSpace = $this->file->readShort();
    $colorComponents = [
        $this->file->readShort() >> 8,
        $this->file->readShort() >> 8,
        $this->file->readShort() >> 8,
        $this->file->readShort() >> 8,
    ];

    $opacity = $this->file->readShort() / 16.0;
    $kind = $this->file->readByte();

    $this->globalMask = (new GlobalMask())
        ->setOverlayColorSpace($overlayColorSpace)
        ->setColorComponents($colorComponents)
        ->setOpacity($opacity)
        ->setKind($kind)
    ;

    $this->file->ffseek($maskEnd);
  }

  protected function parseLayers(): array {
    $layers = [];
    $layerInfoSize = Helper::pad2($this->file->readInt());

    if ($layerInfoSize > 0) {
        $layerCount = $this->file->readShort();

        if ($layerCount < 0) {
            $layerCount = abs($layerCount);
            $this->mergedAlpha = true;
        }

        for ($i = 0; $i < $layerCount; $i += 1) {
            $layer = $this->buildLayer($this->file, $this->header);
            $layer->parse();

            $layers[] = $layer;
        }

        foreach ($layers as $layer) {
            $layer->parseChannelImage();
        }
    }

    return $layers;
}

  protected function buildLayer(FileInterface $file, HeaderInterface $header): LayerInterface {
    return new Layer($file, $header);
  }
}
