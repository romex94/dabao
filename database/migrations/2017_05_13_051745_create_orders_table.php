<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->rememberToken();
            $table->timestamps();
            $table->dateTime('deliver_date');     
            $table->integer('chef_id')->nullable();
            $table->float('total')->nullable();
            $table->string('status')->default("search_driver");
            $table->integer('driver_id')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExist('orders');
    }
}
