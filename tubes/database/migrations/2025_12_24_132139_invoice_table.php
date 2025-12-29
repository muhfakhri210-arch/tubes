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
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id_invoice');
            $table->unsignedInteger('id_booking');
            $table->date('tanggal_invoice');
            $table->decimal('Total_pembayaran', 12,2);
            $table->string('status_pembayaran', 50);
            $table->timestamps();

            $table->foreign('id_booking')->references('id_booking')->on('booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
