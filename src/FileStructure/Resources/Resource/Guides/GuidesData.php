<?php

namespace Psd\FileStructure\Resources\Resource\Guides;

class GuidesData {
  protected int $location;
  protected string $direction;

    /**
     * @param int $location
     * @return $this
     */
    public function setLocation(int $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @param string $direction
     * @return $this
     */
    public function setDirection(string $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * @return int
     */
    public function getLocation(): int
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
