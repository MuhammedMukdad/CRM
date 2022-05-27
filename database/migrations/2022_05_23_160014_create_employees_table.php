<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->integer("phone")->unique();
            $table->string("address");
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('isAdmin')->default(0);
            $table->text("description")->nullable();
            $table->unsignedBigInteger("department_id");
            $table->foreign("department_id")->references("id")->on("departments");
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
        Schema::dropIfExists('employees');
    }
}
