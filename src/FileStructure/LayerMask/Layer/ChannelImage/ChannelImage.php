<?php

namespace Psd\FileStructure\LayerMask\Layer\ChannelImage;

use Exception;
use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;
use Psd\Image\ImageChannels\RgbaJson;
use Psd\Image\ImageExport\Exports\ImageExportInterface;
use Psd\Image\ImageExport\ImageExport;
use Psd\Image\ImageFormat\LayerImageData\LayerImageDataBuilder;
use Psd\Image\ImageFormat\LayerImageData\LayerImageDataBuilderInterface;
use Psd\Image\ImageMode\ImageMode;
use Psd\Image\ImageMode\ImageModeInterface;
use Psd\LazyExecuteProxy\Interfaces\ChannelImageInterface;

class ChannelImage implements ChannelImageInterface {
  protected FileInterface $file;

  protected HeaderInterface $header;

  protected array $layerData;

  protected LayerImageDataBuilderInterface $imageDataBuilder;

  protected ImageModeInterface $imageMode;

  protected ImageChannels $channelData;

  protected RgbaJson $pixelData;

  protected int $maxWidth;

  protected int $maxHeight;

  protected $numPixels;//: number;

  public function __construct(FileInterface $file, HeaderInterface $header, array $layerData) {
    $this->file = $file;
    $this->header = $header;
    $this->layerData = $layerData;
    $this->imageDataBuilder = $this->buildImageDataBuilder($this->file, $this->header);
    $this->imageMode = $this->buildImageMode($this->header);

    $minChanId = min(array_map(static function($chan){ return $chan['id']; }, $this->layerData['layerChannelsInfo']));

    $this->maxWidth = ($minChanId < -1) ? $this->layerData['layerMaskWidth'] : $this->layerData['layerWidth'];
    $this->maxHeight = ($minChanId < -1) ? $this->layerData['layerMaskHeight'] : $this->layerData['layerHeight'];


    $this->channelData = new ImageChannels($this->maxWidth * $this->maxHeight * count($this->layerData['layerChannelsInfo']));

    $this->numPixels = $this->layerData['layerWidth'] * $this->layerData['layerHeight'];
  }

    public function getExporter(string $type): ImageExportInterface {
    return ImageExport::buildImageExport($type, $this->maxWidth, $this->maxHeight, $this->getPixelData());
  }

  public function skip(): void {
    for ($i = 0; $i < count($this->layerData['layerChannelsInfo']); $i += 1) {
      $this->file->ffseek($this->layerData['layerChannelsInfo'][$i]['dataLength'], true);
    }
  }

  public function getLayerData(): array {
    return $this->layerData;
  }

  public function parse(): void {
    $chanPos = 0;

    for ($i = 0; $i < count($this->layerData['layerChannelsInfo']); $i++) {
      $chan = $this->layerData['layerChannelsInfo'][$i];

      if ($chan['dataLength'] <= 0) {
        $this->parseData($chanPos, $chan['dataLength'], $this->maxHeight);
        continue;
      }

      $start = $this->file->tell();

      $chanPos = $this->parseData($chanPos, $chan['dataLength'], $this->maxHeight);

      $finish = $this->file->tell();

      if ($finish !== $start + $chan['dataLength']) {
        $this->file->ffseek($start + $chan['dataLength']);
      }
    }

    $this->pixelData = $this->imageMode->build(
      $this->channelData,
      $this->layerData['layerChannels'],
      $this->numPixels,
      $this->header->getChannelLength($this->layerData['layerWidth'], $this->layerData['layerHeight'])
    )->combineChannel();
  }

  public function getPixelData(): RgbaJson {
    if (!isset($this->pixelData)) {
      throw new Exception('PixelData is undefined.');
    }

    return $this->pixelData;
  }

  protected function parseData(int $chanPos, int $dataLength, int $height): int {
    $compression = $this->file->readShort();

    return $this->imageDataBuilder->build($compression, $this->channelData)->parse($chanPos, $dataLength, $height);
  }

  protected function buildImageMode(HeaderInterface $header): ImageModeInterface {
    return new ImageMode($header);
  }

  protected function buildImageDataBuilder(FileInterface $file, HeaderInterface $header): LayerImageDataBuilderInterface {
    return new LayerImageDataBuilder($file, $header);
  }
}
