<?php namespace Livestudiodev\Bakonyiklima\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevBakonyiklimaOffers extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_bakonyiklima_offers', function($table)
        {
            $table->string('product', 10);
            $table->dropColumn('product_id');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_bakonyiklima_offers', function($table)
        {
            $table->dropColumn('product');
            $table->integer('product_id');
        });
    }
}
