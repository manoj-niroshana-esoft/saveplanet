<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint', function (Blueprint $table) {
            $table->bigIncrements('complaint_id');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->foreign('u_id')->references('u_id')->on('users');
            $table->unsignedBigInteger('institution_id')->nullable();
            $table->foreign('institution_id')->references('institution_id')->on('institution');
            $table->integer('complain_type')->comment('1->wildlife 2->forestry 3->env_crime	');
            $table->integer('complain_status')->comment('1->Complained,2->Officer Assigned, 3->Ongoing, 4->Completed');
            $table->string('description');
            $table->string('longitude');
            $table->string('latitude');
            $table->date('from_date');
            $table->time('from_time')->nullable();
            $table->date('to_date')->nullable();
            $table->time('to_time')->nullable();
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
        Schema::dropIfExists('complaint');
    }
}
