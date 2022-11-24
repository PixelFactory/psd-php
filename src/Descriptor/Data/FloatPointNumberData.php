<?php


namespace Psd\Descriptor\Data;

class FloatPointNumberData
{
    const FLOAT_POINT_NUMBER_FORMAT = [
        'Angle' => '#Ang',
        'Density'  => '#Rsl',
        'Distance'  => '#Rlt',
        'None'  => '#Nne',
        'Percent'  => '#Prc',
        'Pixels'  => '#Pxl',
        'Millimeters' => '#Mlm',
        'Points'  => '#Pnt',
    ];

    protected string $id;
    protected string $unit;
    protected float $value;

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $unit
     * @return $this
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}