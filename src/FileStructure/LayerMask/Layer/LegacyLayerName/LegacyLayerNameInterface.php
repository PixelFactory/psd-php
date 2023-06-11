<?php

namespace Psd\FileStructure\LayerMask\Layer\LegacyLayerName;

interface LegacyLayerNameInterface
{
    public function parse(): void;

    public function getLegacyName(): string;
}
