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
         Schema::create('categories', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('category_name'); // category_name STRING [cite: 22]
            $table->integer('monthly_limit'); // monthly_limit INT [cite: 27]
            $table->enum('category_type', ['primary', 'consumptive']); // category_type ENUM [cite: 33]
            $table->timestamps(); // created_at & updated_at TIMESTAMP [cite: 36, 37, 89]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
