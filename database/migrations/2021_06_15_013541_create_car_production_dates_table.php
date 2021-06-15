<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarProductionDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_production_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type_id');
            $table->date('created_at');
            $table->foreign('type_id')
                ->references('id')
                ->on('car_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_production_dates');
    }
}
