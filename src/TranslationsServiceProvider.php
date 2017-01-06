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
        //t('test');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {

    }
}
