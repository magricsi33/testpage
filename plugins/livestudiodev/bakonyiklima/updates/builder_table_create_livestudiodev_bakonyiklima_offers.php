<?php namespace Livestudiodev\Bakonyiklima\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevBakonyiklimaOffers extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_bakonyiklima_offers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('email');
            $table->string('company');
            $table->string('name');
            $table->string('phone');
            $table->string('tax_number');
            $table->string('site');
            $table->boolean('callback');
            $table->integer('quantity');
            $table->text('content');
            $table->integer('product_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_bakonyiklima_offers');
    }
}
