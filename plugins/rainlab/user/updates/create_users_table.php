<?php namespace RainLab\User\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('activation_code')->nullable()->index();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable()->index();
            $table->text('permissions')->nullable();
            $table->boolean('is_activated')->default(0);
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_address_type')->nullable();
            $table->string('billing_house_number')->nullable();
            $table->string('billing_floor')->nullable();
            $table->string('billing_door')->nullable();
            $table->string('billing_company_number')->nullable();
            $table->string('trans_name')->nullable();
            $table->string('trans_email')->nullable();
            $table->string('trans_phone')->nullable();
            $table->string('trans_zip')->nullable();
            $table->string('trans_city')->nullable();
            $table->string('trans_address')->nullable();
            $table->string('trans_address_type')->nullable();
            $table->string('trans_house_number')->nullable();
            $table->string('trans_floor')->nullable();
            $table->string('trans_door')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }

}
