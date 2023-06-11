<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\Artboard;

use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;

class Artboard extends LayerInfoBase
{
    /**
     * This $have rect keys.
     * Space after 'Top' need because keys have 4 chars.
     * Data for real file:
     *   'Top ': 0,
     *   Left: 0,
     *   Btom: 10,
     *   Rght: 10
     */
    const RECT_KEY_LEFT = 'Left';
    const RECT_KEY_TOP = 'Top ';
    const RECT_KEY_RIGHT = 'Rght';
    const RECT_KEY_BOTTOM = 'Btom';

    protected function parseData(int $length): void
    {
        $this->file->ffseek(4, true);
        $this->data = $this->descriptor->parse();
    }

    public function export()
    {
        return [
            'coords' => [
                'left' => $this->getArtboardRectData()['data'][static::RECT_KEY_LEFT],
                'top' => $this->getArtboardRectData()['data'][static::RECT_KEY_TOP],
                'right' => $this->getArtboardRectData()['data'][static::RECT_KEY_RIGHT],
                'bottom' => $this->getArtboardRectData()['data'][static::RECT_KEY_BOTTOM],
            ]
        ];
    }

    protected function getArtboardRectData(): array
    {
        return $this->getData()['data']['artboardRect'];
    }
}
