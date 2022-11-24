<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo;

class LayerInfo
{
    protected LayerInfoBase $layerInfo;
    protected string $name;

    /**
     * @param LayerInfoBase $layerInfo
     * @return $this
     */
    public function setLayerInfo(LayerInfoBase $layerInfo): self
    {
        $this->layerInfo = $layerInfo;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return LayerInfoBase
     */
    public function getLayerInfo(): LayerInfoBase
    {
        return $this->layerInfo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
