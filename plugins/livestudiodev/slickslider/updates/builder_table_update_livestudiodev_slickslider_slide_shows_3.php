<?php namespace LivestudioDev\SlickSlider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevSlicksliderSlideShows3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->dropColumn('slug');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_slickslider_slide_shows', function($table)
        {
            $table->string('slug', 255)->nullable();
        });
    }
}
