<?php namespace Tabby\Translations\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Tabby\Translations\Models\Translation;

class Translations
{
    /**
     * Translations constructor.
     *
     * @param Translation $translations
     */
    public function __construct(Translation $translations)
    {
        $this->translations = $translations;
    }

    /**
     * @param       $key
     * @param null  $default
     * @param array $params
     *
     * @return mixed
     */
    public function get($key, $default = null, $params = [ ])
    {
        $translations = $this->getAll();

        if ($this->checkKeyExists($key, $translations)) {
            $translation = $translations[$key][app()->getLocale()];

            if (is_array($default) && ! empty( $default )) {
                $params = $default;
            }

            if ( ! empty( $params )) {
                if ( ! is_null($default) && ! is_array($default)) {
                    $translation = $default;
                }

                $translation = $this->processParams($translation, $params);
            }

            return $translation;
        }

        return $key;
    }

    /**
     * Return all translations from cache.
     * @return mixed
     */
    public function getAll()
    {
        $cacheKey  = config('translations.cache.key');
        $cacheTime = config('translations.cache.time');

        return cache()->remember($cacheKey, $cacheTime, function () {
            $translations = $this->translations->with('i18n')->get();

            return $this->format($translations);
        });
    }

    /**
     * Check translation key exists in translations data
     *
     * @param $translationKey
     * @param $translations
     *
     * @return bool
     */
    public function checkKeyExists($translationKey, $translations)
    {
        return ( $translations->has($translationKey) && $translations->get($translationKey)->has(app()->getLocale()) );
    }

    /**
     * Process translation string with params.
     *
     * @param $translation
     * @param $params
     *
     * @return mixed
     */
    private function processParams($translation, $params)
    {
        foreach ($params as $param => $value) {
            $translation = str_replace(':' . $param, $value, $translation);
        }

        return $translation;
    }

    /**
     * Format collection.
     *
     * @param $translations
     *
     * @return array
     */
    private function format($translations)
    {
        $formatted = collect([ ]);
        $translations->each(function ($translation) use ($formatted) {
            $translation->i18n->each(function ($translationI18n) use ($translation, $formatted) {
                $formatted->put($translation->key, collect([ $translationI18n->lang => $translationI18n->text ]));
            });
        });

        return $formatted;
    }
}