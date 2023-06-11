<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\Locked;


use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class Locked extends LayerInfoBase
{
    protected function parseData(int $length): void
    {
        $locked = $this->file->readInt();

        $transparencyLocked = (($locked & (0x01 << 0)) > 0) || ($locked === -2147483648);
        $compositeLocked = (($locked & (0x01 << 1)) > 0) || ($locked === -2147483648);
        $positionLocked = (($locked & (0x01 << 2)) > 0) || ($locked === -2147483648);

        $this->data = [
            'transparencyLocked' => $transparencyLocked,
            'compositeLocked' => $compositeLocked,
            'positionLocked' => $positionLocked,
            'allLocked' => ($transparencyLocked && $compositeLocked && $positionLocked),
        ];
    }

    public function export()
    {
        return $this->getData();
    }
}
