<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_employees', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("state")->default(1);
            $table->unsignedBigInteger("service_id");
            $table->foreign("service_id")->references("id")->on("services");
            $table->unsignedBigInteger("employee_id");
            $table->foreign("employee_id")->references("id")->on("employees");
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
        Schema::dropIfExists('service_employees');
    }
}
