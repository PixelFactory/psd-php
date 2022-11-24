<?php

namespace Psd\FileStructure\LayerMask\Layer\LegacyLayerName;

use Exception;
use Psd\File\FileInterface;
use Psd\Helper;

class LegacyLayerName implements LegacyLayerNameInterface {

  protected FileInterface $file;

  protected string $legacyName;

  public function __construct(FileInterface $file) {
    $this->file = $file;
  }

  public function parse(): void {
    $len = Helper::pad4($this->file->readByte());
    $this->legacyName = $this->file->readString($len);
  }

  public function getLegacyName(): string {
    if (!isset($this->legacyName)) {
      throw new Exception('LegacyLayerName not parsed. LegacyName is undefined.');
    }

    return $this->legacyName;
  }
}
