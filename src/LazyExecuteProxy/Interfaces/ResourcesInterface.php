<?php

namespace Psd\LazyExecuteProxy\Interfaces;

interface ResourcesInterface extends LazyExecuteInterface
{
    public function getResources(): array;

    public function getResource($search);

    public function getResourceByName(string $name);

    public function getResourceById($id);
}
