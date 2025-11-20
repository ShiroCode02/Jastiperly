<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buy_transactions', function (Blueprint $table) {
            $table->enum('delivery_type', ['Dalam Negeri', 'Luar Negeri'])
                  ->default('Dalam Negeri')
                  ->after('total_price');
        });
    }

    public function down(): void
    {
        Schema::table('buy_transactions', function (Blueprint $table) {
            $table->dropColumn('delivery_type');
        });
    }
};
