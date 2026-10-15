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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->foreignId('id_pesanan')->constrained('transaksi_pesanan', 'id_pesanan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('produk', 'id_produk')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('jumlah_pesanan');
            $table->enum('jenis_pengemasan', ['plastik', 'vakum'])->default('plastik');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
