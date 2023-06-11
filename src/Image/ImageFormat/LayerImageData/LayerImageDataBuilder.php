<?php

namespace Psd\Image\ImageFormat\LayerImageData;

use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\Image\ImageChannels\ImageChannels;
use Psd\Image\ImageFormat\ImageFormatInterface;
use Exception;

class LayerImageDataBuilder implements LayerImageDataBuilderInterface
{
    protected FileInterface $file;

    protected HeaderInterface $header;

    public function __construct(FileInterface $file, HeaderInterface $header)
    {
        $this->file = $file;
        $this->header = $header;
    }

    public function build(int $type, ImageChannels $channelData): LayerImageDataBase
    {
        if ($type === ImageFormatInterface::IMAGE_FORMAT_RAW) {
            return $this->buildRaw($this->file, $this->header, $channelData);
        }

        if ($type === ImageFormatInterface::IMAGE_FORMAT_RLE) {
            return $this->buildRle($this->file, $this->header, $channelData);
        }

        if ($type === ImageFormatInterface::IMAGE_FORMAT_ZIP) {
            return $this->buildZip($this->file, $this->header, $channelData);
        }

        if ($type === ImageFormatInterface::IMAGE_FORMAT_ZIP_PREDICTION) {
            return $this->buildZipPrediction($this->file, $this->header, $channelData);
        }

        throw new Exception(sprintf('Error type: %s', $type));
    }

    protected function buildRaw(FileInterface $file, HeaderInterface $header, ImageChannels $channelData): LayerImageDataBase
    {
        return new LayerRaw($file, $header, $channelData);
    }

    protected function buildRle(FileInterface $file, HeaderInterface $header, ImageChannels $channelData): LayerImageDataBase
    {
        return new LayerRle($file, $header, $channelData);
    }

    /**
     * @throws Exception
     */
    protected function buildZip(FileInterface $file, HeaderInterface $header, ImageChannels $channelData): LayerImageDataBase
    {
        throw new Exception('ZIP layer image compression not supported yet.');
    }

    /**
     * @throws Exception
     */
    protected function buildZipPrediction(FileInterface $file, HeaderInterface $header, ImageChannels $channelData): LayerImageDataBase
    {
        throw new Exception('ZipPrediction layer image compression not supported yet.');
    }
}
