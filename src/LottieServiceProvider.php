<?php

namespace Pys\Lottie;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LottieServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->registerCommands();
        }
    }

    public function register()
    {
        $this->registerConfig();
        $this->registerLottieSingleton();
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/lottie.php' => config_path('lottie.php'),
        ], 'lottie-config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/lottie'),
        ], 'lottie-asset');
    }

    protected function registerCommands()
    {
        $this->commands([
            Console\PublishCommand::class
        ]);
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lottie.php', 'lottie');
    }

    protected function registerLottieSingleton()
    {
        $this->app->singleton('lottie', LottieManager::class);

        $this->callAfterResolving(BladeCompiler::class, function ($view, Application $app) {
            $app->make('lottie')->registerComponents();
        });
    }
}
