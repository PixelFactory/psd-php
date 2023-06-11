<?php

namespace Psd\Image\ImageFormat;

interface ImageFormatInterface
{
    const IMAGE_FORMAT_RAW = 0;
    const IMAGE_FORMAT_RLE = 1;
    const IMAGE_FORMAT_ZIP = 2;
    const IMAGE_FORMAT_ZIP_PREDICTION = 3;
}
