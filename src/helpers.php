<?php

use Wrdx\Heroicons\Enums\Type;
use Wrdx\Heroicons\Hero;

if ( ! function_exists('heroicon')) {

    /**
     * @param string $icon       any icon name from heroicons.com, for example: academic-cap
     * @param Type   $type       default: Type::outline
     * @param array  $attributes any attribute to add to the svg tag, for example ['id' => 'my-id']
     *
     * @return string
     */
    function heroicon(string $icon, Type $type = Type::outline, array $attributes = []): string
    {
        return Hero::icon($icon, $type, $attributes)->svg();
    }

}