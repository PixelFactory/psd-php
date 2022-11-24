<?php

namespace Psd\LazyExecuteProxy\Interfaces;

use Psd\FileStructure\LayerMask\Data\GlobalMask;

interface LayerMaskInterface extends LazyExecuteInterface {
    public function getLayers(): array;
    public function getGlobalMask(): GlobalMask;
}
