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
        Schema::create('deposit', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('deposit_date');
            $table->string('deposit_amount');

            $table->unsignedBigInteger('mess_id');
            $table->unsignedBigInteger('member_id');

            $table->foreign('mess_id')->references('id')->on('mess')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposit', function (Blueprint $table){
            $table->dropForeign(['mess_id']);
            $table->dropForeign(['member_id']);
        });
        Schema::dropIfExists('deposit');
    }
};
