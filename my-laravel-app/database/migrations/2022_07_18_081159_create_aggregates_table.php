<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateaggregatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggregates', function (Blueprint $table) {
            $table->id();
            $table->integer("aggregate_new_task_count")->default(0);
            $table->integer("aggregate_complete_task_count")->default(0);
            $table->integer("aggregate_incomplete_task_count")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aggregates');
    }
}
