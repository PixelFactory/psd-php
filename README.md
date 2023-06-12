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

##### Get file header data
You can call the 'getHeader' method to get all the information about a file\
All the header methods you can see there: Psd\FileStructure\Header\HeaderInterface

```php
$psd = new \Psd\Psd('./image.psd');

echo $psd->getHeader()->getMode();     // Return file mode (int)
echo $psd->getHeader()->modeName();    // Return file mode name
echo $psd->getHeader()->getChannels(); // Return file count channels
```

##### Get file guides

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