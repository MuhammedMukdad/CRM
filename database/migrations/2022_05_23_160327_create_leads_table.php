<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->integer("phone")->unique();
            $table->tinyInteger("seen")->default(0);
            $table->integer("profit_amount");
            $table->String("state");
            $table->string("address");
            $table->date("arrive_date");
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign("employee_id")->references("id")->on("employees");
            $table->text("description")->nullable();
            $table->unsignedBigInteger("service_id");
            $table->foreign("service_id")->references("id")->on("services");
            $table->unsignedBigInteger("source_id");
            $table->foreign("source_id")->references("id")->on("sources");
            $table->unsignedBigInteger("campaign_id");
            $table->foreign("campaign_id")->references("id")->on("campaigns");
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
        Schema::dropIfExists('leads');
    }
}
