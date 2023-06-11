<?php

namespace Psd\Image\ImageExport;

use Psd\Image\ImageChannels\RgbaJson;
use Exception;
use Psd\Image\ImageExport\Exports\ImageExportInterface;
use Psd\Image\ImageExport\Exports\Png;

class ImageExport
{
    const EXPORT_FORMAT_PNG = 'png';

    /**
     * @throws Exception
     */
    static function buildImageExport(string $type, int $width, int $height, RgbaJson $pixelData): ImageExportInterface
    {
        if ($type === static::EXPORT_FORMAT_PNG) {
            return new Png($width, $height, $pixelData);
        }

        throw new Exception(sprintf('Error type: %s', $type));
    }
}
