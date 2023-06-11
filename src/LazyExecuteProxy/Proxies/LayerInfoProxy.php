<?php

namespace Psd\LazyExecuteProxy\Proxies;

use Psd\LazyExecuteProxy\Interfaces\LayerInfoInterface;
use Psd\LazyExecuteProxy\LazyExecuteProxy;

class LayerInfoProxy extends LazyExecuteProxy implements LayerInfoInterface
{
    public function export()
    {
        $this->parse();
        return $this->obj->export();
    }

    public function getData()
    {
        $this->parse();
        return $this->obj->getData();
    }
}
