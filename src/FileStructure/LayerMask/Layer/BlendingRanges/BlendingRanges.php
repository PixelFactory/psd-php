<?php

namespace Psd\FileStructure\LayerMask\Layer\BlendingRanges;

use Psd\File\FileInterface;

class BlendingRanges implements BlendingRangesInterface {
  protected FileInterface $file;

  protected array $blendingRanges;

  public function __construct(FileInterface $file) {
    $this->file = $file;
  }

  public function parse(): void {
    $length = $this->file->readInt();
    if ($length === 0) {
      return;
    }

    $grey = [
      'source' => [
        'black' => [$this->file->readByte(), $this->file->readByte()],
        'white' => [$this->file->readByte(), $this->file->readByte()],
      ],
      'dest' => [
        'black' => [$this->file->readByte(), $this->file->readByte()],
        'white' => [$this->file->readByte(), $this->file->readByte()],
      ],
    ];

    $numChannels = ($length - 8) / 8;

    $channels = [];

    for ($i = 0; $i < $numChannels; $i++) {
      $channels[] = [
        'source' => [
          'black'=> [$this->file->readByte(), $this->file->readByte()],
          'white' => [$this->file->readByte(), $this->file->readByte()],
        ],
        'dest' => [
          'black' => [$this->file->readByte(), $this->file->readByte()],
          'white' => [$this->file->readByte(), $this->file->readByte()],
        ],
      ];
    }

    $this->blendingRanges = [
      'grey' => $grey,
      'channels' => $channels,
    ];
  }
}
