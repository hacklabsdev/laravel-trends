<?php

namespace Hacklabs\Trends;

use Illuminate\Support\ServiceProvider;
use Hacklabs\Trends\Trends;

class TrendsServiceProvider extends ServiceProvider 
{

    public function register () {
        $this->app->bind('trends', function() {
            return new Trends();
        });
    }

    public function boot () {

        $this->registerMigrations();

        $this->publishes([
            __DIR__.'/../migrations' => database_path('migrations')
        ], 'trends_migrations');

        $this->publishes([
            __DIR__.'/../config/trends.php' => config_path('trends.php')
        ]);
    }

    public function registerMigrations () {
        return $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
}