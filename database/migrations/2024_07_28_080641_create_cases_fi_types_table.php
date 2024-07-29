<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesFiTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases_fi_types', function (Blueprint $table) {
            $table->id();
            $table->integer('case_id');
            $table->integer('fi_type_id');
            $table->integer('mobile');
            $table->text('address');
            $table->integer('pincode');
            $table->text('land_mark');
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
        Schema::dropIfExists('cases_fi_types');
    }
}
