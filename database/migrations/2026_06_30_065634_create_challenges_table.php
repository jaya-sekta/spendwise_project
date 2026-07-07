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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id(); // PK id INT [cite: 51, 52]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id INT [cite: 55, 56]
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // FK category_id INT [cite: 59, 60]
            $table->date('start_date'); // start_date DATE [cite: 65, 66]
            $table->date('end_date'); // end_date DATE [cite: 72, 73]
            $table->integer('remaining_lives'); 
            $table->enum('status', ['active', 'successful', 'failed']); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
