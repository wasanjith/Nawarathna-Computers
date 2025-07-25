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
        Schema::table('check_lists', function (Blueprint $table) {
            $table->text('benchMark_note')->nullable()->after('benchMark');
            $table->text('stressTest_note')->nullable()->after('stressTest');
            $table->text('hardHealth_note')->nullable()->after('hardHealth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_lists', function (Blueprint $table) {
            $table->dropColumn(['benchMark_note', 'stressTest_note', 'hardHealth_note']);
        });
    }
}; 