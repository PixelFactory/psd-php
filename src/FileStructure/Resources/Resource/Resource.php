<?php

namespace Psd\FileStructure\Resources\Resource;

use Psd\File\FileInterface;
use Exception;
use Psd\FileStructure\Resources\Resource\EmptyResource\EmptyResource;
use Psd\FileStructure\Resources\Resource\Guides\Guides;
use Psd\FileStructure\Resources\Resource\LayerComps\LayerComps;
use Psd\FileStructure\Resources\Resource\ResolutionInfo\ResolutionInfo;

class Resource implements ResourceInterface {
  protected const SIGNATURE = '8BIM';

  protected FileInterface $file;

  public function __construct(FileInterface $file) {
    $this->file = $file;
  }

  public function parse(): ResourceBase {
    $type = $this->file->readString(4);

    if ($type !== static::SIGNATURE) {
      throw new Exception('Wrong resource data.');
    }

    $id = $this->file->readShort();

    $resource = new EmptyResource($this->file, $id);

    if ($id === ResourceBase::RESOURCE_ID_GUIDES) {
      $resource = new Guides($this->file, $id);
    } else if ($id === ResourceBase::RESOURCE_ID_LAYER_COMPS) {
      $resource = new LayerComps($this->file, $id);
    } else if ($id === ResourceBase::RESOURCE_ID_RESOLUTION_INFO) {
      $resource = new ResolutionInfo($this->file, $id);
    }

    $resource->parseResource();

    return $resource;
  }
}
