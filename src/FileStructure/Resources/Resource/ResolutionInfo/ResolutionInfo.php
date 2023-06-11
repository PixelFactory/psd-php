<?php

namespace Psd\FileStructure\Resources\Resource\ResolutionInfo;

use Psd\FileStructure\Resources\Resource\ResourceBase;

class ResolutionInfo extends ResourceBase
{
    public function parseResourceData(): void
    {
        // 32-bit fixed-point number (16.16)
        $hRes = $this->file->readUInt() / 65536;
        $hResUnit = $this->file->readUShort();
        $widthUnit = $this->file->readUShort();

        // 32-bit fixed-point number (16.16)
        $vRes = $this->file->readUInt() / 65536;
        $vResUnit = $this->file->readUShort();
        $heightUnit = $this->file->readUShort();

        $this->data = (new ResolutionInfoData())
            ->setHRes($hRes)
            ->setHResUnit($hResUnit)
            ->setWidthUnit($widthUnit)
            ->setVRes($vRes)
            ->setVResUnit($vResUnit)
            ->setHeightUnit($heightUnit);
    }
}
