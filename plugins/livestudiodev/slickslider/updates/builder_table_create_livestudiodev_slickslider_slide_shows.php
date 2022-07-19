<?php namespace LivestudioDev\SlickSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevSlicksliderSlideShows extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slide_show_title')->nullable();
            $table->text('slide_show_content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_slickslider_slide_shows');
    }
}