<?php namespace LivestudioDev\LSSubs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudioDevLssubsThemes extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lssubs_themes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('livestudiodev_lssubs_themes');
    }
}
