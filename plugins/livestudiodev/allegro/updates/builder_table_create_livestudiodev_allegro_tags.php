<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevAllegroTags extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_allegro_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_allegro_tags');
    }
}
