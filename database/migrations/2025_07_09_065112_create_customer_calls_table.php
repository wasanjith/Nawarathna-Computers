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
        Schema::create('customer_calls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->dateTime('called_at');
            $table->enum('status', ['answered', 'no_answer', 'busy', 'switched_off'])->default('answered');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_calls');
    }
};
