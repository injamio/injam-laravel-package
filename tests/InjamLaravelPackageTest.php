<?php

namespace Injamio\InjamLaravelPackage\Tests;

use Injamio\InjamLaravelPackage\Facades\InjamLaravelPackage;
use Injamio\InjamLaravelPackage\ServiceProvider;
use Orchestra\Testbench\TestCase;

class InjamLaravelPackageTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'injam-laravel-package' => InjamLaravelPackage::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
