<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrders4 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->date('delivery_date')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->dropColumn('delivery_date');
        });
    }
}
