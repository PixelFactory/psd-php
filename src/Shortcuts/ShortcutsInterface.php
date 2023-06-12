<?php

namespace Psd\Shortcuts;

use Psd\Node\Node;
use Psd\Node\NodeInterface;

interface ShortcutsInterface
{
    public function getWidth(): int;

    public function getHeight(): int;

    public function savePreview(string $fileName): bool;

    public function getTree(): NodeInterface;
}