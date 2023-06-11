<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendInteriorElements;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class BlendInteriorElements extends LayerInfoBase
{
    protected function parseData(int $length): void
    {
        $this->data = $this->file->readBoolean();
        $this->file->ffseek(3, true);
    }

    public function export()
    {
        return $this->getData();
    }
}
