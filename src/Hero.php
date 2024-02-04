<?php

namespace Wrdx\Heroicons;

use SVG\SVG;
use Wrdx\Heroicons\Enums\Type;
use Wrdx\Heroicons\Exceptions\InvalidClassnameException;
use Wrdx\Heroicons\Exceptions\InvalidHeroiconException;

class Hero
{
    private array $attributes = [];
    private array $classes = [];

    /**
     * @param string $icon       any icon name from heroicons.com, for example: academic-cap
     * @param Type   $type       default: Type::outline
     * @param array  $attributes any attribute to add to the svg tag, for example ['id' => 'my-id']
     */
    public function __construct(
        private readonly string $icon,
        private Type            $type = Type::outline,
        array                   $attributes = []
    )
    {
        # Check $icon for illegal characters
        if ( ! preg_match('/^[a-z0-9-]+$/', $this->icon)) {
            throw  InvalidHeroiconException::containsIllegalCharacter($icon);
        }
        # Add attributes
        foreach ($attributes as $name => $value) {
            $this->attr($name, $value);
        }
    }

    /**
     * Static constructor
     *
     * @param string $icon       any icon name from heroicons.com, for example: academic-cap
     * @param Type   $type       default: Type::outline
     * @param array  $attributes any attribute to add to the svg tag, for example ['id' => 'my-id']
     *
     * @return Hero
     */
    public static function icon(string $icon, Type $type = Type::outline, array $attributes = []): Hero
    {
        return new self($icon, $type, $attributes);
    }

    /**
     * Set type of icon
     *
     * @param Type $type
     *
     * @return Hero
     */
    public function type(Type $type): Hero
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Add a class, or multiple classes to the svg class attribute
     *
     * @param string ...$class
     *
     * @return Hero
     */
    public function class(string ...$class): Hero
    {
        foreach ($class as $classname) {
            if (preg_match("/\s/", $classname)) {
                throw InvalidClassnameException::containsWhitespace($classname);
            }
            $this->classes[] = $classname;
        }

        return $this;
    }

    /**
     * Add an attribute to the svg tag
     *
     * @param string $name
     * @param string $value
     *
     * @return Hero
     */
    public function attr(string $name, string $value): Hero
    {
        if ($name === 'class') {
            $this->class(...explode(' ', $value));
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Get svg html tag
     *
     * @return string
     */
    public function svg(): string
    {
        $svg = SVG::fromFile(SvgPath::one($this->type, $this->icon));
        $doc = $svg->getDocument();

        # Add attributes
        foreach ($this->attributes as $name => $value) {
            $doc->setAttribute($name, $value);
        }

        # Add class(es)
        if ($this->classes) {
            $doc->setAttribute('class', implode(' ', $this->classes));
        }

        return $svg->toXMLString(false);
    }

    /**
     * Get version for included heroicons.com
     *
     * @return string
     */
    public static function version(): string
    {
        return SvgPath::version();
    }

    /**
     * Get svg html tag
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->svg();
    }

}