<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_detail', function (Blueprint $table) {
            $table->bigIncrements('complaint_detail_id');
            $table->unsignedBigInteger('complaint_id')->nullable();
            $table->foreign('complaint_id')->references('complaint_id')->on('complaint');
            $table->string('location');
            $table->string('picture_of_evidence');
            $table->string('timeframe');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_detail');
    }
}
