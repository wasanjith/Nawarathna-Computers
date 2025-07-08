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

            $table->enum('processor', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('motherboard', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('ram', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('hard_disk_1', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('hard_disk_2', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('optical_drive', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('network', ['not_tested','working','replaced','removed','installed'])->default('not_tested');
            $table->enum('wifi', ['not_tested','working','replaced','removed','installed'])->default('not_tested');  
            $table->enum('camera', ['not_tested','working','replaced','removed','installed'])->default('not_tested');  

            $table->enum('hinges', ['not_tested','working','replaced','removed','installed'])->default('not_tested');  
            $table->enum('laptopSPK', ['not_tested','working','replaced','removed','installed'])->default('not_tested');  
            $table->enum('lapCamera', ['not_tested','working','replaced','removed','installed'])->default('not_tested');  
            $table->enum('mic', ['not_tested','working','replaced','removed','installed'])->default('not_tested'); 
            $table->enum('touchPad', ['not_tested','working','replaced','removed','installed'])->default('not_tested'); 
            $table->enum('keyboard', ['not_tested','working','replaced','removed','installed'])->default('not_tested');

            $table->enum('frontUSB', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('rearUSB', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('frontSound', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('rearSound', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('vgaPort', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('hdmiPort', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('hardHealth', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('stressTest', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('benchMark', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('powerCable_1', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('powerCable_2', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('vgaCable', ['not_tested','working','not_working','removed','installed'])->default('not_tested'); 
            $table->enum('dviCable', ['not_tested','working','not_working','removed','installed'])->default('not_tested');
            
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
