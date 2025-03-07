# DsLib

**DsLib** is a PHP library that provides strictly typed collections ([lists](https://en.wikipedia.org/wiki/List_(abstract_data_type)) and [sets](https://en.wikipedia.org/wiki/Set_(abstract_data_type))) for primitive data types ([float](src/Contract/FloatCollectionInterface.php), [integer](src/Contract/IntCollectionInterface.php) and [string](src/Contract/StringCollectionInterface.php)).

It ensures **type safety** when handling arrays by enforcing **strict type constraints** at the collection level, reducing runtime errors caused by type mismatches.

## Features

- Strictly typed **lists** and **sets** for primitive types.
- Prevents unintended type coercion in PHP arrays.
- Provides **type-safe filtering and mapping** with defined interfaces.
- Supports **immutable and mutable** collection operations.
- Compatible with modern **PHP versions**.

## Installation

To install **DsLib** via Composer:

```shell
composer require flavioheleno/dslib
```

## Interfaces & Implementation

Type    | Interface                                                               | List                                  | Set
--------|-------------------------------------------------------------------------|---------------------------------------|----
Float   | [FloatCollectionInterface](src/Contract/FloatCollectionInterface.php)   | [FloatList](src/List/FloatList.php)   | [FloatSet](src/List/FloatSet.php)
Integer | [IntCollectionInterface](src/Contract/IntCollectionInterface.php)       | [IntList](src/List/IntList.php)       | [IntSet](src/List/IntSet.php)
String  | [StringCollectionInterface](src/Contract/StringCollectionInterface.php) | [StringList](src/List/StringList.php) | [StringSet](src/List/StringSet.php)

## Usage

An example of how to use [StringList](src/List/StringList.php).

```php
<?php

use DsLib\Contract\StringFilterInterface;
use DsLib\List\StringList;

// Creating a StringList
$list = new StringList('hello', 'world');
// or using fromArray
$list = StringList::fromArray(['hello', 'world']);

// Check if the list is empty
$list->isEmpty(); // false

// Check if all elements have more than 4 characters
$list->all(
  new class implements StringFilterInterface {
    public function __invoke(string $value, int $index): bool {
      return strlen($value) > 4;
    }
  }
);
// true

// Check if 'hello' is in the list
$list->has('hello'); // true

// Remove and return the last element
$list->pop(); // "world"

// Remove and return the first element
$list->shift(); // "hello"

// Check if the list is empty
$list->isEmpty(); // true

// Push elements into the list
$list
  ->push('hello')
  ->push('world');

// Convert to a PHP array
$list->toArray();
// Output: ['hello', 'world']
```

## Filtering and Mapping

To ensure **strict type safety** in filtering (`all`, `any` and `filter`) and mapping (`map`) operations, **DsLib** provides the following interfaces:

**Filtering (`__invoke(<type> $value, int $index): bool`)**

* [FloatFilterInterface](src/Contract/FloatFilterInterface.php)
* [IntFilterInterface](src/Contract/IntFilterInterface.php)
* [StringFilterInterface](src/Contract/StringFilterInterface.php)

**Mapping (`__invoke(<type> $value): <type>`)**

* [FloatMapInterface](src/Contract/FloatMapInterface.php)
* [IntMapInterface](src/Contract/IntMapInterface.php)
* [StringMapInterface](src/Contract/StringMapInterface.php)

These interfaces enforce **strict callback signatures**, ensuring only compatible types are processed.

## License

This library is licensed under the [MIT License](LICENSE).
