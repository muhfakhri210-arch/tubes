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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->increments('id_ulasan');
            $table->unsignedInteger('id_customer');
            $table->string('nama');
            $table->string('email');
            $table->integer('rating'); 
            $table->longText('komentar')->nullable();
            $table->timestamps();

            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
