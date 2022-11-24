<?php

namespace Psd\FileStructure\Header;

interface HeaderInterface {
    const HEADER_MODE_KEY_BITMAP = 0;
    const HEADER_MODE_KEY_GRAY_SCALE = 1;
    const HEADER_MODE_KEY_INDEXED_COLOR = 2;
    const HEADER_MODE_KEY_RGB_COLOR = 3;
    const HEADER_MODE_KEY_CMYK_COLOR = 4;
    const HEADER_MODE_KEY_HSL_COLOR = 5;
    const HEADER_MODE_KEY_HSB_COLOR = 6;
    const HEADER_MODE_KEY_MULTICHANNEL = 7;
    const HEADER_MODE_KEY_DUOTONE = 8;
    const HEADER_MODE_KEY_LAB_COLOR = 9;
    const HEADER_MODE_KEY_GRAY16 = 10;
    const HEADER_MODE_KEY_RGB48 = 11;
    const HEADER_MODE_KEY_LAB48 = 12;
    const HEADER_MODE_KEY_CMYK64 = 13;
    const HEADER_MODE_KEY_DEEP_MULTICHANNEL = 14;
    const HEADER_MODE_KEY_DUOTONE16 = 15;

    const HEADER_MODE = [
        self::HEADER_MODE_KEY_BITMAP => 'Bitmap',
        self::HEADER_MODE_KEY_GRAY_SCALE => 'GrayScale',
        self::HEADER_MODE_KEY_INDEXED_COLOR => 'IndexedColor',
        self::HEADER_MODE_KEY_RGB_COLOR => 'RGBColor',
        self::HEADER_MODE_KEY_CMYK_COLOR => 'CMYKColor',
        self::HEADER_MODE_KEY_HSL_COLOR => 'HSLColor',
        self::HEADER_MODE_KEY_HSB_COLOR => 'HSBColor',
        self::HEADER_MODE_KEY_MULTICHANNEL => 'Multichannel',
        self::HEADER_MODE_KEY_DUOTONE => 'Duotone',
        self::HEADER_MODE_KEY_LAB_COLOR => 'LabColor',
        self::HEADER_MODE_KEY_GRAY16 => 'Gray16',
        self::HEADER_MODE_KEY_RGB48 => 'RGB48',
        self::HEADER_MODE_KEY_LAB48 => 'Lab48',
        self::HEADER_MODE_KEY_CMYK64 => 'CMYK64',
        self::HEADER_MODE_KEY_DEEP_MULTICHANNEL => 'DeepMultichannel',
        self::HEADER_MODE_KEY_DUOTONE16 => 'Duotone16',
    ];

    public function parse(): void;
    public function modeName(): string;
    public function getVersion(): int;
    public function getChannels(): int;
    public function getDepth(): int;
    public function getMode(): int;
    public function getRows(): int;
    public function getCols(): int;
    public function getHeight(): int;
    public function getWidth(): int;
    public function getNumPixels(): int;
    public function getChannelLength(int $width = null, int $height = null): int;
    public function getFileLength(): int;
}
