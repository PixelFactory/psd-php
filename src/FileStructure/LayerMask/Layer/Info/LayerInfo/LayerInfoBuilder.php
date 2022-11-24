<?php

namespace Psd\FileStructure\LayerMask\Layer\Info\LayerInfo;

use Psd\File\FileInterface;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendClippingElements\Artboard;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendClippingElements\BlendClippingElements;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\BlendInteriorElements\BlendInteriorElements;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\EmptyLayerInfo\EmptyLayerInfo;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\FillOpacity\FillOpacity;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\GradientFill\GradientFill;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerId\LayerId;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerNameSource\LayerNameSource;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\Locked\Locked;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\Metadata\Metadata;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\NestedSectionDivider\NestedSectionDivider;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\ObjectEffects\ObjectEffects;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\SectionDivider\SectionDivider;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\SolidColor\SolidColor;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\UnicodeName\UnicodeName;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorMask\VectorMask;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorOrigination\VectorOrigination;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorStroke\VectorStroke;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\VectorStrokeContent\VectorStrokeContent;

class LayerInfoBuilder implements LayerInfoBuilderInterface {
  public function build(FileInterface $file, string $key): LayerInfo {
    $layerInfo = new EmptyLayerInfo($file);
    $name = self::NAME_EMPTY_LAYER_INFO;

    if ($key === self::KEY_ARTB || $key === self::KEY_ARTD || $key === self::KEY_ABDD) {
      $layerInfo = new Artboard($file);
      $name = self::NAME_ARTBOARD;
    } else if ($key === self::KEY_CLBL) {
      $layerInfo = (new BlendClippingElements($file));
      $name = self::NAME_BLEND_CLIPPING_ELEMENTS;
    } else if ($key === self::KEY_INFX) {
      $layerInfo = (new BlendInteriorElements($file));
      $name = self::NAME_BLEND_INTERIOR_ELEMENTS;
    } else if ($key === self::KEY_IOPA) {
      $layerInfo = new FillOpacity($file);
      $name = self::NAME_FILL_OPACITY;
    } else if ($key === self::KEY_GDFL) {
      $layerInfo = new GradientFill($file);
      $name = self::NAME_GRADIENT_FILL;
    } else if ($key === self::KEY_LYID) {
      $layerInfo = new LayerId($file);
      $name = self::NAME_LAYER_ID;
    } else if ($key === self::KEY_LNSR) {
      $layerInfo = new LayerNameSource($file);
      $name = self::NAME_LAYER_NAME_SOURCE;
    } else if ($key === self::KEY_LSPF) {
      $layerInfo = new Locked($file);
      $name = self::NAME_LOCKED;
    } else if ($key === self::KEY_SHMD) {
      $layerInfo = new Metadata($file);
      $name = self::NAME_METADATA;
    } else if ($key === self::KEY_LSDK) {
      $layerInfo = new NestedSectionDivider($file);
      $name = self::NAME_NESTED_SECTION_DIVIDER;
    } else if ($key === self::KEY_LFX2 || $key === self::KEY_LMFX) {
      $layerInfo = new ObjectEffects($file);
      $name = self::NAME_OBJECT_EFFECTS;
    } else if ($key === self::KEY_LSCT) {
      $layerInfo = new SectionDivider($file);
      $name = self::NAME_SECTION_DIVIDER;
    } else if ($key === self::KEY_SOCO) {
      $layerInfo = new SolidColor($file);
      $name = self::NAME_SOLID_COLOR;
    } else if ($key === self::KEY_LUNI) {
      $layerInfo = new UnicodeName($file);
      $name = self::NAME_UNICODE_NAME;
    } else if ($key === self::KEY_VMSK || $key === self::KEY_VSMS) {
      $layerInfo = new VectorMask($file);
      $name = self::NAME_VECTOR_MASK;
    } else if ($key === self::KEY_VOGK) {
      $layerInfo = new VectorOrigination($file);
      $name = self::NAME_VECTOR_ORIGINATION;
    } else if ($key === self::KEY_VSTK) {
      $layerInfo = new VectorStroke($file);
      $name = self::NAME_VECTOR_STROKECONTENT;
    } else if ($key === self::KEY_VSCG) {
      $layerInfo = new VectorStrokeContent($file);
      $name = self::NAME_VECTOR_STROKECONTENT;
    }

    return (new LayerInfo())
        ->setLayerInfo($layerInfo)
        ->setName($name)
        ;
  }
}
