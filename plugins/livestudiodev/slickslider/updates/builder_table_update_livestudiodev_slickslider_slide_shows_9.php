<?php namespace LivestudioDev\SlickSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevSlicksliderSlideShows9 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->string('slide_show_height', 10)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {

        });
    }
}
