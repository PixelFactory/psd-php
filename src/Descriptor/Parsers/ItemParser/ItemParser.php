<?php

namespace Psd\Descriptor\Parsers\ItemParser;

use Psd\Descriptor\DataMapper\DataMapperInterface;
use Psd\Descriptor\Parsers\ReferenceParser\ReferenceParserInterface;
use Exception;

class ItemParser implements ItemParserInterface
{

    protected DataMapperInterface $dataMapper;

    protected ReferenceParserInterface $referenceParser;

    public function __construct(DataMapperInterface $dataMapper, ReferenceParserInterface $referenceParser)
    {
        $this->dataMapper = $dataMapper;
        $this->referenceParser = $referenceParser;
    }

    public function parse(string $parseType)
    {
        if ($parseType === static::ITEM_TYPE_BOOL) {
            return $this->dataMapper->parseBoolean();
        }
        if ($parseType === static::ITEM_TYPE_DOUB) {
            return $this->dataMapper->parseDouble();
        }
        if ($parseType === static::ITEM_TYPE_ENUM) {
            return $this->dataMapper->parseEnum();
        }
        if ($parseType === static::ITEM_TYPE_ALIS) {
            return $this->dataMapper->parseAlias();
        }
        if ($parseType === static::ITEM_TYPE_PTH) {
            return $this->dataMapper->parseFilePath();
        }
        if ($parseType === static::ITEM_TYPE_LONG) {
            return $this->dataMapper->parseInteger();
        }
        if ($parseType === static::ITEM_TYPE_COMP) {
            return $this->dataMapper->parseLargeInteger();
        }
        if ($parseType === static::ITEM_TYPE_OBAR) {
            return $this->dataMapper->parseObjectArray();
        }
        if ($parseType === static::ITEM_TYPE_TDTA) {
            return $this->dataMapper->parseRawData();
        }
        if ($parseType === static::ITEM_TYPE_OBJ) {
            return $this->referenceParser->parse();
        }
        if ($parseType === static::ITEM_TYPE_TEXT) {
            return $this->dataMapper->parseText();
        }
        if ($parseType === static::ITEM_TYPE_UNTF) {
            return $this->dataMapper->parseUnitDouble();
        }
        if ($parseType === static::ITEM_TYPE_UNFL) {
            return $this->dataMapper->parseUnitFloat();
        }
        if ($parseType === static::ITEM_TYPE_TYPE || $parseType === static::ITEM_TYPE_GLBC) {
            return $this->dataMapper->parseClass();
        }

        throw new Exception(sprintf('Error parseType: %s', $parseType));
    }
}
