<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('officer', function (Blueprint $table) {
            $table->bigIncrements('officer_id');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('level_id')->on('officer_level');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('branch_id')->on('branch');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('admin_u_id')->on('admin');
            $table->string('name');
            $table->string('nic');
            $table->string('address');
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
        Schema::dropIfExists('officer');
    }
}
