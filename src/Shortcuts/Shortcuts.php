<?php

namespace Psd\Shortcuts;

use Psd\Node\Node;
use Psd\Node\NodeInterface;
use Psd\Psd;

class Shortcuts implements ShortcutsInterface
{
    protected Psd $psd;

    public function __construct(Psd $psd)
    {
        $this->psd = $psd;
    }

    public function getWidth(): int
    {
        return $this->psd->getHeader()->getWidth();
    }

    public function getHeight(): int
    {
        return $this->psd->getHeader()->getHeight();
    }

    public function savePreview(string $fileName): bool
    {
        return $this->psd->getImage()->getExporter(\Psd\Image\ImageExport\ImageExport::EXPORT_FORMAT_PNG)->save($fileName);
    }

    public function getTree(): NodeInterface
    {
        if (!isset($this->node)) {
            $this->node = $this->buildNode($this->psd->getLayers());
        }

        return $this->node;
    }

    protected function buildNode(array $layers): NodeInterface
    {
        return Node::build($layers);
    }
}