<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevAllegroQuestions extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_allegro_questions', function($table)
        {
            $table->integer('product_id');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_allegro_questions', function($table)
        {
            $table->dropColumn('product_id');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
        });
    }
}
