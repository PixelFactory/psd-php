<?php

namespace Psd\Descriptor\Parsers\ReferenceParser;

use Exception;
use Psd\Descriptor\Data\ReferenceData;
use Psd\Descriptor\DataMapper\DataMapperInterface;

class ReferenceParser implements ReferenceParserInterface
{
    protected DataMapperInterface $dataMapper;

    public function __construct(DataMapperInterface $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * @throws Exception
     */
    public function parse(): array
    {
        $numItems = $this->dataMapper->parseInteger();
        $items = [];

        for ($i = 0; $i < $numItems; $i++) {
            $type = $this->dataMapper->parseType();

            if ($type === static::REFERENCE_TYPE_PROP) {
                $value = $this->dataMapper->parseProperty();
            } else if ($type === static::REFERENCE_TYPE_CLSS) {
                $value = $this->dataMapper->parseClass();
            } else if ($type === static::REFERENCE_TYPE_ENMR) {
                $value = $this->dataMapper->parseEnumReference();
            } else if ($type === static::REFERENCE_TYPE_IDNT) {
                $value = $this->dataMapper->parseIdentifier();
            } else if ($type === static::REFERENCE_TYPE_INDX) {
                $value = $this->dataMapper->parseIndex();
            } else if ($type === static::REFERENCE_TYPE_NAME) {
                $value = $this->dataMapper->parseText();
            } else if ($type === static::REFERENCE_TYPE_RELE) {
                $value = $this->dataMapper->parseOffset();
            } else {
                throw new Exception('Wrong reference type.');
            }

            $items[] = (new ReferenceData())->setType($type)->setValue($value);
        }

        return $items;
    }
}