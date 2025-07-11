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
            // Rename 'device_id' to 'repair_id'
            $table->dropColumn('issued_at');
            $table->dropColumn('paid_at');
            $table->dropColumn('link_path');
            // new columns replaced_items array
            $table->json('replaced_items')->nullable();
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->foreign('checklist_id')
                ->references('id')
                ->on('checklists')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Add back the dropped columns
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('link_path')->nullable();

            // Drop the added columns and foreign key
            $table->dropForeign(['checklist_id']);
            $table->dropColumn('checklist_id');
            $table->dropColumn('replaced_items');
        });
    }
};
