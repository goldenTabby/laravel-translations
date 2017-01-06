<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsI18nTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('translations_i18n', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id')->unsigned();
            $table->string('text');
            $table->string('lang', 2);

            $table->primary([ 'id', 'lang' ], 'translations_i18n_primary');

            $table->foreign('id')->references('id')->on('translations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('translations_i18n');
    }
}