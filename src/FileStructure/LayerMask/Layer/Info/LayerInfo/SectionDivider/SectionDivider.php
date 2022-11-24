<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\SectionDivider;

use Exception;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class SectionDivider extends LayerInfoBase
{
    const SECTION_DIVIDER_TYPES = [
        'other',
        'open folder',
        'closed folder',
        'bounding section divider',
    ];

    const SUB_TYPE_NORMAL = 'normal';
    const SUB_TYPE_SCENE_GROUP = 'scene group';


    public function parseData(int $length): void
    {
        $code = $this->file->readInt();

        if (!isset(static::SECTION_DIVIDER_TYPES[$code])) {
            throw new Exception(sprintf('SectionDivider error. Wrong code: %s', $code));
        }

        $layerType = static::SECTION_DIVIDER_TYPES[$code];

        $isFolder = ($code === 1 || $code === 2);
        $isHidden = ($code === 3);
        $blendMode = '';
        $subType = '';

        if ($length >= 12) {
            $this->file->ffseek(4, true);
            $blendMode = $this->file->readString(4);

            if ($length >= 16) {
                $subType = ($this->file->readInt() === 0) ? static::SUB_TYPE_NORMAL : static::SUB_TYPE_SCENE_GROUP;
            }
        }

        $this->data = [
            'isFolder' => $isFolder,
            'isHidden' => $isHidden,
            'layerType' => $layerType,
            'blendMode' => $blendMode,
            'subType' => $subType
        ];
    }

    public function export()
    {
        return $this->getData();
    }
}
