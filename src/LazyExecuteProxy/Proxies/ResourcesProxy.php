<?php

namespace Psd\LazyExecuteProxy\Proxies;

use Psd\LazyExecuteProxy\Interfaces\ResourcesInterface;
use Psd\LazyExecuteProxy\LazyExecuteProxy;

class ResourcesProxy extends LazyExecuteProxy implements ResourcesInterface
{
    public function getResources(): array
    {
        $this->parse();
        return $this->obj->getResources();
    }

    public function getResource($search)
    {
        $this->parse();
        return $this->obj->getResource($search);
    }

    public function getResourceByName(string $name)
    {
        $this->parse();
        return $this->obj->getResourceByName($name);
    }

    public function getResourceById($id)
    {
        $this->parse();
        return $this->obj->getResourceById($id);
    }
}
