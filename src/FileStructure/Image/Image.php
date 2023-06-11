<?php

namespace Psd\FileStructure\Image;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Exception;
use Psd\Image\ImageChannels\RgbaJson;
use Psd\Image\ImageExport\Exports\ImageExportInterface;
use Psd\Image\ImageExport\ImageExport;
use Psd\Image\ImageFormat\ImageData\ImageDataBuilder;
use Psd\Image\ImageFormat\ImageData\ImageDataBuilderInterface;
use Psd\Image\ImageMode\ImageMode;
use Psd\Image\ImageMode\ImageModeInterface;
use Psd\LazyExecuteProxy\Interfaces\ImageInterface;

class Image implements ImageInterface
{
    protected FileInterface $file;

    protected HeaderInterface $header;

    protected ImageDataBuilderInterface $imageFormat;

    protected ImageModeInterface $imageMode;

    protected RgbaJson $pixelData;

    public function __construct(FileInterface $file, HeaderInterface $header)
    {
        $this->file = $file;
        $this->header = $header;

        $this->imageFormat = $this->buildImageFormat($this->file, $this->header);
        $this->imageMode = $this->buildImageMode($this->header);
    }

    public function skip(): void
    {
        $this->file->ffseek($this->getEndPos());
    }


    /**
     * @throws Exception
     */
    public function getExporter(string $type): ImageExportInterface
    {
        return ImageExport::buildImageExport($type, $this->header->getWidth(), $this->header->getHeight(), $this->getPixelData());
    }

    /**
     * @throws Exception
     */
    public function getPixelData(): RgbaJson
    {
        if (!isset($this->pixelData)) {
            throw new Exception('PixelData is undefined.');
        }

        return $this->pixelData;
    }

    /**
     * Parses the image and formats the image data.
     */
    public function parse(): void
    {
        $compression = $this->file->readShort();
        $this->parseImageData($compression);
    }

    /**
     * Parses the image data based on the compression mode.
     */
    protected function parseImageData(int $compression): void
    {
        $channelData = $this->imageFormat->build($compression)->parse();

        $this->pixelData = $this->imageMode->build(
            $channelData,
            $this->header->getChannels(),
            $this->header->getNumPixels(),
            $this->header->getChannelLength(),
        )->combineChannel();
    }

    protected function getEndPos(): int
    {
        return $this->file->tell() + $this->header->getFileLength();
    }

    protected function buildImageMode(HeaderInterface $header): ImageModeInterface
    {
        return new ImageMode($header);
    }

    protected function buildImageFormat(FileInterface $file, HeaderInterface $header): ImageDataBuilderInterface
    {
        return new ImageDataBuilder($file, $header);
    }
}
