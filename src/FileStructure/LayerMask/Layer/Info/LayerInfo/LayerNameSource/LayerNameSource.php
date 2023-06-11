<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerNameSource;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class LayerNameSource extends LayerInfoBase
{
    protected function parseData(int $length): void
    {
        $this->data = $this->file->readString(4);
    }

    public function export()
    {
        return $this->getData();
    }
}
