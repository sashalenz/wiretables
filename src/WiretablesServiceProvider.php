<?php

namespace Sashalenz\Wiretables;

use Livewire\Livewire;
use Sashalenz\Wiretables\Modals\DeleteModal;
use Sashalenz\Wiretables\Modals\RestoreModal;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WiretablesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wiretables')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        Livewire::component(DeleteModal::getName(), DeleteModal::class);
        Livewire::component(RestoreModal::getName(), RestoreModal::class);
    }
}
