<?php

namespace Psd\FileStructure\Resources\Resource\ResolutionInfo;

class ResolutionInfoData{
    protected int $hRes;
    protected int $hResUnit;
    protected int $widthUnit;
    protected int $vRes;
    protected int $vResUnit;
    protected int $heightUnit;

    /**
     * @param int $hRes
     * @return $this
     */
    public function setHRes(int $hRes): self
    {
        $this->hRes = $hRes;
        return $this;
    }

    /**
     * @param int $hResUnit
     * @return $this
     */
    public function setHResUnit(int $hResUnit): self
    {
        $this->hResUnit = $hResUnit;
        return $this;
    }

    /**
     * @param int $widthUnit
     * @return $this
     */
    public function setWidthUnit(int $widthUnit): self
    {
        $this->widthUnit = $widthUnit;
        return $this;
    }

    /**
     * @param int $vRes
     * @return $this
     */
    public function setVRes(int $vRes): self
    {
        $this->vRes = $vRes;
        return $this;
    }

    /**
     * @param int $vResUnit
     * @return $this
     */
    public function setVResUnit(int $vResUnit): self
    {
        $this->vResUnit = $vResUnit;
        return $this;
    }

    /**
     * @param int $heightUnit
     * @return $this
     */
    public function setHeightUnit(int $heightUnit): self
    {
        $this->heightUnit = $heightUnit;
        return $this;
    }

    /**
     * @return int
     */
    public function getHRes(): int
    {
        return $this->hRes;
    }

    /**
     * @return int
     */
    public function getHResUnit(): int
    {
        return $this->hResUnit;
    }

    /**
     * @return int
     */
    public function getWidthUnit(): int
    {
        return $this->widthUnit;
    }

    /**
     * @return int
     */
    public function getVRes(): int
    {
        return $this->vRes;
    }

    /**
     * @return int
     */
    public function getVResUnit(): int
    {
        return $this->vResUnit;
    }

    /**
     * @return int
     */
    public function getHeightUnit(): int
    {
        return $this->heightUnit;
    }
}