<?php

namespace Psd\FileStructure\Resources\Resource\LayerComps;


use Exception;
use Psd\Descriptor\Descriptor;
use Psd\FileStructure\Resources\Resource\ResourceBase;

class LayerComps extends ResourceBase
{
    protected const KEY_NAME = 'Nm  ';
    protected const KEY_COMP_ID = 'compID';
    protected const KEY_CAPTURED_INFO = 'capturedInfo';

    /**
     * @throws Exception
     */
    public function parseResourceData(): void
    {
        $this->file->ffseek(4, true);
        $descriptorData = (new Descriptor($this->file))->parse();

        foreach ($descriptorData as $comp) {
            $this->data[] = (new LayerCompsData())
                ->setId($comp->getData()[static::KEY_COMP_ID])
                ->setName($comp->getData()[static::KEY_NAME])
                ->setCapturedInfo($comp->getData()[static::KEY_CAPTURED_INFO]);
        }
    }
}
