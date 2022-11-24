<?php

namespace Psd\Descriptor;

use Psd\Descriptor\Data\DescriptorData;
use Psd\File\FileInterface;

interface DescriptorInterface {
    public function __construct(FileInterface $file);
    public function parse(): DescriptorData;
}
