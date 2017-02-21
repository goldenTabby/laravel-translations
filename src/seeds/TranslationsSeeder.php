<?php namespace Tabby\Translations;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $id = DB::table('translations')->insertGetId([
            'key'        => 'test',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('translations_i18n')->insert([
            'id'   => $id,
            'text' => 'test',
            'lang' => app()->getLocale()
        ]);

        $id = DB::table('translations')->insertGetId([
            'key'        => 'test-with-params',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('translations_i18n')->insert([
            'id'   => $id,
            'text' => 'Translation with :param',
            'lang' => app()->getLocale()
        ]);
    }
}
