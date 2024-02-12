<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('member_name');
            $table->string('member_email');
            $table->string('member_number');

            $table->unsignedBigInteger('mess_id');
            $table->foreign('mess_id')->references('id')->on('mess')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member', function (Blueprint $table){
            $table->dropForeign(['mess_id']);
        });
        Schema::dropIfExists('member');
    }
};
