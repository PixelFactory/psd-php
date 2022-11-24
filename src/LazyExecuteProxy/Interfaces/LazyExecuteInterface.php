<?php

namespace Psd\LazyExecuteProxy\Interfaces;

interface LazyExecuteInterface {
    public function parse(): void;
    public function skip(): void;
}
