<?php namespace Livestudiodev\Bakonyiklima\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevBakonyiklimaOffers2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_bakonyiklima_offers', function($table)
        {
            $table->string('product', 191)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_bakonyiklima_offers', function($table)
        {
            $table->string('product', 10)->change();
        });
    }
}
