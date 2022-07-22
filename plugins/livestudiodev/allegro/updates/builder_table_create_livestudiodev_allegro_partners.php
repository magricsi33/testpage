<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevAllegroPartners extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_allegro_partners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->text('url');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_allegro_partners');
    }
}
