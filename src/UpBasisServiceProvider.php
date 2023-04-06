<?php

namespace Lexxsoft\Upbasis;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Lexxsoft\Upbasis\Console\Commands\Extract;
use Lexxsoft\Upbasis\Console\Commands\Generate;
use Lexxsoft\Upbasis\Console\Commands\Hello;
use Lexxsoft\Upbasis\Console\Commands\Init;
use Lexxsoft\Upbasis\Console\Commands\Required;
use Lexxsoft\Upbasis\Http\Middleware\ParseOdataRequest;

class UpBasisServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'up');

        $kernel->pushMiddleware(ParseOdataRequest::class);

        $this->loadMigrationsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Database/Migrations');
        if (!config('filesystems.disks.tmp')) {
            app()->config["filesystems.disks.tmp"] = [
                'driver' => 'local',
                'root' => storage_path('tmp'),
                'throw' => false,
            ];
        }

        if (!config('modules.activators.up_database')) {
            app()->config["modules.activators.up_database"] = [
                'class' => \Lexxsoft\Upbasis\Support\DatabaseModuleActivator::class,
                'cache-key' => 'activator.installed',
                'cache-lifetime' => 5184000,
            ];
        }
        if (!(config('modules.activator') && config('modules.activator') == 'up_database')) {
            app()->config["modules.activator"] = 'up_database';
        }

        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    Generate::class,
                    Hello::class,
                    Required::class,
                    Extract::class,
                    Init::class,
                ],
            );

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('up.php'),
            ], 'config');
        }
    }
}
