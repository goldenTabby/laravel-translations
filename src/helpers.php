<?php

use Tabby\Translations\Services\Translations;

/**
 * Function for quick use on frontend.
 * Example in blade template: {{ t('pages.home.h1') }}
 */
if ( ! function_exists('t')) {
    function t($key, $default = null, $params = [ ])
    {
        if ( ! is_string($key)) {
            throw new \Exception;
        }

        if ( ! is_null($default) && ! is_array($default)) {
            return $default;
        }

        return app()->make(Translations::class)->get($key, $default, $params);
    }
}
