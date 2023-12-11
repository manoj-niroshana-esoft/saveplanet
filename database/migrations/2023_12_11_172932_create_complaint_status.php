<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_status', function (Blueprint $table) {
            $table->bigIncrements('complaint_status_id');
            $table->unsignedBigInteger('complaint_id')->nullable();
            $table->foreign('complaint_id')->references('complaint_id')->on('complaint');
            $table->integer('status')->comment('1->pending, 2->Waiting for assign officer, 3->officer allocated, 4->Ongoing, 5->Complete');
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
        Schema::dropIfExists('complaint_status');
    }
}
