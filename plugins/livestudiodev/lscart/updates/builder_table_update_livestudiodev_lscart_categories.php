<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCategories extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_categories', function($table)
        {
            $table->date('min_day')->nullable();
            $table->time('max_time')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_categories', function($table)
        {
            $table->dropColumn('min_day');
            $table->dropColumn('max_time');
        });
    }
}
