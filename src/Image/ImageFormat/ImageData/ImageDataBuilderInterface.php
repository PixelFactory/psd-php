<?php

namespace Psd\Image\ImageFormat\ImageData;


interface ImageDataBuilderInterface {
    public function build(int $type): ImageDataBase;
}
