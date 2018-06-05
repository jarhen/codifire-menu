<?php

namespace Jarhen\Menu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
                require  __DIR__.'/routes.php';
        }

        $this->publishes([
            __DIR__.'/../config/menu.php'  => config_path('menu.php'),
        ], 'config');

        $this->publishes([
           __DIR__.'/Views'   => resource_path('views/vendor/jarhen-menu'),
        ], 'view');

         $this->publishes([
            __DIR__.'/../assets' => public_path('vendor/jarhen-menu'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../migrations/2017_08_11_073824_create_menus_wp_table.php' => database_path('migrations/2017_08_11_073824_create_menus_wp_table.php'),
            __DIR__.'/../migrations/2017_08_11_074006_create_menu_items_wp_table.php' => database_path('migrations/2017_08_11_074006_create_menu_items_wp_table.php'),
        ], 'migrations');
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('jarhen-menu', function() {
            return new WMenu();
        });

        $this->app->make('Jarhen\Menu\Controllers\MenuController');
        $this->loadViewsFrom(__DIR__.'/views', 'wmenu');

    }
}
