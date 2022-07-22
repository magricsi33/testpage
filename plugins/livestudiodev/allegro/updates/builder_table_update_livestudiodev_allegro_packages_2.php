<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroPackages2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('description')->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->text('description')->default('NULL')->change();
        });
    }
}
