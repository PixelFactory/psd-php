<?php


namespace Psd\Descriptor\Data;


class DescriptorData {
  protected ClassData $classData;

  protected array $data;

    /**
     * @param $classData
     * @return $this
     */
    public function setClassData($classData): self
    {
        $this->classData = $classData;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function addData(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getClassData()
    {
        return $this->classData;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
