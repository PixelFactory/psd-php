<?php


namespace Psd\Descriptor\Data;


class PropertyData {
    protected ClassData $classData;
    protected string $id;

    /**
     * @param ClassData $classData
     * @return $this
     */
    public function setClassData(ClassData $classData): self
    {
        $this->classData = $classData;
        return $this;
    }

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
     * @return ClassData
     */
    public function getClassData(): ClassData
    {
        return $this->classData;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
