<?php

namespace Psd\FileStructure\Resources\Resource\LayerComps;

class LayerCompsData
{
    protected $id;
    protected $name;
    protected $capturedInfo;

    /**
     * @param $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $capturedInfo
     * @return $this
     */
    public function setCapturedInfo($capturedInfo): self
    {
        $this->capturedInfo = $capturedInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCapturedInfo()
    {
        return $this->capturedInfo;
    }
}