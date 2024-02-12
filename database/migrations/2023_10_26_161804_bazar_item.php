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
        Schema::create('bazar_item', function (Blueprint $table){
            $table->bigIncrements('id');

            $table->string('item_name');
            $table->string('item_amount');
            $table->string('item_quantity');

            $table->unsignedBigInteger('bazar_id');
            $table->foreign('bazar_id')->references('id')->on('bazar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bazar_item', function (Blueprint $table){
            $table->dropForeign(['bazar_id']);
        });
        Schema::dropIfExists('bazar_item');
    }
};
