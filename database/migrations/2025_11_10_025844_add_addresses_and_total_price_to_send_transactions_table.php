<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('send_transactions', function (Blueprint $table) {
            // Tambahan alamat (sudah ada)
            $table->text('pickup_address')->after('weight')->nullable();
            $table->text('delivery_address')->after('pickup_address')->nullable();

            // KOLOM BARU: total_price (sama persis seperti buy_transactions)
            $table->decimal('total_price', 15, 2)->default(0)->after('delivery_image');
        });
    }

    public function down(): void
    {
        Schema::table('send_transactions', function (Blueprint $table) {
            $table->dropColumn(['pickup_address', 'delivery_address', 'total_price']);
        });
    }
};