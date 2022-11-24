<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\Metadata;

use Psd\Descriptor\Descriptor;
use Psd\Descriptor\DescriptorInterface;
use Psd\File\FileInterface;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class Metadata extends LayerInfoBase {
  const LAYER_COMPS = 'cmls';

  protected function parseData(int $length): void {
    $count = $this->file->readInt();

    for ($i = 0; $i < $count; $i++) {
      $this->file->ffseek(4, true);

      $key = $this->file->readString(4);
      $this->file->readByte();

      $this->file->ffseek(3, true); // padding

      $len = $this->file->readInt();
      $end = $this->file->tell() + $len;

      if ($key === static::LAYER_COMPS) {
        $this->file->ffseek(4, true);
        $this->buildDescriptor($this->file)->parse();
      }

      $this->file->ffseek($end);
    }
  }

    public function export(): void {
  }

  protected function buildDescriptor(FileInterface $file): DescriptorInterface {
    return new Descriptor($file);
  }
}
