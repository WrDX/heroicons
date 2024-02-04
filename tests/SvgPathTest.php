<?php

use Wrdx\Heroicons\Enums\Type;
use Wrdx\Heroicons\Exceptions\InvalidHeroiconException;
use Wrdx\Heroicons\SvgPath;

it('expects SvgPath::one(Type::solid, "academic-cap") to return a string ending with solid/academic-cap.svg')
    ->expect(SvgPath::one(Type::solid, "academic-cap"))
    ->toMatch('/solid\/academic-cap\.svg$/');

it('expects SvgPath::all() to return an array')
    ->expect(SvgPath::all())
    ->toBeArray();

it('expects SvgPath::version() to match format v1.2.3')
    ->expect(SvgPath::version())
    ->toMatch('/^v\d+\.\d+\.\d+$/');

describe('Exceptions', function () {

    it('expects SvgPath::one(Type::outline, "non-existing") to throw InvalidHeroiconException')
        ->expect(function () {
            SvgPath::one(Type::outline, 'non-existing');
        })
        ->throws(InvalidHeroiconException::class);

});
