<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_campaigns', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('source_campaigns');
    }
}
