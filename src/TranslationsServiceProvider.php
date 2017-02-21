<?php namespace Tabby\Translations;

use Illuminate\Support\ServiceProvider;

class TranslationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/config/translations.php' => config_path('translations.php')
        ]);
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {

    }
}
