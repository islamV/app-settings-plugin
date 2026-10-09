<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin;

use Islamv\AppSettingsPlugin\Commands\MakeSettingsPageCommand;
use Islamv\AppSettingsPlugin\Commands\MakeSettingsSubTabCommand;
use Islamv\AppSettingsPlugin\Commands\MakeSettingsTabCommand;
use Islamv\AppSettingsPlugin\Registry\SettingsRegistry;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AppSettingsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'app-settings';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile('app-settings')
            ->hasTranslations()
            ->hasViews()
            ->hasCommands([
                MakeSettingsTabCommand::class,
                MakeSettingsSubTabCommand::class,
                MakeSettingsPageCommand::class,
            ]);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(SettingsRegistry::class, fn () => new SettingsRegistry);
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs' => base_path('stubs/app-settings'),
            ], 'app-settings-stubs');
        }
    }
}
