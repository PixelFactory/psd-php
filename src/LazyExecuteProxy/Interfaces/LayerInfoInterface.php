<?php

namespace Psd\LazyExecuteProxy\Interfaces;

interface LayerInfoInterface extends LazyExecuteInterface
{
    public function export();

    public function getData();
}
