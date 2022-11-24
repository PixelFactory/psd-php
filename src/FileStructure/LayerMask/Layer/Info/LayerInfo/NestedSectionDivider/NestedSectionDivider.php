<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\NestedSectionDivider;

use Exception;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class NestedSectionDivider extends LayerInfoBase {
  protected function parseData(int $length): void {
    $code = $this->file->readInt();
    $data = [
      'isFolder' => false,
      'isHidden' => false,
    ];

    if ($code === 1 || $code === 2) {
        $data['isFolder'] = true;
    } else if ($code === 3) {
        $data['isHidden'] = true;
    } else {
      throw new Exception(sprintf('NestedSectionDivider error. Not supported code: %s', $code));
    }

    $this->data = $data;
  }

  public function export() {
    return $this->getData();
  }
}
