<?php

namespace Psd\FileStructure\Resources\Resource;

use Psd\File\FileInterface;
use Psd\Helper;
use Exception;

abstract class ResourceBase
{
    const RESOURCE_NAME_UNDEFINED_NAME = 'undefinedName';

    const RESOURCE_ID_GUIDES = 1032;
    const RESOURCE_ID_LAYER_COMPS = 1065;
    const RESOURCE_ID_RESOLUTION_INFO = 1005;

    const RESOURCE_IDS = [
        self::RESOURCE_ID_GUIDES,
        self::RESOURCE_ID_LAYER_COMPS,
        self::RESOURCE_ID_RESOLUTION_INFO,
    ];

    protected FileInterface $file;

    protected int $id;

    protected int $length;

    protected string $name;

    protected $data;

    public function __construct(FileInterface $file, int $id)
    {
        $this->file = $file;
        $this->id = $id;
    }

    public function parseResource(): void
    {
        $this->name = $this->parseName();
        $this->length = Helper::pad2($this->file->readInt());
        $resourceEnd = $this->file->tell() + $this->length;

        $this->parseResourceData();
        $this->file->ffseek($resourceEnd);
    }

    /**
     * @throws Exception
     */
    public function getData()
    {
        if (!isset($this->data)) {
            throw new Exception('Resource not parsed. Data is undefined.');
        }

        return $this->data;
    }

    /**
     * @throws Exception
     */
    public function getName(): string
    {
        if (!isset($this->name)) {
            throw new Exception('Resource not parsed. Name is undefined.');
        }

        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract public function parseResourceData(): void;

    protected function parseName(): string
    {
        $nameLength = Helper::pad2($this->file->readByte() + 1) - 1;
        $name = $this->file->readString($nameLength);

        if ($name === '') {
            return static::RESOURCE_NAME_UNDEFINED_NAME;
        }

        return $name;
    }
}
