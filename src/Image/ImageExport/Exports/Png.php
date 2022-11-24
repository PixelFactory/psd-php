<?php

namespace Psd\Image\ImageExport\Exports;

use Imagick;
use ImagickPixel;
use ImagickPixelIterator;
use Psd\Image\ImageChannels\RgbaJson;

class Png implements ImageExportInterface {
  protected int $width;

  protected int $height;

  protected RgbaJson $pixelData;

    public function __construct(int $width, int $height, RgbaJson $pixelData) {
    $this->width = $width;
    $this->height = $height;
    $this->pixelData = $pixelData;
  }

    public function export(): Imagick {
      $pixelDataJson = $this->pixelData->getPixelData();
      $png = new Imagick();

      $png->newImage($this->width, $this->height, new ImagickPixel("transparent"));
      $imageIterator = new ImagickPixelIterator($png);

      $i = 0;

      foreach ($imageIterator as $pixels) {
          foreach ($pixels as $column => $pixel) {
              $rgba = substr($pixelDataJson, ($i * 42) + 1,41);

              $r = substr($rgba, 6, 3);
              $g = substr($rgba, 16,3);
              $b = substr($rgba, 26,3);
              $a = substr($rgba, 36,3);

              /** @var $pixel ImagickPixel */
              $pixel->setColor('rgba(' . $r . ',' . $g .',' . $b .',' . $a . ')');
              $i++;
          }

          $imageIterator->syncIterator();
      }

      $png->setImageFormat("png");

      return $png;
  }

  public function save(string $fileName): void {
        file_put_contents($fileName, $this->export());
  }
}
