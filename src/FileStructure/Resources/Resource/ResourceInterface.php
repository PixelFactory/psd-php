<?php

namespace Psd\FileStructure\Resources\Resource;

interface ResourceInterface
{
    public function parse(): ResourceBase;
}
