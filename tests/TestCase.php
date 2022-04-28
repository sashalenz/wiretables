<?php

namespace Sashalenz\Wiretables\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sashalenz\Wiretables\WiretablesServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            WiretablesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
