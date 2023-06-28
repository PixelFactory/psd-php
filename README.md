<div align="center">
    <h1>PSD-PHP</h1>
    <img src="https://github.com/PixelFactory/psd-php/blob/master/assets/logo.svg" alt="Logo" width="350px" />
    <h3>Library for reading psd file</h3>
</div>

---

### Installation

```
composer require pixelfactory/psd-php
```

### Usage
Create an instance of the 'Psd' class by passing the file path.
```php
require_once '../vendor/autoload.php';

$psd = new \Psd\Psd('./image.psd');
```

Then you have two ways to use the library, 'simple' and 'professional'\
**Simple** - way is suitable for those who are not familiar with the structure of the psd file and just want to get the necessary information\
**Professional** - way can be used by more experienced developers to get access to a specific part of the file


### Simple

#### Getting file sizes
```php
$psd = new \Psd\Psd('./image.psd');
$psdSimpleMethods = $psd->getShortcuts();

echo $psdSimpleMethods->getWidth();    // Print file width
echo $psdSimpleMethods->getHeight();   // Print file height
```

#### Saving an image

```php
$psd = new \Psd\Psd('./image.psd');
$psdSimpleMethods = $psd->getShortcuts();

var_dump($psdSimpleMethods->savePreview('./out.png')); // Print 'true' if file be saved
```

#### Working with the layers tree
```php
// TODO
```

##### \[Layers tree\] Moving from directories
```php
// TODO
```

##### \[Layers tree\] Getting information about a layer
```php
// TODO
```

##### \[Layers tree\] Saving a layer image
```php
// TODO
```

### Professional

The psd class has the same structure as the psd file.
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Method</th>
            <th>Examples</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <a href="https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_19840" >
                    File header
                </a>
            </td>
            <td>getHeader</td>
            <td><a href="#header-data" >Link</a></td>
        </tr>
        <tr>
            <td>
                <a href="https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_71638" >
                    Color mode data
                </a>
            </td>
            <td colspan="2" >-¹</td>
        </tr>
        <tr>
            <td>
                <a href="https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_69883" >
                    Image resources
                </a>
            </td>
            <td>getResources</td>
            <td><a href="#image-resources" >Link</a></td>
        </tr>
        <tr>
            <td>
                <a href="https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_75067" >
                    Layer and mask information
                </a>
            </td>
            <td>getLayers</td>
            <td><a href="#layer-and-mask-information" >Link</a></td>
        </tr>
        <tr>
            <td>
                <a href="https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/PhotoshopFileFormats.htm#50577409_89817" >
                    Image data
                </a>
            </td>
            <td>getImage</td>
            <td><a href="#image-data" >Link</a></td>
        </tr>
    </tbody>
</table>

1 - 'Color mode data' has no method because it is skipped and not processed by the library. This should not affect the work with most images because they have the "rgb" or "cmyk" color mode. This section is used only in the "Indexed" or "Duotone" color mode. 

#### Header data

You can call the 'getHeader' method to get class implements [HeaderInterface](https://github.com/PixelFactory/psd-php/blob/master/src/FileStructure/Header/HeaderInterface.php) what contains methods for all fields image header section. 

<table>
    <thead>
        <tr>
            <th>File header section</th>
            <th>HeaderInterface methods</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Signature</td>
            <td></td>
        </tr>
        <tr>
            <td>Version</td>
            <td>getVersion</td>
        </tr>
        <tr>
            <td>Reserved</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Channels</td>
            <td>getChannels</td>
        </tr>
        <tr>
            <td>height</td>
            <td>getRows (Alias: getHeight)</td>
        </tr>
        <tr>
            <td>width</td>
            <td>getCols (Alias: getWidth)</td>
        </tr>
        <tr>
            <td>Depth</td>
            <td>getDepth</td>
        </tr>
        <tr>
            <td>Color mode</td>
            <td>getMode (Convert mode number to text: modeName)</td>
        </tr>
        <tr>
            <td>-</td>
            <td>parse</td>
        </tr>
        <tr>
            <td>-</td>
            <td>getNumPixels</td>
        </tr>
        <tr>
            <td>-</td>
            <td>getChannelLength</td>
        </tr>
        <tr>
            <td>-</td>
            <td>getFileLength</td>
        </tr>
    </tbody>
</table>

Example:
```php
echo $psd->getHeader()->getMode();     // Return file mode (int)
echo $psd->getHeader()->modeName();    // Return file mode name
echo $psd->getHeader()->getChannels(); // Return file count channels
```

#### Image resources

Image resources section store additional information. Such as guides, etc.\
The library is working with resources:
- Guides(1032)
- Layer Comps(1065)
- Resolution Info(1005)

The full list of resources you can be found in the [documentation](https://www.adobe.com/devnet-apps/photoshop/fileformatashtml/#50577409_38034)

To find the necessary resource, you need to call the method getResources (this method return class what extends from [ResourcesInterface](https://github.com/PixelFactory/psd-php/blob/master/src/LazyExecuteProxy/Interfaces/ResourcesInterface.php)). \
Next, you can use the search by the resource name or resource id.

Example. Get guides:

```php
/** @var \Psd\FileStructure\Resources\Resource\Guides\GuidesData[] $guides */
$guides = $psd
    ->getResources()
    ->getResourceById(\Psd\FileStructure\Resources\Resource\ResourceBase::RESOURCE_ID_GUIDES)
    ->getData();

foreach ($guides as $guide) {
    printf("%s - %s\n", $guide->getDirection(), $guide->getLocation()); // Result: 'vertical - 100'
}
```
#### Layer and mask information
```php
// TODO
```

#### Image data
This section stores the image. You can get a class for exporting an image using the method [getExporter](https://github.com/PixelFactory/psd-php/blob/master/src/FileStructure/Image/Image.php#L47). \
Now is available only [png](https://github.com/PixelFactory/psd-php/blob/master/src/Image/ImageExport/Exports/Png.php) class for export image:
```php
/* @var Psd\Image\ImageExport\Exports\Png $exporter */
$exporter = $psd->getImage()->getExporter(\Psd\Image\ImageExport\ImageExport::EXPORT_FORMAT_PNG);
```
All exporters classes implements interface: [ImageExportInterface](https://github.com/PixelFactory/psd-php/blob/master/src/Image/ImageExport/Exports/ImageExportInterface.php) \
You can export the image to the [Imagick](https://www.php.net/manual/en/class.imagick.php) class or save it.
```php
/** @var Imagick $image */
$image = $exporter->export();
/** @var bool $status */ 
$status = $exporter->save('./out.png');
```
