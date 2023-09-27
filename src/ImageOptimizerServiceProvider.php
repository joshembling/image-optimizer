<?php

namespace Joshembling\ImageOptimizer;

use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Joshembling\ImageOptimizer\Components\BaseFileUpload as CustomBaseFileUpload;
use Joshembling\ImageOptimizer\Components\SpatieMediaLibraryFileUpload as CustomSpatieMediaLibraryFileUpload;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImageOptimizerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'image-optimizer';

    public function boot()
    {
        AliasLoader::getInstance()->alias(BaseFileUpload::class, CustomBaseFileUpload::class);
        AliasLoader::getInstance()->alias(SpatieMediaLibraryFileUpload::class, CustomSpatieMediaLibraryFileUpload::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('joshembling/image-optimizer');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }
    }

    public function packageBooted(): void
    {
        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/image-optimizer/{$file->getFilename()}"),
                ], 'image-optimizer-stubs');
            }
        }
    }
}
