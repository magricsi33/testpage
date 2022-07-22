<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCarts3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->boolean('isorder')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->dropColumn('isorder');
        });
    }
}
