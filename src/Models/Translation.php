<?php namespace Tabby\Translations\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 * @package Tabby\Translations
 */
class Translation extends Model
{
    protected $table = 'translations';

    /**
     * @return mixed
     */
    public function i18n()
    {
        return $this->hasMany(TranslationI18n::class, 'id', 'id');
    }
}
