<?php

namespace Psd\Node;

use Psd\Node\Group\Group;
use Psd\Node\Layer\Layer;

class Node implements NodeInterface
{
    protected Group $data;

    protected array $path = [];

    protected function __construct()
    {
        $this->data = new Group('root');
    }

    static public function build(array $data): NodeInterface
    {
        $nodeData = new self();

        for ($i = 0; $i < count($data); $i++) {
            $layer = $data[$i];

            if ($layer->isFolder()) {
                $nodeData->addNode($layer->getName());
            } else if ($layer->isFolderEnd()) {
                $nodeData->parentNode();
            } else {
                $nodeData->addValue(new Layer(
                    $layer->getName(),
                    $layer->getPosition()->top,
                    $layer->getPosition()->right,
                    $layer->getPosition()->bottom,
                    $layer->getPosition()->left,
                    $layer->getPosition()->width,
                    $layer->getPosition()->height,
                    $layer,
                ));
            }
        }

        return $nodeData;
    }

    public function getNode(): Group
    {
        return $this->data;
    }

    public function addNode(string $name): void
    {
        $node = $this->getNodeByPath();

        $keyData = $node->addData(new Group($name));

        $this->path[] = ($keyData - 1);
    }

    public function parentNode(): void
    {
        array_pop($this->path);
    }

    public function addValue($value): void
    {
        $node = $this->getNodeByPath();

        $node->addData($value);
    }

    protected function &getNodeByPath(): Group
    {
        $temp = &$this->data;

        foreach ($this->path as $key) {
            $temp = &$temp->getData()[$key];
        }

        return $temp;
    }
}
