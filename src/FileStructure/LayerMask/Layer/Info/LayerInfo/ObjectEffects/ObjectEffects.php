<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\ObjectEffects;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class ObjectEffects extends LayerInfoBase {
  protected function parseData(int $length): void {
    $this->file->ffseek(8, true);
    $this->data = $this->descriptor->parse();
  }

  public function export() {
    return $this->getData();
  }
}
