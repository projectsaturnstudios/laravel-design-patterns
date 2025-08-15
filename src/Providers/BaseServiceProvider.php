<?php

namespace ProjectSaturnStudios\LaravelDesignPatterns\Providers;

use Carbon\Laravel\ServiceProvider;
use ProjectSaturnStudios\LaravelDesignPatterns\Contracts\LaravelServiceProvider;
use ProjectSaturnStudios\LaravelDesignPatterns\DataTransferObjects\PublishableConfig;

class BaseServiceProvider extends ServiceProvider implements LaravelServiceProvider
{
    protected array $config = [];
    protected array $routes = [];
    protected array $commands = [];
    protected array $bootables = [];
    protected array $publishable_config = [];


    public function register(): void
    {
        $this->registerConfigs();
    }

    public function boot(): void
    {
        $this->beforeMainBooted();
        $this->publishConfigs();
        $this->registerBootables();
        $this->registerCommands();
        $this->mainBooted();
        $this->registerRoutes();
    }

    protected function beforeMainBooted(): void
    {
        // This method can be overridden by child classes to perform actions after the service provider has booted.
    }

    protected function mainBooted(): void
    {
        // This method can be overridden by child classes to perform actions after the service provider has booted.
    }

    protected function registerConfigs() : void
    {
        foreach ($this->config as $key => $path) {
            $this->mergeConfigFrom($path, $key);
        }
    }

    protected function registerCommands(): void
    {
        $this->commands($this->commands);
    }

    protected function registerBootables(): void
    {
        foreach($this->bootables as $bootable) {
            if (method_exists($bootable, 'boot')) $bootable::boot();
        }
    }

    protected function registerRoutes():  void
    {
        foreach($this->routes as $routes_file)
        {
            $this->loadRoutesFrom($routes_file);
        }
    }

    public function publishableConfigs(): array
    {
        return array_map(fn($config) => PublishableConfig::from($config), $this->publishable_config);
    }

    protected function publishConfigs() : void
    {
        foreach($this->publishableConfigs() as $publishable_config)
        {
            /** @var PublishableConfig $config */
            $this->publishes([
                $this->config[$publishable_config->key] => config_path($publishable_config->file_path),
            ], $publishable_config->groups);

        }
    }
}
