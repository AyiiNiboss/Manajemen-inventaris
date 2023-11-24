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
        Schema::create('tb_detail_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangkeluar_id')->nullable();
            $table->foreign('barangkeluar_id')->references('id')->on('tb_barang_keluar')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('id')->on('tb_barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_detail_barang_keluar');
    }
};
