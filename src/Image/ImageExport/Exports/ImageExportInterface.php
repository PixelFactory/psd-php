<?php

namespace Psd\Image\ImageExport\Exports;

use Imagick;

interface ImageExportInterface
{
    public function export(): Imagick;

    public function save(string $fileName): bool;
}
