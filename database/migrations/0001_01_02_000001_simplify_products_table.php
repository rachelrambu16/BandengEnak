<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('produk', 'gambar_produk')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->renameColumn('gambar_produk', 'gambar');
            });
        }

        if (Schema::hasColumn('produk', 'stok_produk')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->renameColumn('stok_produk', 'stok');
            });
        }

        if (Schema::hasColumn('produk', 'ukuran_produk')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('ukuran_produk');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('produk', 'ukuran_produk')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->string('ukuran_produk', 50)->nullable();
            });
        }

        if (Schema::hasColumn('produk', 'gambar')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->renameColumn('gambar', 'gambar_produk');
            });
        }

        if (Schema::hasColumn('produk', 'stok')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->renameColumn('stok', 'stok_produk');
            });
        }
    }
};
