<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_log', function (Blueprint $table) {
            $table->bigIncrements('audit_log_id');
            $table->unsignedBigInteger('u_id')->nullable();
            $table->foreign('u_id')->references('u_id')->on('users');
            $table->string('section_name');
            $table->string('action');
            $table->text('previous_records');
            $table->text('new_records');
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
        Schema::dropIfExists('audit_log');
    }
}
