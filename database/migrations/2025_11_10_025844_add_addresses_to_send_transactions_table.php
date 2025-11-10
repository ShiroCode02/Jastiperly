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
        Schema::table('send_transactions', function (Blueprint $table) {
            $table->text('pickup_address')->after('dimension')->nullable();
            $table->text('delivery_address')->after('pickup_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('send_transactions', function (Blueprint $table) {
            $table->dropColumn(['pickup_address', 'delivery_address']);
        });
    }
};
