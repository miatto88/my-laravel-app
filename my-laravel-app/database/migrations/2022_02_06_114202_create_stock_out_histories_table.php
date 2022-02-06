<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_out_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->integer('member_id');
            $table->integer('customer_id');
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
            $table->timestamps('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_out_histories');
    }
}
