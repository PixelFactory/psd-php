<?php

namespace Psd\FileStructure\LayerMask\Layer;

use Exception;
use Psd\Descriptor\Data\RectKey;
use Psd\File\FileInterface;
use Psd\FileStructure\Header\HeaderInterface;
use Psd\FileStructure\LayerMask\Layer\BlendingRanges\BlendingRanges;
use Psd\FileStructure\LayerMask\Layer\BlendingRanges\BlendingRangesInterface;
use Psd\FileStructure\LayerMask\Layer\BlendMode\BlendMode;
use Psd\FileStructure\LayerMask\Layer\BlendMode\BlendModeInterface;
use Psd\FileStructure\LayerMask\Layer\ChannelImage\ChannelImage;
use Psd\FileStructure\LayerMask\Layer\Info\Info;
use Psd\FileStructure\LayerMask\Layer\Info\InfoInterface;
use Psd\FileStructure\LayerMask\Layer\Info\LayerInfo\LayerInfoBuilderInterface;
use Psd\FileStructure\LayerMask\Layer\LegacyLayerName\LegacyLayerName;
use Psd\FileStructure\LayerMask\Layer\LegacyLayerName\LegacyLayerNameInterface;
use Psd\FileStructure\LayerMask\Layer\Mask\Mask;
use Psd\FileStructure\LayerMask\Layer\Mask\MaskInterface;
use Psd\FileStructure\LayerMask\Layer\PositionAndChannels\PositionAndChannels;
use Psd\FileStructure\LayerMask\Layer\PositionAndChannels\PositionAndChannelsInterface;
use Psd\LazyExecuteProxy\Interfaces\ChannelImageInterface;
use Psd\LazyExecuteProxy\Proxies\ChannelImageProxy;
use Throwable;

class Layer implements LayerInterface
{
    protected FileInterface $file;

    protected HeaderInterface $header;

    protected BlendingRangesInterface $blendingRanges;

    protected BlendModeInterface $blendMode;

    protected InfoInterface $info;

    protected LegacyLayerNameInterface $legacyLayerName;

    protected MaskInterface $mask;

    protected PositionAndChannelsInterface $positionAndChannels;

    protected ChannelImageInterface $channelImage;

    public function __construct(FileInterface $file, HeaderInterface $header)
    {
        $this->file = $file;
        $this->header = $header;

        $this->blendingRanges = $this->buildBlendingRanges($this->file);
        $this->blendMode = $this->buildBlendMode($this->file);
        $this->info = $this->buildInfo($this->file);
        $this->legacyLayerName = $this->buildLegacyLayerName($this->file);
        $this->mask = $this->buildMask($this->file);
        $this->positionAndChannels = $this->buildPositionAndChannels($this->file);
    }

    public function parse(): void
    {
        $this->parsePositionAndChannels();
        $this->parseBlendModes();

        $layerEnd = $this->file->readInt() + $this->file->tell();

        $this->parseMaskData();
        $this->parseBlendingRanges();
        $this->parseLegacyLayerName();
        $this->parseLayerInfo($layerEnd);

        $this->file->ffseek($layerEnd);
    }

    public function export(): array
    {
        $position = $this->getPosition();

        return [
            'name' => $this->getName(),
            'opacity' => $this->blendMode->getOpacity(),
            'visible' => $this->blendMode->getVisible(),
            'clipped' => $this->blendMode->getClipped(),
            'mask' => $this->mask->export(),
            'top' => $position['top'],
            'left' => $position['left'],
            'right' => $position['right'],
            'bottom' => $position['bottom'],
            'width' => $position['width'],
            'height' => $position['height'],
        ];
    }

    public function getPosition(): array
    {
        try {
            $positionData = $this->info->getDataInfo(LayerInfoBuilderInterface::NAME_VECTOR_ORIGINATION)
                ->getData()['data']['keyDescriptorList'][0]['data']['keyOriginShapeBBox'];

            $top = $positionData['data'][RectKey::TOP]['value'];
            $left = $positionData['data'][RectKey::LEFT]['value'];
            $right = $positionData['data'][RectKey::RIGHT]['value'];
            $bottom = $positionData['data'][RectKey::BOTTOM]['value'];

            return [
                'top' => $top,
                'left' => $left,
                'right' => $right,
                'bottom' => $bottom,
                'width' => ($right - $left),
                'height' => ($bottom - $top),
            ];
        } catch (Throwable $ex) {
            return [
                'top' => $this->positionAndChannels->getTop(),
                'right' => $this->positionAndChannels->getRight(),
                'bottom' => $this->positionAndChannels->getBottom(),
                'left' => $this->positionAndChannels->getLeft(),
                'width' => $this->positionAndChannels->getWidth(),
                'height' => $this->positionAndChannels->getHeight(),
            ];
        }
    }

    public function getName(): string
    {
        try {
            return $this->info->getDataInfo(LayerInfoBuilderInterface::NAME_UNICODE_NAME)->getData();
        } catch (Throwable $ex) {
            return $this->legacyLayerName->getLegacyName();
        }
    }

    public function getInfo(): InfoInterface
    {
        return $this->info;
    }

    public function isFolder(): bool
    {
        if (isset($this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_SECTION_DIVIDER])) {
            return $this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_SECTION_DIVIDER]->getData()['isFolder'];
        }

        if (isset($this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_NESTED_SECTION_DIVIDER])) {
            return $this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_NESTED_SECTION_DIVIDER]->getData()['isFolder'];
        }

        return $this->getName() === '<Layer group>';
    }

    public function isFolderEnd(): bool
    {
        if (isset($this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_SECTION_DIVIDER])) {
            return $this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_SECTION_DIVIDER]->getData()['isHidden'];
        }

        if (isset($this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_NESTED_SECTION_DIVIDER])) {
            return $this->getInfo()->getData()[LayerInfoBuilderInterface::NAME_NESTED_SECTION_DIVIDER]->getData()['isHidden'];
        }

        return $this->getName() === '</Layer group>';
    }

    public function getChannelImage(): ChannelImageInterface
    {
        if (!isset($this->channelImage)) {
            throw new Exception('Layer not parsed. ChannelImage is undefined.');
        }

        return $this->channelImage;
    }

    public function parseChannelImage(): void
    {
        if (isset($this->channelImage)) {
            throw new Exception('Parsing error. ParseChannelImage cant be running twice.');
        }

        $this->channelImage = new ChannelImageProxy(
            $this->buildChannelImage($this->file, $this->header, [
                'layerChannelsInfo' => $this->positionAndChannels->getChannelsInfo(),
                'layerWidth' => $this->positionAndChannels->getWidth(),
                'layerHeight' => $this->positionAndChannels->getHeight(),
                'layerOpacity' => $this->blendMode->getOpacity(),
                'layerChannels' => $this->positionAndChannels->getChannels(),
                'layerMaskWidth' => $this->mask->getWidth(),
                'layerMaskHeight' => $this->mask->getHeight(),
            ]),
            $this->file,
        );
    }

    protected function parsePositionAndChannels(): void
    {
        $this->positionAndChannels->parse();
    }

    protected function parseBlendModes(): void
    {
        $this->blendMode->parse();
    }

    protected function parseMaskData(): void
    {
        $this->mask->parse();
    }

    protected function parseBlendingRanges(): void
    {
        $this->blendingRanges->parse();
    }

    protected function parseLegacyLayerName(): void
    {
        $this->legacyLayerName->parse();
    }

    protected function parseLayerInfo(int $layerEnd): void
    {
        $this->info->parse($layerEnd);
    }

    protected function buildChannelImage(
        FileInterface   $file,
        HeaderInterface $header,
                        $layerData
    ): ChannelImageInterface
    {
        return new ChannelImage($file, $header, $layerData);
    }

    protected function buildBlendingRanges(FileInterface $file): BlendingRangesInterface
    {
        return new BlendingRanges($file);
    }

    protected function buildBlendMode(FileInterface $file): BlendModeInterface
    {
        return new BlendMode($file);
    }

    protected function buildInfo(FileInterface $file): InfoInterface
    {
        return new Info($file);
    }

    protected function buildLegacyLayerName(FileInterface $file): LegacyLayerNameInterface
    {
        return new LegacyLayerName($file);
    }

    protected function buildMask(FileInterface $file): MaskInterface
    {
        return new Mask($file);
    }

    protected function buildPositionAndChannels(FileInterface $file): PositionAndChannelsInterface
    {
        return new PositionAndChannels($file);
    }
}
