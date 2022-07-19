<?php namespace LivestudioDev\LSSubs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudioDevLssubsSubscribersThemes extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lssubs_subscribers_themes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('theme_id')->unsigned();
            $table->integer('subscriber_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livestudiodev_lssubs_subscribers_themes');
    }
}
