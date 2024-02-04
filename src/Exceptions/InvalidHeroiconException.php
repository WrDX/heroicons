<?php

namespace Wrdx\Heroicons\Exceptions;

use RuntimeException;
use Wrdx\Heroicons\Enums\Type;

class InvalidHeroiconException extends RuntimeException
{
    public static function containsIllegalCharacter($icon): self
    {
        return new self("heroicon `{$icon}` contains illegal character(s).");
    }

    public static function notFound(Type $type, string $icon): self
    {
        return new self("heroicon `{$type->name} {$icon}` not found.");
    }
}