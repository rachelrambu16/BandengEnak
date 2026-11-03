<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_order_id')->nullable()->unique()->after('status');
            $table->string('payment_status')->default('pending')->after('payment_order_id');
            $table->string('payment_type')->nullable()->after('payment_status');
            $table->timestamp('payment_expires_at')->nullable()->after('payment_type');
            $table->string('payment_token')->nullable()->after('payment_expires_at');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_order_id',
                'payment_status',
                'payment_type',
                'payment_expires_at',
                'payment_token',
            ]);
        });
    }
};
