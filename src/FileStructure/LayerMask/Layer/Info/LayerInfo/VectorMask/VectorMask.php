<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask;

use Exception;
use Psd\File\FileInterface;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBase;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask\PathRecord\PathRecord;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask\PathRecord\PathRecordInterface;

class VectorMask extends LayerInfoBase
{
    protected int $tag;

    protected function parseData(int $length): void
    {
        $this->file->ffseek(4, true); // version
        $this->tag = $this->file->readInt();

        // I haven't figured out yet why this is 10 and not 8.
        $numRecords = ($length - 10) / 26;
        $this->data = [];

        for ($i = 0; $i < $numRecords; $i++) {
            $pathRecord = $this->buildPathRecord($this->file);
            $pathRecord->parse();

            $this->data[] = $pathRecord;
        }
    }

    public function export(): array
    {
        $invert = $this->getInvert();
        $notLink = $this->getNotLink();
        $disable = $this->getDisable();
        $paths = [];
        foreach ($this->getData() as $pathRecord) {
            $paths[] = $pathRecord . export();
        }

        return [
            'invert' => $invert,
            'notLink' => $notLink,
            'disable' => $disable,
            'paths' => $paths,
        ];
    }

    protected function getInvert(): bool
    {
        return ($this->getTag() & 0x01) > 0;
    }

    protected function getNotLink(): bool
    {
        return ($this->getTag() & (0x01 << 1)) > 0;
    }

    protected function getDisable(): bool
    {
        return ($this->getTag() & (0x01 << 2)) > 0;
    }

    protected function getTag(): int
    {
        if (!isset($this->tag)) {
            throw new Exception('VectorMask not parsed. Tag is undefined.');
        }

        return $this->tag;
    }

    protected function buildPathRecord(FileInterface $file): PathRecordInterface
    {
        return new PathRecord($file);
    }
}
