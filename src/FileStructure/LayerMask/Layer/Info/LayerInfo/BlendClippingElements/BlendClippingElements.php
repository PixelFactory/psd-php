<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendClippingElements;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class BlendClippingElements extends LayerInfoBase {
  protected function parseData(int $length): void {
    $this->data = $this->file->readBoolean();
    $this->file->ffseek(3, true);
  }

  public function export() {
    return $this->getData();
  }
}
