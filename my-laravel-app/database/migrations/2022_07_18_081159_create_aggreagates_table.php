<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAggreagatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aggreagates', function (Blueprint $table) {
            $table->id();
            $table->integer("aggreacate_new_tasks")->default(0);
            $table->integer("aggreacate_complete_tasks")->default(0);
            $table->integer("aggreacate_incomplete_tasks")->default(0);
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
        Schema::dropIfExists('aggreagates');
    }
}
