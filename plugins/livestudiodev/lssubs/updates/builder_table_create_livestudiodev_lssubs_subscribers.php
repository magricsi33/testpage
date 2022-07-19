<?php namespace LivestudioDev\LSSubs\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudioDevLssubsSubscribers extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lssubs_subscribers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livestudiodev_lssubs_subscribers');
    }
}
