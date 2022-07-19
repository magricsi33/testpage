<?php namespace Codergram\Novak\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramNovakNotifications extends Migration
{
    public function up()
    {
        Schema::create('codergram_novak_notifications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('saw')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_novak_notifications');
    }
}