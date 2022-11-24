<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\GradientFill;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class GradientFill extends LayerInfoBase
{
    public function parseData(int $length): void
    {
        $this->file->ffseek(4, true); // Skip sig
        $this->data = $this->descriptor->parse();
    }

    public function export()
    {
        return $this->getData();
    }
}
