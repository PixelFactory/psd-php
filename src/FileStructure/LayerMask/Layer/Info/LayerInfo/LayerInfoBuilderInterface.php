<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo;

use Psd\File\FileInterface;

interface LayerInfoBuilderInterface
{
    const KEY_ARTB = 'artb';
    const KEY_ARTD = 'artd';
    const KEY_ABDD = 'abdd';
    const KEY_CLBL = 'clbl';
    const KEY_INFX = 'infx';
    const KEY_IOPA = 'iOpa';
    const KEY_GDFL = 'GdFl';
    const KEY_LYID = 'lyid';
    const KEY_LNSR = 'lnsr';
    const KEY_LSPF = 'lspf';
    const KEY_SHMD = 'shmd';
    const KEY_LSDK = 'lsdk';
    const KEY_LFX2 = 'lfx2';
    const KEY_LMFX = 'lmfx';
    const KEY_LSCT = 'lsct';
    const KEY_SOCO = 'SoCo';
    const KEY_LUNI = 'luni';
    const KEY_VMSK = 'vmsk';
    const KEY_VSMS = 'vsms';
    const KEY_VOGK = 'vogk';
    const KEY_VSTK = 'vstk';
    const KEY_VSCG = 'vscg';

    const NAME_ARTBOARD = 'Artboard';
    const NAME_BLEND_CLIPPING_ELEMENTS = 'BlendClippingElements';
    const NAME_BLEND_INTERIOR_ELEMENTS = 'BlendInteriorElements';
    const NAME_FILL_OPACITY = 'FillOpacity';
    const NAME_GRADIENT_FILL = 'GradientFill';
    const NAME_LAYER_ID = 'LayerId';
    const NAME_LAYER_NAME_SOURCE = 'LayerNameSource';
    const NAME_LOCKED = 'Locked';
    const NAME_METADATA = 'Metadata';
    const NAME_NESTED_SECTION_DIVIDER = 'NestedSectionDivider';
    const NAME_OBJECT_EFFECTS = 'ObjectEffects';
    const NAME_SECTION_DIVIDER = 'SectionDivider';
    const NAME_SOLID_COLOR = 'SolidColor';
    const NAME_UNICODE_NAME = 'UnicodeName';
    const NAME_VECTOR_MASK = 'VectorMask';
    const NAME_VECTOR_ORIGINATION = 'VectorOrigination';
    const NAME_VECTOR_STROKE = 'VectorStroke';
    const NAME_VECTOR_STROKECONTENT = 'VectorStrokeContent';
    const NAME_EMPTY_LAYER_INFO = 'Empty';

    public function build(FileInterface $file, string $key): LayerInfo;
}
