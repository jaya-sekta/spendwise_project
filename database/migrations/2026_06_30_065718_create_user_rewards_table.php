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
         Schema::create('user_rewards', function (Blueprint $table) {
            $table->id(); // PK id INT [cite: 28, 29]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id INT [cite: 34, 35]
            $table->foreignId('reward_id')->constrained('rewards')->onDelete('cascade'); // FK reward_id INT [cite: 38, 39, 40]
            $table->date('redemption_date'); // redemption_date DATE [cite: 94, 95]
            $table->string('voucher_code')->unique(); // voucher_code STRING [cite: 96, 97]
            $table->timestamps(); // created_at & updated_at TIMESTAMP [cite: 98, 99, 100, 101]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
