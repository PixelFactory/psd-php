<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerId;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class LayerId extends LayerInfoBase
{
    public function parseData(int $length): void
    {
        $this->data = $this->file->readInt();
    }

    public function export()
    {
        return $this->getData();
    }
}
