<?php

namespace Injamio\InjamLaravelPackage\Facades;

use Illuminate\Support\Facades\Facade;

class InjamLaravelPackage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'InjamLaravelPackage';
    }
}
