<?php

namespace Wrdx\Heroicons\Enums;

enum Type
{
    case outline;
    case solid;
    case mini;
    case micro;

    public function size(): int
    {
        return match ($this) {
            Type::outline, Type::solid => 24,
            Type::mini => 20,
            Type::micro => 16
        };
    }

    public function path(): string
    {
        return match ($this) {
            Type::outline, Type::solid => $this->name,
            Type::mini, Type::micro => Type::solid->name,
        };
    }
}
