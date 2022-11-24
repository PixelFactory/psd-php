<?php

namespace Psd\FileStructure\LayerMask\Layer\Info;

interface InfoInterface {
    public function parse(int $layerEnd): void;
    public function getDataInfo(string $name);
    public function getData();
    public function getInfoKeys(): array;
}
