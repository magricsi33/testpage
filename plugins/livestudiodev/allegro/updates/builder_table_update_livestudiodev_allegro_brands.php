<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroBrands extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_brands', function($table)
        {
            $table->string('slug')->nullable();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->boolean('active')->default(1);
            $table->boolean('searchable')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_brands', function($table)
        {
            $table->dropColumn('slug');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('active');
            $table->dropColumn('searchable');
        });
    }
}