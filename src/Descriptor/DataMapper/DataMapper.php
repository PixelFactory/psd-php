<?php

namespace Psd\Descriptor\DataMapper;

use Psd\Descriptor\Data\ClassData;
use Psd\Descriptor\Data\EnumData;
use Psd\Descriptor\Data\EnumReferenceData;
use Psd\Descriptor\Data\FilePathData;
use Psd\Descriptor\Data\FloatPointNumberData;
use Psd\Descriptor\Data\PropertyData;
use Psd\Descriptor\Parsers\ItemParser\ItemParserInterface;
use Psd\File\FileInterface;
use Exception;

class DataMapper implements DataMapperInterface {
  protected FileInterface $file;

  public function __construct(FileInterface $file) {
    $this->file = $file;
  }

  public function parseAlias(): string {
    $len = $this->file->readInt();
    return $this->file->readString($len);
  }

public function parseBoolean(): bool {
    return $this->file->readBoolean();
  }

    public function parseDouble(): float {
    return $this->file->readDouble();
  }

    public function parseFilePath(): FilePathData {
    $finish = $this->file->readInt() + $this->file->tell();
    $sig = $this->file->readString(4);

    // Little endian. Who knows.
    $this->file->readIntLE(); // Path size
    $numChars = $this->file->readIntLE();

    $path = $this->file->readUnicodeString($numChars);

    if ($this->file->tell() !== $finish) {
      throw new Exception('Fail read data.');
    }

    return (new FilePathData())->setSig($sig)->setPath($path);
  }

    public function parseUnitDouble(): FloatPointNumberData {
    $unitId = $this->file->readString(4);

    $unit = array_search($unitId, FloatPointNumberData::FLOAT_POINT_NUMBER_FORMAT);

    if ($unit === false) {
      throw new Exception('Wrong double point number format. UnitId: \'%s\'', $unitId);
    }

    $value = $this->file->readDouble();

    return (new FloatPointNumberData())->setId($unitId)->setUnit($unit)->setValue($value);
  }

    public function parseUnitFloat(): FloatPointNumberData {
    $unitId = $this->file->readString(4);

    $unit = array_search($unitId, FloatPointNumberData::FLOAT_POINT_NUMBER_FORMAT);

    if ($unit === false) {
        throw new Exception('Wrong double point number format. UnitId: \'%s\'', $unitId);
    }

    $value = $this->file->readFloat();

    return (new FloatPointNumberData())->setId($unitId)->setUnit($unit)->setValue($value);
  }

    public function parseId(): string {
    $len = $this->file->readInt();

    if ($len === 0) {
      return $this->file->readString(4);
    }

    return $this->file->readString($len);
  }

public function parseIndex(): int {
    return $this->parseInteger();
  }

    public function parseOffset(): int {
    return $this->parseInteger();
  }

    public function parseIdentifier(): int {
    return $this->parseInteger();
  }

    public function parseInteger(): int {
    return $this->file->readInt();
  }

    public function parseLargeInteger(): int {
    return $this->file->readLongLong();
  }

    public function parseObjectArray(): void {
    throw new Exception(sprintf('Descriptor object array not implemented yet. %s', $this->file->tell()));
  }

    public function parseRawData(): string {
    $len = $this->file->readInt();
    return $this->file->read($len);
  }

    public function parseClass(): ClassData {
      $name = $this->file->readUnicodeString();
      $id = $this->parseId();

      return (new ClassData())->setName($name)->setId($id);
  }

    public function parseEnum(): EnumData {
        $type = $this->parseId();
        $value = $this->parseId();

      return (new EnumData())->setType($type)->setValue($value);
  }

    public function parseEnumReference(): EnumReferenceData {
    $classData = $this->parseClass();
      $type = $this->parseId();
      $value = $this->parseId();

    return (new EnumReferenceData())->setClassData($classData)->setType($type)->setValue($value);
  }

    public function parseProperty(): PropertyData {
        $classData = $this->parseClass();
      $id = $this->parseId();

    return (new PropertyData())->setClassData($classData)->setId($id);
  }

    public function parseText(): string {
    return $this->file->readUnicodeString();
  }

    public function parseItemType(): string {
    $type = $this->file->readString(4);

    if (!isset(ItemParserInterface::ITEM_TYPES[$type])) {
      throw new Exception(sprintf('Type format not supported. Type: %s', $type));
    }

    return $type;
  }

  public function parseType(): string {
    return $this->file->readString(4);
  }
}
