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
        Schema::create('technictions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            //phone
            $table->string('phone')->nullable();
            //repair_id
            
            $table->foreignId('repair_id')->nullable()->constrained('repairs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technictions');
        Schema::table('technictions', function (Blueprint $table) {
            $table->dropForeign(['repair_id']);
            $table->dropColumn('repair_id');
        });
    }
};
