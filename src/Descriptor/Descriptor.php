<?php

namespace Psd\Descriptor;

use Psd\Descriptor\Data\DescriptorData;
use Psd\Descriptor\DataMapper\DataMapper;
use Psd\Descriptor\DataMapper\DataMapperInterface;
use Psd\Descriptor\Parsers\ItemParser\ItemParser;
use Psd\Descriptor\Parsers\ItemParser\ItemParserInterface;
use Psd\Descriptor\Parsers\ReferenceParser\ReferenceParser;
use Psd\File\FileInterface;
use Exception;

class Descriptor implements DescriptorInterface {
  private FileInterface $file;

  private DataMapperInterface $dataMapper;

  private ItemParserInterface $itemParser;

  public function __construct(FileInterface $file) {
    $this->file = $file;

    $this->dataMapper = new DataMapper($this->file);
    $this->itemParser = new ItemParser(
        $this->dataMapper,
        new ReferenceParser($this->dataMapper),
    );
  }

  /**
   * Parses the Descriptor at the current location in the file.
   */
  public function parse(): DescriptorData {
    $descriptor = (new DescriptorData())
        ->setClassData($this->dataMapper->parseClass())
        ->setData([]);

    $numItems = $this->file->readInt();

    /**
     * Each item consists of a key/value combination, which is why our
     * descriptor is stored as an object instead of an array at the root.
     */
    for ($i = 0; $i < $numItems; $i += 1) {
      $id = $this->dataMapper->parseId();
      $type = $this->dataMapper->parseItemType();

      if ($type === ItemParserInterface::ITEM_TYPE_VLLS) {
          $descriptor->addData($id, $this->parseItems());
      } else if ($type === ItemParserInterface::ITEM_TYPE_OBJC || $type === ItemParserInterface::ITEM_TYPE_GLBO) {
          $descriptor->addData($id, (new Descriptor($this->file))->parse());
      } else {
          $descriptor->addData($id, $this->itemParser->parse($type));
      }
    }

    return $descriptor;
  }

  protected function parseItems(): array {
    $count = $this->dataMapper->parseInteger();
    $items = [];

    for ($i = 0; $i < $count; $i++) {
      $type = $this->dataMapper->parseItemType();

      if ($type === ItemParserInterface::ITEM_TYPE_VLLS) {
        throw new Exception('Recursive data');
      }

      if ($type === ItemParserInterface::ITEM_TYPE_OBJC || $type === ItemParserInterface::ITEM_TYPE_GLBO) {
        $items[] = (new Descriptor($this->file))->parse();
      } else {
        $items[] = $this->itemParser->parse($type);
      }
    }

    return $items;
  }
}
