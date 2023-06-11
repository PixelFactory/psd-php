<?php

namespace Psd\FileStructure\LayerMask\Layer\BlendMode;

interface BlendModeInterface
{
    const BLEND_MODE_KEY = [
        'norm' => 'normal',
        'dark' => 'darken',
        'lite' => 'lighten',
        'hue' => 'hue',
        'sat' => 'saturation',
        'colr' => 'color',
        'lum' => 'luminosity',
        'mul' => 'multiply',
        'scrn' => 'screen',
        'diss' => 'dissolve',
        'over' => 'overlay',
        'hLit' => 'hard_light',
        'sLit' => 'soft_light',
        'diff' => 'difference',
        'smud' => 'exclusion',
        'div' => 'color_dodge',
        'idiv' => 'color_burn',
        'lbrn' => 'linear_burn',
        'lddg' => 'linear_dodge',
        'vLit' => 'vivid_light',
        'lLit' => 'linear_light',
        'pLit' => 'pin_light',
        'hMix' => 'hard_mix',
        'pass' => 'passthru',
        'dkCl' => 'darker_color',
        'lgCl' => 'lighter_color',
        'fsub' => 'subtract',
        'fdiv' => 'divide',
    ];

    public function parse(): void;

    public function getBlendKey(): string;

    public function getOpacity(): float;

    public function getClipping(): float;

    public function getFlags(): float;

    public function getMode(): string;

    public function getClipped(): bool;

    public function getVisible(): bool;

    public function opacityPercentage(): float;

    public function parseBlendKey(): string;
}
