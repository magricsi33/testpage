<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevAllegroTagsToProducts extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_allegro_tags_to_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('tag_id');
            $table->integer('product_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_allegro_tags_to_products');
    }
}
