<?php

namespace Zorb\NovaPromocodes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Zorb\NovaPromocodes\Http\Middleware\Authorize;
use Zorb\NovaPromocodes\Resources\Promocode;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-promocodes');

        $this->publishes([
            __DIR__ . '/../config/nova-promocodes.php' => config_path('nova-promocodes.php'),
        ], 'config');

        $this->app->booted(function () {
            Nova::resources([
                Promocode::class,
            ]);

            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-api')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-promocodes.php', 'nova-promocodes');
    }
}
