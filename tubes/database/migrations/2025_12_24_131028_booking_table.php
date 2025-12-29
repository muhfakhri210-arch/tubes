<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id_booking');
            $table->unsignedInteger('id_katalog');
            $table->unsignedInteger('id_customer');
            $table->string('status_pembayaran', 50);
            $table->date('tanggal_invoice');
            $table->decimal('total_pembayaran', 12,2 );
            $table->timestamps();

            $table->foreign('id_katalog')->references('id_katalog')->on('katalog');
            $table->foreign('id_customer')->references('id_customer')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
