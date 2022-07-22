<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCategories2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_categories', function($table)
        {
            $table->integer('min_day')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_categories', function($table)
        {
            $table->date('min_day')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
