<?php

namespace Wrdx\Heroicons\Exceptions;

use RuntimeException;

class MissingDirectoryException extends RuntimeException
{
    public static function basedir(): self
    {
        return new self("resources/heroicons directory is missing.");
    }
}