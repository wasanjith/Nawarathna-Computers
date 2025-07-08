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
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn(['estimated_cost', 'estimated_completion_at', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->timestamp('estimated_completion_at')->nullable();
            $table->timestamp('completed_at')->nullable();
        });
    }
};
