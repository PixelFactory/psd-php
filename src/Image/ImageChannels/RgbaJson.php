<?php

namespace Psd\Image\ImageChannels;

final class RgbaJson
{
    protected const JSON_TEMPLATE_LENGTH = 30;
    protected const JSON_COLOR_LENGTH = 3;
    protected const JSON_COLOR_COUNT = 4;

    protected const JSON_PIXEL_DATA_LENGTH = self::JSON_TEMPLATE_LENGTH + (self::JSON_COLOR_LENGTH * self::JSON_COLOR_COUNT);

    protected string $pixelData = '[';

    /**
     * @return string
     */
    public function getPixelData(): string
    {
        return substr($this->pixelData, 0, -1).']';
    }

    /**
     * @param string $r
     * @param string $g
     * @param string $b
     * @param string $a
     * @return $this
     */
    public function addRgba(string $r, string $g, string $b, string $a): self
    {
        $pixelData = '{"r":"'.$r.'","g":"'.$g.'","b":"'.$b.'","a":"'.$a.'"},';

        if (strlen($pixelData) !== static::JSON_PIXEL_DATA_LENGTH) {
            throw new Exception(sprintf(
                'Wrong rgba format. %s',
                $this->getInfoAboutColor(compact('r', 'g', 'b', 'a'))
            ));
        }

        $this->pixelData .= $pixelData;

        return $this;
    }

    /**
     * @param array $rgbaColors
     * @return string
     */
    protected function getInfoAboutColor(array $rgbaColors): string
    {
        foreach ($rgbaColors as $colorName => $colorValue) {
            if (strlen($colorValue) !== static::JSON_COLOR_LENGTH) {
                return $this->getColorMessage($colorName, $colorValue);
            }
        }

        return 'Color not found. Something went wrong.';
    }

    /**
     * @param $colorName
     * @param $colorValue
     * @return string
     */
    protected function getColorMessage($colorName, $colorValue): string
    {
        return sprintf(
            'Color "%s" too short. Length: "%s" !== "%s". Value: "%s"',
            $colorName,
            strlen($colorValue),
            static::JSON_COLOR_LENGTH,
            $colorValue
        );
    }
}
