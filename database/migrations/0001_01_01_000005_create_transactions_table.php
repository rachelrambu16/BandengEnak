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
        Schema::create('transaksi_pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->constrained('user', 'id_user')->onUpdate('cascade')->onDelete('restrict');
            $table->enum('status_pesanan', ['menunggu_pembayaran', 'dikemas', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');
            $table->enum('status_pembayaran', ['menunggu', 'dibayar', 'gagal', 'kadaluarsa'])->default('menunggu');
            $table->text('alamat_kirim');
            $table->dateTime('tanggal_pesan')->useCurrent();
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->string('metode_pembayaran', 100)->nullable();
            $table->string('nomor_va', 50)->nullable();
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->string('id_pg', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pesanan');
    }
};
