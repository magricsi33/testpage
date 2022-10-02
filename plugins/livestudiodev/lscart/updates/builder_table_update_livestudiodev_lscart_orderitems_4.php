<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrderitems4 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->decimal('quantity', 10, 2)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->integer('quantity')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
