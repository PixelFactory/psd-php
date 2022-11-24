<?php

namespace Psd\FileStructure\Resources\Resource\Guides;

use Psd\FileStructure\Resources\Resource\ResourceBase;
use Psd\Helper;

class Guides extends ResourceBase
{
    const DIRECTION_HORIZONTAL = 'horizontal';
    const DIRECTION_VERTICAL = 'vertical';

    public function parseResourceData(): void
    {
        // Descriptor version
        $this->file->ffseek(4, true);

        // Future implementation of document-specific grids
        $this->file->ffseek(8, true);

        $numGuides = $this->file->readInt();
        $this->data = [];

        for ($i = 0; $i < $numGuides; $i += 1) {
            $location = Helper::fixed($this->file->readInt() / 32, 1);
            $direction = $this->file->readByte() ? static::DIRECTION_HORIZONTAL : static::DIRECTION_VERTICAL;

            $this->data[] = (new GuidesData())->setLocation($location)->setDirection($direction);
        }
    }
}
