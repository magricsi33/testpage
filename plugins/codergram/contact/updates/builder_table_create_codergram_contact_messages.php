<?php namespace Codergram\Contact\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramContactMessages extends Migration
{
    public function up()
    {
        Schema::create('codergram_contact_messages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('comment')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_contact_messages');
    }
}
