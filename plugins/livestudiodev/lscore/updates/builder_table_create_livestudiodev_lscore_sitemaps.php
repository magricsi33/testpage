<?php namespace LivestudioDev\Lscore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscoreSitemaps extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscore_sitemaps', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('tags');
            $table->text('filename');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscore_sitemaps');
    }
}
