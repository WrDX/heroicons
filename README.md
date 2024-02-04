# Generate svg icons from heroicons.com with PHP

![php 8.1-8.3](https://img.shields.io/badge/php-8.1%7C8.2%7C8.3-777bb3.svg?logo=php&logoColor=white)

## Installation

Install the package via composer

```bash
composer require wrdx/heroicons
```

## Usage

```php
use Wrdx\Heroicons\Hero;

echo Hero::icon('academic-cap')->svg();
```

A bit more control

```php
use Wrdx\Heroicons\Hero;
use Wrdx\Heroicons\Enums\Type;

$icon = new Hero('academic-cap');
$icon->type(Type::micro);
$icon->class('my-class', 'my-second-class');
$icon->attr('id','my-id');

echo $icon->svg();
```

Use the `heroicon()` helper function

```php
use Wrdx\Heroicons\Enums\Type;

echo heroicon('academic-cap', Type::mini, ['id' => 'my-id']);
```

## Development

Run tests

```bash
composer test
```

Update heroicons.com svg files

```bash
composer heroicons:update
```
