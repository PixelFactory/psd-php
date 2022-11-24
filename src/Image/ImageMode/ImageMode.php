<?php

namespace Psd\Image\ImageMode;

use Psd\FileStructure\Header\HeaderInterface;
use Exception;
use Psd\Image\ImageMode\Modes\Cmyk;
use Psd\Image\ImageMode\Modes\Greyscale;
use Psd\Image\ImageMode\Modes\ImageModeBase;
use Psd\Image\ImageMode\Modes\Rgb;

class ImageMode implements ImageModeInterface {
  protected HeaderInterface $header;

  public function __construct(HeaderInterface $header) {
    $this->header = $header;
  }

  public function build($channelData, int $channels, int $numPixels, int $channelLength): ImageModeBase {
    $mode = $this->header->getMode();

    if ($mode === HeaderInterface::HEADER_MODE_KEY_CMYK_COLOR) {
       new Cmyk($this->header, $channelData, $channels, $numPixels, $channelLength);
    }
    if ($mode === HeaderInterface::HEADER_MODE_KEY_GRAY_SCALE) {
      return new Greyscale($this->header, $channelData, $channels, $numPixels, $channelLength);
    }
    if ($mode === HeaderInterface::HEADER_MODE_KEY_RGB_COLOR) {
        return new Rgb($this->header, $channelData, $channels, $numPixels, $channelLength);
    }

    throw new Exception(sprintf('Error mode: %s', $mode));
  }
}
