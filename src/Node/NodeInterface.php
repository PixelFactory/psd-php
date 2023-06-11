<?php

namespace Psd\Node;

use Psd\FileStructure\LayerMask\Layer\LayerInterface;
use Psd\Node\Group\Group;

interface NodeInterface
{
    public function getNode(): Group;

    public function addValue(LayerInterface $value): void;

    public function addNode(string $name): void;

    public function parentNode(): void;
}
