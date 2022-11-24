<?php

namespace Psd\FileStructure\Header;

use Psd\File\FileInterface;
use Exception;

class Header implements HeaderInterface
{
    private int $version;

    private int $channels;

    private int $rows;

    private int $cols;

    private int $depth;

    protected int $mode;

    protected FileInterface $file;

    protected const FILE_SIGNATURE = '8BPS';

    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    public function parse(): void
    {
        if ($this->file->tell() !== 0) {
            throw new Exception('Wrong file position');
        }

        $this->readSignature();
        $this->version = $this->file->readUShort();

        $this->file->ffseek(6, true);

        $this->channels = $this->file->readUShort();
        $this->rows = $this->file->readUInt();
        $this->cols = $this->file->readUInt();
        $this->depth = $this->file->readUShort();
        $this->mode = $this->file->readUShort();

        $colorDataLen = $this->file->readUInt();
        $this->file->ffseek($colorDataLen, true);
    }

    public function modeName(): string
    {
        if (!isset($this->mode)) {
            throw new Exception('Header not parsed. Mode is undefined.');
        }

        return static::HEADER_MODE[$this->mode];
    }

    public function getVersion(): int
    {
        if (!isset($this->version)) {
            throw new Exception('Header not parsed. Version is undefined.');
        }

        return $this->version;
    }

    public function getChannels(): int
    {
        if (!isset($this->channels)) {
            throw new Exception('Header not parsed. Channels is undefined.');
        }

        return $this->channels;
    }

    public function getDepth(): int
    {
        if (!isset($this->depth)) {
            throw new Exception('Header not parsed. Depth is undefined.');
        }

        return $this->depth;
    }

    public function getMode(): int
    {
        if (!isset($this->mode)) {
            throw new Exception('Header not parsed. Mode is undefined.');
        }

        return $this->mode;
    }

    public function getRows(): int
    {
        if (!isset($this->rows)) {
            throw new Exception('Header not parsed. Rows is undefined.');
        }

        return $this->rows;
    }

    public function getCols(): int
    {
        if (!isset($this->cols)) {
            throw new Exception('Header not parsed. Cols is undefined.');
        }

        return $this->cols;
    }

    public function getHeight(): int
    {
        return $this->getRows();
    }

    public function getWidth(): int
    {
        return $this->getCols();
    }

    public function getNumPixels(): int
    {
        $pixels = $this->getWidth() * $this->getHeight();

        if ($this->getDepth() === 16) {
            $pixels *= 2;
        }

        return $pixels;
    }

    public function getChannelLength(int $width = null, int $height = null): int
    {
        $widthData = $width ?? $this->getWidth();
        $heightData = $height ?? $this->getHeight();

        switch ($this->getDepth()) {
            case 1:
                return (($widthData + 7) / 8) * $heightData;
            case 16:
                return $widthData * $heightData * 2;
            default:
                return $widthData * $heightData;
        }
    }

    public function getFileLength(): int
    {
        return $this->getChannelLength() * $this->getChannels();
    }

    protected function readSignature(): void
    {
        $sig = $this->file->readString(4);

        if ($sig !== static::FILE_SIGNATURE) {
            throw new Exception(sprintf('Invalid file signature detected. Got: %s. Expected 8BPS.', $sig));
        }
    }
}
