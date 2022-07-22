<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevAllegroUsageTypes extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_allegro_usage_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->boolean('active');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_allegro_usage_types');
    }
}
