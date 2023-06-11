<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\FillOpacity;

use Exception;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class FillOpacity extends LayerInfoBase
{
    public function parseData(int $length): void
    {
        $this->data = $this->file->readByte();
    }

    /**
     * @throws Exception
     */
    public function export()
    {
        return $this->getData();
    }
}
