<?php namespace LivestudioDev\Allegro\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevAllegroCities extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_allegro_cities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('postcode');
            $table->string('name');
            $table->double('latitude', 10, 0);
            $table->double('longitude', 10, 0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_allegro_cities');
    }
}
