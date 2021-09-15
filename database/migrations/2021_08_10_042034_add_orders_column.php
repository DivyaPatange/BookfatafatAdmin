<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdersColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function($table){
            $table->enum('is_ship', ['Yes', 'No'])->default('No');
            $table->datetime('dispatch_at')->nullable();
            $table->enum('is_deliver', ['Yes', 'No'])->default('No');
            $table->datetime('deliver_at')->nullable();
            $table->datetime('confirmed_at')->nullable();
            $table->datetime('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function($table){
            $table->dropColumn('is_ship');
            $table->dropColumn('is_deliver');
            $table->dropColumn('dispatch_at');
            $table->dropColumn('deliver_at');
            $table->dropColumn('confirmed_at');
            $table->dropColumn('rejected_at');
        });
    }
}
