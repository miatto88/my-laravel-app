<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_in_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->integer('member_id');
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
        Schema::dropIfExists('stock_in_histories');
    }
}
