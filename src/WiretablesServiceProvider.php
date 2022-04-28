<?php

namespace Sashalenz\Wiretables;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WiretablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wiretables')
            ->hasConfigFile()
            ->hasViews();
    }
}
