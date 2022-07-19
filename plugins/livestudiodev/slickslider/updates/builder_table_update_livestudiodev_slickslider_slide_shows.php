<?php namespace LivestudioDev\SlickSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevSlicksliderSlideShows extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->boolean('autoplay')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->dropColumn('autoplay');
        });
    }
}
