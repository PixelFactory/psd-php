<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask\PathRecord;

interface PathRecordInterface
{
    public function parse(): void;

    public function export(): array;
}
