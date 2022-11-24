<?php

namespace Psd\Image\ImageFormat\ImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageFormat\ImageFormatInterface;
use Exception;

class ImageDataBuilder implements ImageDataBuilderInterface {
  protected FileInterface $file;

  protected HeaderInterface $header;

  public function __construct(FileInterface $file, HeaderInterface $header) {
    $this->file = $file;
    $this->header = $header;
  }

  public function build(int $type): ImageDataBase {
      if ($type === ImageFormatInterface::IMAGE_FORMAT_RAW) {
          return $this->buildRaw($this->file, $this->header);
      }

      if ($type === ImageFormatInterface::IMAGE_FORMAT_RLE) {
          return $this->buildRle($this->file, $this->header);
      }

      if ($type === ImageFormatInterface::IMAGE_FORMAT_ZIP) {
          return $this->buildZip($this->file, $this->header);
      }

      if ($type === ImageFormatInterface::IMAGE_FORMAT_ZIPPREDICTION) {
          return $this->buildZipPrediction($this->file, $this->header);
      }

    throw new Exception(sprintf('Error type: %s', $type));
  }

  protected function buildRaw(FileInterface $file, HeaderInterface $header): ImageDataBase {
    return new Raw($file, $header);
  }

  protected function buildRle(FileInterface $file, HeaderInterface $header): ImageDataBase {
    return new Rle($file, $header);
  }

  protected function buildZip(FileInterface $file, HeaderInterface $header): ImageDataBase {
    throw new Exception('ZIP image compression not supported yet.');
  }

  protected function buildZipPrediction(FileInterface $file, HeaderInterface $header): ImageDataBase {
    throw new Exception('ZipPrediction image compression not supported yet.');
  }
}
