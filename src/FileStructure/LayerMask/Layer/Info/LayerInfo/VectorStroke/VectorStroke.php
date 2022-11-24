<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorStroke;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class VectorStroke extends LayerInfoBase {
  public function parseData($length): void {
    $this->file->ffseek(4, true);
    $this->data = $this->descriptor->parse();
  }

    public function export() {
    return $this->getData();
  }
}
