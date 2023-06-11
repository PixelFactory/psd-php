<?php

namespace Psd\Descriptor\Parsers\ReferenceParser;

interface ReferenceParserInterface
{
    const REFERENCE_TYPE_PROP = 'prop';
    const REFERENCE_TYPE_CLSS = 'Clss';
    const REFERENCE_TYPE_ENMR = 'Enmr';
    const REFERENCE_TYPE_IDNT = 'Idnt';
    const REFERENCE_TYPE_INDX = 'indx';
    const REFERENCE_TYPE_NAME = 'name';
    const REFERENCE_TYPE_RELE = 'rele';

    public function parse();
}
