<?php

arch('it expects debug globals not to be used')
    ->expect(['dd', 'dump', 'var_dump', 'debug'])
    ->not->toBeUsed();

arch('it expects Wrdx\Heroicons\Enums to be enums')
    ->expect('Wrdx\Heroicons\Enums')
    ->toBeEnums();
