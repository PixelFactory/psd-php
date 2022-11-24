<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorStrokeContent;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class VectorStrokeContent extends LayerInfoBase {
  protected function parseData(int $length): void {
    $this->file->ffseek(8, true);
    $this->data = $this->descriptor->parse();
  }

  public function export() {
    return $this->getData();
  }
}
