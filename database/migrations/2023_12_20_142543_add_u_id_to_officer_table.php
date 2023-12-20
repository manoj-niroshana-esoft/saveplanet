<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUIdToOfficerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('officer', function (Blueprint $table) {
            $table->unsignedBigInteger('u_id')->nullable()->after('officer_id');
            $table->foreign('u_id')->references('u_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('officer', function (Blueprint $table) {
            $table->dropColumn('u_id');
        });
    }
}
