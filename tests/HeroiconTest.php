<?php

use Wrdx\Heroicons\Enums\Type;
use Wrdx\Heroicons\Exceptions\InvalidClassnameException;
use Wrdx\Heroicons\Exceptions\InvalidHeroiconException;
use Wrdx\Heroicons\Hero;

describe('Different ways to generate heroicon', function () {

    it('expects (new Hero("academic-cap")->svg()) to return a string')
        ->expect((new Hero('academic-cap'))->svg())
        ->toBeString();

    it('expects (string) (new Hero("academic-cap")) to return a string')
        ->expect((string) new Hero('academic-cap'))
        ->toBeString();

    it('expects Heroicon::icon("academic-cap")->svg() to return a string')
        ->expect((string) Hero::icon('academic-cap'))
        ->toBeString();

    it('expects (string) Heroicon::icon("academic-cap") to return a string')
        ->expect((string) Hero::icon('academic-cap'))
        ->toBeString();

    it('expects heroicon("academic-cap") to return a string')
        ->expect(heroicon('academic-cap'))
        ->toBeString();

});

describe('Types', function () {

    it('expects heroicon("academic-cap", Type::outline) to return a string')
        ->expect(heroicon('academic-cap', Type::outline))
        ->toBeString();

    it('expects heroicon("academic-cap", Type::solid) to return a string')
        ->expect(heroicon('academic-cap', Type::solid))
        ->toBeString();

    it('expects heroicon("academic-cap", Type::mini) to return a string')
        ->expect(heroicon('academic-cap', Type::mini))
        ->toBeString();

    it('expects heroicon("academic-cap", Type::micro) to return a string')
        ->expect(heroicon('academic-cap', Type::micro))
        ->toBeString();

});

describe('Attributes', function () {

    it('expects Hero::icon()->class("w-4") to have attribute class="w-4"')
        ->expect(Hero::icon('academic-cap')->class('w-4')->svg())
        ->toBeString()
        ->toContain('class="w-4"');

    it('expects Hero::icon()->class("w-4", "h-4") to have attribute class="w-4 h-4"')
        ->expect(Hero::icon('academic-cap')->class('w-4', 'h-4')->svg())
        ->toBeString()
        ->toContain('class="w-4 h-4"');

    it('expects Hero::icon()->attr("@click", "clickhandler()") to have attribute @click="clickhandler()"')
        ->expect(Hero::icon('academic-cap')->attr('@click', 'clickhandler()')->svg())
        ->toBeString()
        ->toContain('@click="clickhandler()"');

    it('expects heroicon() with attributes parameter ["class" => "w-4 h-4"] to have attribute class="w-4 w-4"')
        ->expect(heroicon('academic-cap', Type::solid, ['class' => 'w-4 h-4']))
        ->toBeString()
        ->toContain('class="w-4 h-4"');

});

describe('Exceptions', function () {

    it('expects heroicon("non-existing") to throw InvalidHeroiconException')
        ->expect(function () {
            heroicon('non-existing');
        })
        ->throws(InvalidHeroiconException::class);

    it('expects heroicon("academic-cap", "non-existing") to throw TypeError')
        ->expect(function () {
            /** @noinspection PhpParamsInspection */
            heroicon('academic-cap', 'non-existing');
        })
        ->throws(TypeError::class);

    it('expects Hero::icon()->class("a", "b c") to throw InvalidClassnameException')
        ->expect(function () {
            Hero::icon('academic-cap')->class('a', 'b c');
        })
        ->throws(InvalidClassnameException::class);

});
