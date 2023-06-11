<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\SolidColor;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class SolidColor extends LayerInfoBase
{
    /**
     * Space after each value need because keys have 4 chars.
     */
    const DATA_KEY_RED = 'Rd  ';
    const DATA_KEY_GREEN = 'Grn ';
    const DATA_KEY_BLUE = 'Bl  ';

    const DATA_KEY_CLR = 'Clr ';


    protected function parseData(int $length): void
    {
        $this->file->ffseek(4, true);
        $this->data = $this->descriptor->parse();
    }

    public function export(): array
    {
        return [
            'r' => round($this->getColorObject()['data'][self::DATA_KEY_RED]),
            'g' => round($this->getColorObject()['data'][self::DATA_KEY_GREEN]),
            'b' => round($this->getColorObject()['data'][self::DATA_KEY_BLUE]),
        ];
    }

    protected function getColorObject(): array
    {
        return $this->getData()['data'][self::DATA_KEY_CLR];
    }
}
