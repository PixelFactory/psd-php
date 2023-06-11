<?php


namespace Psd\Descriptor\Data;


class FilePathData
{
    protected string $sig;
    protected string $path;

    /**
     * @param string $sig
     * @return $this
     */
    public function setSig(string $sig): self
    {
        $this->sig = $sig;
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getSig(): string
    {
        return $this->sig;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
