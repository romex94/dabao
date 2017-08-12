<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->integer('chef_id')->nullable();
            $table->string('chef_name')->nullable();
            $table->string('chef_address')->nullable();
            $table->string('chef_longitude')->nullable();
            $table->string('chef_latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn(['chef_name', 'chef_address', 'chef_id', 'chef_longitude', 'chef_latitude']);
        });
    }
}
