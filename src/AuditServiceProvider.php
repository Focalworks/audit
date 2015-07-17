<?php
namespace Focalworks\Audit;

use Illuminate\Support\ServiceProvider;

class AuditServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('audit', function ($app) {
            return new Audit;
        });
    }

    public function boot()   
    {
        // loading the routes from the routes file.
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        // publishing the migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/2015_07_15_095544_create_version_info_table.php' => base_path('database/migrations/2015_07_15_095544_create_version_info_table.php'),
        ]);
    }
}

