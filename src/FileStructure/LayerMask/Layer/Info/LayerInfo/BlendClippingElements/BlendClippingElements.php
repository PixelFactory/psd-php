<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendClippingElements;

use Exception;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class BlendClippingElements extends LayerInfoBase
{
    protected function parseData(int $length): void
    {
        $this->data = $this->file->readBoolean();
        $this->file->ffseek(3, true);
    }

    /**
     * @throws Exception
     */
    public function export()
    {
        return $this->getData();
    }
}
