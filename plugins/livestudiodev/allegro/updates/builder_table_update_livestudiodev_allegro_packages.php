<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroPackages extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->string('name');
            $table->text('description')->default(null)->change();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_packages', function($table)
        {
            $table->dropColumn('name');
            $table->text('description')->default('NULL')->change();
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
        });
    }
}
