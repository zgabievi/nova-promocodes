<?php

namespace Aberbin96\NovaPromocodes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Aberbin96\NovaPromocodes\Http\Middleware\Authorize;
use Aberbin96\NovaPromocodes\Resources\Promocode;
use Aberbin96\NovaPromocodes\Resources\PromocodeBatch;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->publishes([
            __DIR__ . '/../config/nova-promocodes-4.php' => config_path('promocodes.php'),
        ], 'config');


        $this->publishes([
            __DIR__ . '/../database/migrations/create_promocodes_table.php.stub' => database_path('migrations/' . date('Y_m_d_Hi') . '00_create_promocodes_table.php'),
            __DIR__ . '/../database/migrations/create_promocode_user_table.php.stub' => database_path('migrations/' . date('Y_m_d_Hi') . '01_create_promocode_user_table.php'),
        ], 'migrations');

        $this->app->booted(function () {
            Nova::resources([
                Promocode::class,
                PromocodeBatch::class,
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

        Nova::router(['nova', Authenticate::class, Authorize::class], 'promocodes-4')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/promocodes-4')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-promocodes-4.php', 'nova-promocodes-4');
    }
}
