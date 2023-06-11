<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\EmptyLayerInfo;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class EmptyLayerInfo extends LayerInfoBase
{
    protected function parseData(int $length): void
    {
    }

    public function export(): void
    {
    }
}
