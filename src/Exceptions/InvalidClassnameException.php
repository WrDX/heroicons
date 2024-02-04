<?php

namespace Wrdx\Heroicons\Exceptions;

use RuntimeException;

class InvalidClassnameException extends RuntimeException
{
    public static function containsWhitespace(string $classname): self
    {
        return new self("classname `{$classname}` contains whitespace character(s).");
    }
}