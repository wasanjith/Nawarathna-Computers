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
        Schema::create('check_lists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('repair_id')->constrained('repairs')->onDelete('cascade');

            $table->enum('processor', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('motherboard', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('ram', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('hard_disk_1', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('hard_disk_2', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('optical_drive', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('network', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            $table->enum('wifi', ['not_testes','working','replaced','removed','installed'])->default('not_testes');  
            $table->enum('camera', ['not_testes','working','replaced','removed','installed'])->default('not_testes');  

            $table->enum('hinges', ['not_testes','working','replaced','removed','installed'])->default('not_testes');  
            $table->enum('laptopSPK', ['not_testes','working','replaced','removed','installed'])->default('not_testes');  
            $table->enum('mic', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('touchPad', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('keyboard', ['not_testes','working','replaced','removed','installed'])->default('not_testes');

            $table->enum('frontUSB', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('rearUSB', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('frontSound', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('rearSound', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('vgaPort', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('hdmiPort', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('hardHealth', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('stressTest', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('benchMark', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('powerCable_1', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('powerCable_2', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('vgaCable', ['not_testes','working','replaced','removed','installed'])->default('not_testes'); 
            $table->enum('dviCable', ['not_testes','working','replaced','removed','installed'])->default('not_testes');
            
            $table->enum('backpanelnuts', ['yes','no'])->default('yes'); 
            $table->integer('nutQty')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_lists');
    }
};
