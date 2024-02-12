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
        Schema::create('bazar', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('bazar_date');
            $table->string('bazar_amount');

            $table->unsignedBigInteger('mess_id');
            $table->foreign('mess_id')->references('id')->on('mess')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bazar', function (Blueprint $table){
            $table->dropForeign(['mess_id']);
        });
        Schema::dropIfExists('bazar');
    }
};
