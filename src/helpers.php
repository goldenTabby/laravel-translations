<?php

use Illuminate\Support\Facades\Cache;
use Tabby\Translations\Models\Translation;

if ( ! function_exists('t')) {
    function t($key, $default = null, $params = [ ])
    {
        $data = Cache::remember('tabby_translations', 60 * 24, function () {
            $translations = Translation::with('i18n')->get();
            $result       = [ ];
            foreach ($translations as $translation) {
                $result[$translation->key]['id'] = $translation->id;
                foreach ($translation->translations as $translation_i18n) {
                    $result[$translation->key][$translation_i18n->lang] = $translation_i18n->text;
                }
            }

            return $result;
        });

        if (array_key_exists($key, $data) && array_key_exists(app()->getLocale(), $data[$key])) {
            $translation = $data[$key][app()->getLocale()];
            if (is_array($default) && ! empty( $default )) {
                $params = $default;
            }

            if ( ! empty( $params )) {
                if ( ! is_null($default) && ! is_array($default)) {
                    $translation = $default;
                }

                foreach ($params as $param => $value) {
                    $translation = str_replace(':' . $param, $value, $translation);
                }
            }
        }

        if ( ! is_null($default) && ! is_array($default)) {
            return $default;
        }

        return $key;
    }
}
