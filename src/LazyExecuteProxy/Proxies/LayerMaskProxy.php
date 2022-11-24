<?php

namespace Psd\LazyExecuteProxy\Proxies;

use Psd\FileStructure\LayerMask\Data\GlobalMask;
use Psd\LazyExecuteProxy\Interfaces\LayerMaskInterface;
use Psd\LazyExecuteProxy\LazyExecuteProxy;

class LayerMaskProxy extends LazyExecuteProxy implements LayerMaskInterface {
    public function getLayers(): array
    {
        $this->parse();
        return $this->obj->getLayers();
    }

    public function getGlobalMask(): GlobalMask
    {
        $this->parse();
        return $this->obj->getGlobalMask();
    }
}
