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
        Schema::create('mess', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('mess_name');
            $table->string('mess_email');

            $table->date('joining_date');
            $table->date('last_payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mess');
    }
};
