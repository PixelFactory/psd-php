<?php

namespace Psd\FileStructure\Resources;

use Exception;
use Psd\File\FileInterface;
use Psd\FileStructure\Resources\Resource\Resource;
use Psd\FileStructure\Resources\Resource\ResourceBase;
use Psd\FileStructure\Resources\Resource\ResourceInterface;
use Psd\LazyExecuteProxy\Interfaces\ResourcesInterface;

class Resources implements ResourcesInterface {
  protected FileInterface $file;

  protected ResourceInterface $resource;

  protected array $resources = [];

  protected array $resourcesByName = [];

  public function __construct(FileInterface $file) {
    $this->file = $file;
    $this->resource = $this->buildResource($this->file);
  }

  public function skip(): void {
    $this->file->ffseek($this->file->readInt(), true);
  }

  public function parse(): void {
    $finish = $this->file->readInt() + $this->file->tell();

    while ($this->file->tell() < $finish) {
      $this->parseResource();
    }

    $this->file->ffseek($finish);
  }

  public function getResources(): array {
    return $this->resources;
  }

  public function getResource($search) {
    if (is_string($search)) {
      return $this->getResourceByName($search);
    }

    return $this->getResourceById($search);
  }

  public function getResourceByName(string $name) {
    if (!isset($this->resourcesByName[$name])) {
      throw new Exception(sprintf('Resource not found. Name: %s', $name));
    }

    return $this->getResourceById($this->resourcesByName[$name]);
  }

  public function getResourceById($id) {
    if (!isset($this->resources[$id])) {
      throw new Exception(sprintf('Resource not found. Id: %s', $id));
    }

    return $this->resources[$id];
  }

  protected function parseResource(): void {
    $resource = $this->resource->parse();

    $this->resources[$resource->getId()] = $resource;

    if (
        isset(ResourceBase::RESOURCE_IDS[$resource->getId()])
        && $resource->getName() !== ResourceBase::RESOURCE_NAME_UNDEFINED_NAME
    ) {
      if (isset($this->resourcesByName[$resource->getName()])) {
        throw new Exception('Resource name already exists.');
      }

      $this->resourcesByName[$resource->getName()] = $resource->getId();
    }
  }

  protected function buildResource(FileInterface $file): ResourceInterface {
    return new Resource($file);
  }
}
