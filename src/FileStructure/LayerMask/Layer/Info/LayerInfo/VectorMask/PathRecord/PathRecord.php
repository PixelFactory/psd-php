<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask\PathRecord;

use Exception;
use Psd\File\FileInterface;

class PathRecord implements PathRecordInterface
{
    protected FileInterface $file;

    protected $data;

    protected int $recordType;

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    public function parse(): void
    {
        $this->recordType = $this->file->readShort();

        if ($this->isPathRecord($this->recordType)) {
            $this->data = $this->parsePathRecord();
            return;
        }

        if ($this->isBezierPoint($this->recordType)) {
            $this->data = $this->parseBezierPoint(
                $this->isLinked($this->recordType),
            );

            return;
        }

        if ($this->isClipboardRecord($this->recordType)) {
            $this->data = $this->parseClipboardRecord();
            return;
        }

        if ($this->isInitialFill($this->recordType)) {
            $this->data = $this->parseInitialFill();
            return;
        }

        $this->file->ffseek(24, true);
    }

    public function export(): array
    {
        return [
            'recordType' => $this->getRecordType(),
            'data' => $this->getData(),
        ];
    }

    protected function getRecordType(): int
    {
        if (!isset($this->recordType)) {
            throw new Exception('PathRecord not parsed. RecordType is undefined.');
        }

        return $this->recordType;
    }

    protected function getData()
    {
        if (!isset($this->data)) {
            throw new Exception('PathRecord not parsed. Data is undefined.');
        }

        return $this->data;
    }

    protected function isPathRecord(int $recordType): bool
    {
        return $recordType === 0 || $recordType === 3;
    }

    protected function isBezierPoint(int $recordType): bool
    {
        return $recordType === 1 || $recordType === 2 || $recordType === 4 || $recordType === 5;
    }

    protected function isClipboardRecord(int $recordType): bool
    {
        return $recordType === 7;
    }

    protected function isInitialFill(int $recordType): bool
    {
        return $recordType === 8;
    }

    protected function isLinked(int $recordType): bool
    {
        return $recordType === 1 || $recordType === 4;
    }

    protected function parsePathRecord(): array
    {
        $numPoints = $this->file->readShort();
        $this->file->ffseek(22, true);

        return [
            'numPoints' => $numPoints,
        ];
    }

    protected function parseBezierPoint(bool $linked): array
    {
        $precedingVert = $this->file->readPathNumber();
        $precedingHoriz = $this->file->readPathNumber();

        $anchorVert = $this->file->readPathNumber();
        $anchorHoriz = $this->file->readPathNumber();

        $leavingVert = $this->file->readPathNumber();
        $leavingHoriz = $this->file->readPathNumber();

        return [
            'linked' => $linked,
            'precedingVert' => $precedingVert,
            'precedingHoriz' => $precedingHoriz,
            'anchorVert' => $anchorVert,
            'anchorHoriz' => $anchorHoriz,
            'leavingVert' => $leavingVert,
            'leavingHoriz' => $leavingHoriz,
        ];
    }

    protected function parseClipboardRecord(): array
    {
        $clipboardTop = $this->file->readPathNumber();
        $clipboardLeft = $this->file->readPathNumber();
        $clipboardBottom = $this->file->readPathNumber();
        $clipboardRight = $this->file->readPathNumber();
        $clipboardResolution = $this->file->readPathNumber();

        $this->file->ffseek(4, true);

        return [
            'clipboardTop' => $clipboardTop,
            'clipboardLeft' => $clipboardLeft,
            'clipboardBottom' => $clipboardBottom,
            'clipboardRight' => $clipboardRight,
            'clipboardResolution' => $clipboardResolution,
        ];
    }

    protected function parseInitialFill(): array
    {
        $initialFill = $this->file->readShort();
        $this->file->ffseek(22, true);

        return [
            'initialFill' => $initialFill,
        ];
    }
}
