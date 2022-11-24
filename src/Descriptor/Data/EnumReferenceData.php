<?php

namespace Psd\Descriptor\Data;

class EnumReferenceData {
  protected ClassData $classData;
  protected string $type;
  protected string $value;

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
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
