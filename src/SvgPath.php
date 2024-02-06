<?php

namespace Wrdx\Heroicons;

use Wrdx\Heroicons\Enums\Type;
use Wrdx\Heroicons\Exceptions\InvalidHeroiconException;
use Wrdx\Heroicons\Exceptions\MissingDirectoryException;

class SvgPath
{
    /**
     * Get path for a single svg file
     *
     * @return string|false full path to svg, false if svg file does not exist
     */
    public static function one(Type $type, string $icon): string|false
    {
        $svgfile = static::makepath([
            $type->size(),
            $type->path(),
            "{$icon}.svg"
        ]);

        if ($svgfile === false) {
            throw InvalidHeroiconException::notFound($type, $icon);
        }

        return $svgfile;
    }

    /**
     * Get an array of all available icons, grouped by type
     *
     * @return array
     */
    public static function all(): array
    {
        $all = [
            'outline' => [],
            'solid' => [],
            'mini' => [],
            'micro' => [],
        ];

        foreach (SvgPath::svgs() as $svg) {

            if ( ! preg_match('|/(?<size>\d+)/(?<type>[a-z]+)/(?<icon>[a-z0-9-]+)\.svg$|', $svg->getPathname(), $matches)) {
                continue;
            }

            $type = match ((int) $matches['size']) {
                16 => 'micro',
                20 => 'mini',
                24 => $matches['type']
            };

            $all[$type][] = $matches['icon'];
        }

        foreach (array_keys($all) as $key) {
            sort($all[$key]);
        }

        return $all;
    }

    /**
     * Get version for included heroicons.com
     *
     * @return false|string
     */
    public static function version(): false|string
    {
        return file_get_contents(static::makepath(['.version']));
    }

    /**
     * Yield a path for every svg file
     *
     * @return \Generator
     */
    private static function svgs(): \Generator
    {
        $directory = static::makepath([]);

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        yield from new \RegexIterator($it, '/\.svg/', \RegexIterator::MATCH);
    }

    /**
     * Glue parts together and validate
     * it is an existing directory
     *
     * @param array $parts
     *
     * @return string|false
     */
    private static function makepath(array $parts): string|false
    {
        # Find basedir
        $basedir = realpath(implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'resources',
            'heroicons'
        ]));
        if ($basedir === false) {
            throw MissingDirectoryException::basedir();
        }

        # Prepend with basedir
        $parts = array_merge([$basedir], $parts);

        return realpath(implode(DIRECTORY_SEPARATOR, $parts));
    }
}