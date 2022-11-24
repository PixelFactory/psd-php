<?php

namespace Psd\Node\Group;

class Group
{
    protected string $name;

    protected array $data = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addData($data): int
    {
        $this->data[] = $data;
        return count($this->data);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isFolder(): bool
    {
        return true;
    }
}
