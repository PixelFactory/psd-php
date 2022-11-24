<?php

namespace Psd\Descriptor\Parsers\ItemParser;

interface ItemParserInterface
{
    public function parse(string $parseType);

    const ITEM_TYPE_BOOL = 'bool';
    const ITEM_TYPE_TYPE = 'type';
    const ITEM_TYPE_GLBC = 'GlbC';
    const ITEM_TYPE_GLBO = 'GlbO';
    const ITEM_TYPE_OBJC = 'Objc';
    const ITEM_TYPE_DOUB = 'doub';
    const ITEM_TYPE_ENUM = 'enum';
    const ITEM_TYPE_ALIS = 'alis';
    const ITEM_TYPE_PTH = 'Pth';
    const ITEM_TYPE_LONG = 'long';
    const ITEM_TYPE_COMP = 'comp';
    const ITEM_TYPE_OBAR = 'ObAr';
    const ITEM_TYPE_TDTA = 'tdta';
    const ITEM_TYPE_OBJ = 'obj ';
    const ITEM_TYPE_TEXT = 'TEXT';
    const ITEM_TYPE_UNTF = 'UntF';
    const ITEM_TYPE_UNFL = 'UnFl';
    const ITEM_TYPE_VLLS = 'VlLs';

    const ITEM_TYPES = [
        self::ITEM_TYPE_BOOL,
        self::ITEM_TYPE_TYPE,
        self::ITEM_TYPE_GLBC,
        self::ITEM_TYPE_GLBO,
        self::ITEM_TYPE_OBJC,
        self::ITEM_TYPE_DOUB,
        self::ITEM_TYPE_ENUM,
        self::ITEM_TYPE_ALIS,
        self::ITEM_TYPE_PTH,
        self::ITEM_TYPE_LONG,
        self::ITEM_TYPE_COMP,
        self::ITEM_TYPE_OBAR,
        self::ITEM_TYPE_TDTA,
        self::ITEM_TYPE_OBJ,
        self::ITEM_TYPE_TEXT,
        self::ITEM_TYPE_UNTF,
        self::ITEM_TYPE_UNFL,
        self::ITEM_TYPE_VLLS,
    ];
}