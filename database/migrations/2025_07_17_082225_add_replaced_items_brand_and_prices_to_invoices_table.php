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
        Schema::table('invoices', function (Blueprint $table) {
            $table->json('replaced_items_brand')->nullable();
            $table->json('replaced_items_prices')->nullable();
            $table->decimal('repair_cost', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('replaced_items_brand');
            $table->dropColumn('replaced_items_prices');
            $table->dropColumn('repair_cost');
        });
    }
};
