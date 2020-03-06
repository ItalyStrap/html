# ItalyStrap HTML API

[![Build Status](https://travis-ci.org/ItalyStrap/html.svg?branch=master)](https://travis-ci.org/ItalyStrap/html)
[![Latest Stable Version](https://img.shields.io/packagist/v/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![Total Downloads](https://img.shields.io/packagist/dt/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
[![License](https://img.shields.io/packagist/l/italystrap/html.svg)](https://packagist.org/packages/italystrap/html)
![PHP from Packagist](https://img.shields.io/packagist/php-v/italystrap/html)

PHP HTML handler the OOP way

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
use ItalyStrap\HTML\AttributesInterface;

$sut = new AttributesInterface();

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

### `ItalyStrap\HTML\get_attr()`

Build list of attributes into a string and apply contextual filter on string:

```php
use function ItalyStrap\HTML\{get_attr, get_attr_e};

$attr = [
	'id'	=> 'unique_id',
	'class'	=> 'some_class',
];

$output = get_attr( $context, $attr, false );

// id="unique_id" class="some_class"

printf(
	'<span%s>Title</span>',
	$output
);
```

or

```html
<span<?php get_attr_e( $context, $attr, true ) ?>>Title</span>
```

```php
// <span id="unique_id" class="some_class">Title</span>
```

```php
use function ItalyStrap\HTML\{open_tag, close_tag, open_tag_e, close_tag_e};

\ItalyStrap\HTML\Tag::$is_debug = false; // If you don't want tu print debug comments
$open = \ItalyStrap\HTML\open_tag( 'test', 'div', [ 'class' => 'btn-primary' ] );
$this->assertStringContainsString( '<div class="btn-primary">', $open, '' );
$closed = \ItalyStrap\HTML\close_tag( 'test' );
$this->assertStringContainsString( '</div>', $closed, '' );


\ItalyStrap\HTML\Tag::$is_debug = false;
\ItalyStrap\HTML\open_tag_e( 'test', 'div', [ 'class' => 'btn-primary' ] );
echo 'Content';
\ItalyStrap\HTML\close_tag_e( 'test' );

$this->expectOutputString( '<div class="btn-primary">Content</div>' );
```


### Tag Class

```php
use ItalyStrap\HTML\{Tag,AttributesInterface};

Tag::$is_debug = true; // This will print comment <! some comment> around the output for debugging, you can see it with ctrl + u key in the browser
$sut = new Tag( new AttributesInterface() );

// <div class="someClass">Some content inside HTML div tags</div>
echo $sut->open( 'some_context', 'div', [ 'class' => 'someClass' ] );
echo 'Some content inside HTML div tags';
echo $sut->close( 'some_context' );

// <input type="text"/>
echo $sut->void( 'some_other_context', 'input', [ 'type' => 'text' ] );
```

### Filters

```php
use ItalyStrap\HTML\{Tag,AttributesInterface};

$context = 'some_context';

\add_filter("italystrap_{$context}_tag", function( string $tag, string $context, Tag $obj) {
    // Do some staff with $tag
    $new_tag = 'span';
    return $new_tag;
}, 10, 3);

$sut = new Tag( new AttributesInterface() );
echo $sut->open( 'some_context', 'div', [ 'class' => 'someClass' ] );
echo 'Some content inside HTML div tags';
echo $sut->close( 'some_context' );

// <span class="someClass">Some content inside HTML div tags</span>
```

## Advanced Usage

See in [tests](tests) folder for more advance usage.

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2019 Enea Overclokk, ItalyStrap

This code is licensed under the [MIT](LICENSE).

## Notes

*  Maintained under the [Semantic Versioning Guide](http://semver.org)

## Credits

> TODO