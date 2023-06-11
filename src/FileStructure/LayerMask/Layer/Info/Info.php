<?php

namespace Psd\FileStructure\LayerMask\Layer\Info;

use Exception;
use Psd\File\FileInterface;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBuilder;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBuilderInterface;
use Psd\LazyExecuteProxy\Proxies\LayerInfoProxy;

class Info implements InfoInterface
{
    const FILE_SIGNATURE = '8BIM';

    protected FileInterface $file;

    protected LayerInfoBuilderInterface $layerInfoBuilder;

    protected $data;

    protected array $infoKeys = [];

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
        $this->layerInfoBuilder = $this->buildLayerInfo();
    }

    public function parse(int $layerEnd): void
    {
        $this->data = [];

        while ($this->file->tell() < $layerEnd) {
            $sig = $this->file->readString(4);

            if ($sig !== static::FILE_SIGNATURE) {
                throw new Exception(sprintf('Invalid file signature detected. Got: %s. Expected 8BIM.', $sig));
            }

            $key = $this->file->readString(4);
            $layerInfoData = $this->layerInfoBuilder->build($this->file, $key);

            $this->data[$layerInfoData->getName()] = new LayerInfoProxy($layerInfoData->getLayerInfo(), $this->file);

            // For debugging purposes, we store every key that we can parse.
            $this->infoKeys[] = $key;
        }
    }

    public function getDataInfo(string $name)
    {
        if (!isset($this->getData()[$name])) {
            throw new Exception('Info not found.');
        }

        return $this->getData()[$name];
    }

    public function getData()
    {
        if (!isset($this->data)) {
            throw new Exception('Info not parsed. Data is undefined.');
        }

        return $this->data;
    }

    public function getInfoKeys(): array
    {
        return $this->infoKeys;
    }

    protected function buildLayerInfo(): LayerInfoBuilderInterface
    {
        return new LayerInfoBuilder();
    }
}
