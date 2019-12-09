# ItalyStrap HTML API

[![Build Status](https://travis-ci.org/ItalyStrap/html.svg?branch=master)](https://travis-ci.org/ItalyStrap/html)
[![Latest Stable Version](https://img.shields.io/packagist/v/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![Total Downloads](https://img.shields.io/packagist/dt/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![License](https://img.shields.io/packagist/l/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
![PHP from Packagist](https://img.shields.io/packagist/php-v/italystrap/html)

PHP Sanitizer and Validation OOP way

## Table Of Contents

* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Advanced Usage](#advanced-usage)
* [Contributing](#contributing)
* [License](#license)

## Installation

The best way to use this package is through Composer:

```CMD
composer require italystrap/html
```

## Basic Usage

### Attributes Class

```php
use ItalyStrap\HTML\Attributes;

$sut = new Attributes();

$sut->add( 'context', [
    'class'	=> 'color-primary',
    'id'	=> 'unique_id',
] );

// ' class="color-primary" id="unique_id"'
echo $sut->render( 'context' );


$sut->add( 'another_context', [
    'class'	=> '', // This will be skipped because empty
    'attr1'	=> null, // This will be skipped because null
    'attr2'	=> false, // This will be skipped because false
    'attr3'	=> 0, // This will be skipped because 0 is also false
    'id'	=> 'unique_id',
] );
// ' id="unique_id"'
echo $sut->render( 'another_context' );
```

Attributes can be also used with the `get_attr()` and `get_attr_e()` helpers functions under the same namespece.

```php
use function ItalyStrap\HTML\{get_attr, get_attr_e};

// Return ' class="someClass"'
$attr = get_attr( 'context', ['class' => 'someClass'] );

// Echo ' class="someClass"'
get_attr_e( 'context', ['class' => 'someClass'] );
```

### Tag Class

```php
use ItalyStrap\HTML\{Tag,Attributes};

Tag::$is_debug = true; // This will print comment <! some comment> around the output for debugging, you can see it with ctrl + u key in the browser
$sut = new Tag( new Attributes() );

// <div class="someClass">Some content inside HTML div tags</div>
echo $sut->open( 'some_context', 'div', [ 'class' => 'someClass' ] );
echo 'Some content inside HTML div tags';
echo $sut->close( 'some_context' );

// <input type="text"/>
echo $sut->void( 'some_other_context', 'input', [ 'type' => 'text' ] );
```

## Advanced Usage

See in [tests](tests) folder for more advance usage.

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2019 Enea Overclokk, ItalyStrap

This code is licensed under the [MIT](LICENSE).

## Credits

> TODO