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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // PK id INT [cite: 42, 43]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id INT [cite: 45, 46]
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // FK category_id INT [cite: 49, 50]
            $table->string('expense_name'); // expense_name STRING [cite: 53, 54]
            $table->integer('amount'); // amount INT [cite: 57, 58]
            $table->date('expense_date'); // expense_date DATE [cite: 63, 64]
            $table->boolean('is_over_limit')->default(false); // is_over_limit BOOLEAN [cite: 70, 71]
            $table->timestamps(); // created_at & updated_at TIMESTAMP [cite: 75, 76, 79, 80]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
