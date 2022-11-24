<?php

namespace Psd\LazyExecuteProxy;

use Psd\File\FileInterface;
use Psd\LazyExecuteProxy\Interfaces\LazyExecuteInterface;

abstract class LazyExecuteProxy
{
    protected LazyExecuteInterface $obj;

    private FileInterface $file;

    private int $startPos;

    private bool $parsed;

    public function __construct(LazyExecuteInterface $obj, FileInterface $file)
    {
        $this->obj = $obj;
        $this->file = $file;

        // Save start position
        $this->startPos = $this->file->tell();
        // Skip parsing
        $this->obj->skip();
        $this->parsed = false;
    }

    public function parse(): void
    {
        if ($this->parsed) {
            return;
        }

        $origPos = $this->file->tell();
        $this->file->ffseek($this->startPos);

        $this->obj->parse();

        $this->file->ffseek($origPos);
        $this->parsed = true;
    }

    public function skip(): void
    {
        $this->obj->skip();
    }
}
