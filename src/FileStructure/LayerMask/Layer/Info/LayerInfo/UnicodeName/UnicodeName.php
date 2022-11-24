<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\UnicodeName;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class UnicodeName extends LayerInfoBase {
  protected function parseData(int $length): void {
    $pos = $this->file->tell();
    $this->data = $this->file->readUnicodeString();

    $this->file->ffseek($pos + $length);
  }

public function export(): string {
    return $this->getData();
  }
}
