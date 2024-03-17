# Optimize your Filament images before they reach your database.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joshembling/image-optimizer.svg?style=flat-square)](https://packagist.org/packages/joshembling/image-optimizer)
[![Total Downloads](https://img.shields.io/packagist/dt/joshembling/image-optimizer.svg?style=flat-square)](https://packagist.org/packages/joshembling/image-optimizer)

When you currently upload an image using the native Filament component `FileUpload`, the original file is saved without any compression or conversion.

Additionally, if you upload an image and use conversions with `SpatieMediaLibraryFileUpload`, the original file is saved with its corresponding versions provided on your model. 

What if you'd rather convert and reduce the image(s) before reaching your database/S3 bucket? Especially in the case where you know you'll never need to save the original image sizes the user has uploaded.

🤳 **This is where Filament Image Optimizer comes in**. 

You use the same components as you have been doing and have access to two additional methods for maximum optimization, saving you a lot of disk space in the process. 🎉

## Contents

- [Contents](#contents)
- [Installation](#installation)
- [Usage](#usage)
	- [Optimizing Images](#optimizing-images)
	- [Resizing Images](#resizing-images)
	- [Combining Methods](#combining-methods)
	- [Multiple Images](#multiple-images)
	- [Examples](#examples)
	- [Debugging](#debugging)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [Credits](#credits)
- [Licence](#license)

## Installation

You can install the package via composer, which currently works with the latest Filament version (^3.2) and Laravel 10 & 11:

```bash
composer require joshembling/image-optimizer
```

If you are using Filament 3.0 or 3.1 install with: 
```bash
composer require joshembling/image-optimizer:v1.2
```

## Usage

### Filament version

You must be using [Filament v3.x](https://filamentphp.com/docs/3.x/panels/installation) to have access to this plugin.

For specific versions that match your PHP, Laravel, Filament and Image Optimizer installations please see the table below:

| PHP | Laravel version | Filament version | Image Optimizer version |
| ----- | ----- | -----| ----- |
| ^8.1 | ^10.0 | ^3.0 | 1.2 |
| ^8.1 | ^10.0 | ^3.1 | 1.2 |
| ^8.1 | ^10.0 | ^3.2 | ~1.3 |
| ^8.2 | ^10.0, ^11.0 | ^3.2 | ^1.4 |

### Server

[GD Library](https://www.php.net/manual/en/image.installation.php) must be installed on your server to compress images.

### Optimizing images

Before uploading your image, you may choose to optimize it by converting to your chosen format. The file saved to your disk will be the converted version only.

E.g. I want to convert my image to 'webp': 

`````php
use Filament\Forms\Components\FileUpload;

FileUpload::make('attachment')
    ->image()
    ->optimize('webp'),
`````

You can do exactly the same using `SpatieMediaLibraryFileUpload`:

`````php
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

SpatieMediaLibraryFileUpload::make('attachment')
    ->image()
    ->optimize('webp'),
`````

### Resizing images

You may also want to resize an image by passing in a percentage you would like to reduce the image by. This will also maintain aspect ratio.

E.g. I'd like to reduce my image (1280px x 720px) by 50%:

`````php
use Filament\Forms\Components\FileUpload;

FileUpload::make('attachment')
    ->image()
    ->resize(50),
`````

Uploaded image size is 640px x 360px.

You can do the same using `SpatieMediaLibraryFileUpload`:

`````php
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

SpatieMediaLibraryFileUpload::make('attachment')
    ->image()
    ->resize(50),
`````

### Combining methods

You can combine these two methods for maximum optimization.

`````php
use Filament\Forms\Components\FileUpload;

FileUpload::make('attachment')
	->image()
	->optimize('webp')
	->resize(50),
`````

`````php
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

SpatieMediaLibraryFileUpload::make('attachment')
    ->image()
	->optimize('webp')
    ->resize(50),
`````

### Multiple images

You can also do this with multiple images - all images will be converted to the same format and reduced with the same percentage passed in. Just chain on `multiple()` to your upload:

`````php
use Filament\Forms\Components\FileUpload;

FileUpload::make('attachment')
    ->image()
	->multiple()
	->optimize('jpg')
    ->resize(50),
`````

`````php
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

SpatieMediaLibraryFileUpload::make('attachment')
    ->image()
	->multiple()
	->optimize('jpg')
    ->resize(50),
`````

### Examples 

![Before](images/before.jpg) 

![After](images/after.jpg)

### Debugging

- If you see a 'not found' exception, including "Method `optimize`" or "Method `resize`", ensure you run `composer update` so that your lock file is in sync with your `composer.json`. 

- You might see a 'Waiting for size' message and an infinite loading state on the component and the likely cause of this is a CORS issue. This can be quickly be resolved by ensuring you are serving and upload images from the same domain. Check your Javascript console for more information.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Josh Embling](https://github.com/joshembling)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
