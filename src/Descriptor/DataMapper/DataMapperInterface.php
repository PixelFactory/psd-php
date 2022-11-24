<?php

namespace Psd\Descriptor\DataMapper;

use Psd\Descriptor\Data\ClassData;
use Psd\Descriptor\Data\EnumData;
use Psd\Descriptor\Data\EnumReferenceData;
use Psd\Descriptor\Data\FilePathData;
use Psd\Descriptor\Data\FloatPointNumberData;
use Psd\Descriptor\Data\PropertyData;

interface DataMapperInterface
{
    public function parseAlias(): string;
    public function parseBoolean(): bool;
    public function parseDouble(): float;
    public function parseFilePath(): FilePathData;
    public function parseUnitDouble(): FloatPointNumberData;
    public function parseUnitFloat(): FloatPointNumberData;
    public function parseId(): string;
    public function parseIndex(): int;
    public function parseOffset(): int;
    public function parseIdentifier(): int;
    public function parseInteger(): int;
    public function parseLargeInteger(): int;
    public function parseObjectArray(): void;
    public function parseRawData(): string;
    public function parseClass(): ClassData;
    public function parseEnum(): EnumData;
    public function parseEnumReference(): EnumReferenceData;
    public function parseProperty(): PropertyData;
    public function parseText(): string;
    public function parseItemType(): string;
    public function parseType(): string;
}
