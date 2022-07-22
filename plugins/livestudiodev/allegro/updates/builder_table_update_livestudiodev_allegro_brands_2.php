<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroBrands2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_brands', function($table)
        {
            $table->string('link')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_brands', function($table)
        {
            $table->dropColumn('link');
        });
    }
}
