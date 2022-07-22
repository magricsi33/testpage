<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroPackages5 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->boolean('active')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->dropColumn('active');
        });
    }
}
