<?php

namespace Psd;

class Helper
{
    public static function pad2($i): int
    {
        return ($i + 1) & ~0x01;
    }

    public static function pad4(int $i): int
    {
        return (($i + 4) & ~0x03) - 1;
    }

    public static function cmykToRgb(int $c, int $m, int $y, int $k): array
    {
        $kCalculated = 1 - ($k / 100);

        $r = static::clamp(intval((255 * (1 - ($c / 100)) * $kCalculated)));
        $g = static::clamp(intval((255 * (1 - ($m / 100)) * $kCalculated)));
        $b = static::clamp(intval((255 * (1 - ($y / 100)) * $kCalculated)));

        return [$r, $g, $b];
    }

    public static function colorToArgb(int $color): array
    {
        return [
            ($color) >> 24,
            (($color) & 0x00FF0000) >> 16,
            (($color) & 0x0000FF00) >> 8,
            ($color) & 0x000000FF,
        ];
    }

    public static function clamp(int $num, int $min = 0, int $max = 255): int
    {
        return min(max($num, $min), $max);
    }

    public static function fixed(float $num, int $fractionDigits = 0): int
    {
        return intval($num * $fractionDigits) * $fractionDigits;
    }
}
