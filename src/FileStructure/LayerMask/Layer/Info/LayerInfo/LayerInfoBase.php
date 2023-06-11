<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo;

use Exception;
use Psd\Descriptor\Descriptor;
use Psd\Descriptor\DescriptorInterface;
use Psd\File\FileInterface;
use Psd\Helper;
use Psd\LazyExecuteProxy\Interfaces\LayerInfoInterface;

abstract class LayerInfoBase implements LayerInfoInterface
{
    protected $data;

    protected FileInterface $file;

    protected DescriptorInterface $descriptor;

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
        $this->descriptor = $this->buildDescriptor($file);
    }

    public function parse(): void
    {
        $length = $this->readLength($this->file);
        $layerInfoEnd = $this->file->tell() + $length;

        $this->parseData($length);

        $this->file->ffseek($layerInfoEnd);
    }

    public function skip(): void
    {
        $this->file->ffseek($this->readLength($this->file), true);
    }

    abstract protected function parseData(int $length): void;

    abstract public function export();

    /**
     * @throws Exception
     */
    public function getData()
    {
        if (!isset($this->data)) {
            throw new Exception(sprintf('Data is undefined. Class: %s', get_class($this)));
        }

        return $this->data;
    }

    protected function readLength(FileInterface $file): int
    {
        return Helper::pad2($file->readInt());
    }

    protected function buildDescriptor(FileInterface $file): DescriptorInterface
    {
        return new Descriptor($file);
    }
}
