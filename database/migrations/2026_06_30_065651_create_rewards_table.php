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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id(); // PK id INT [cite: 67, 68]
            $table->string('reward_name'); // reward_name STRING [cite: 74]
            $table->integer('required_points'); // required_points INT [cite: 78]
            $table->integer('stock'); // stock INT [cite: 83, 84]
            $table->timestamps(); // created_at & updated_at TIMESTAMP [cite: 87, 88, 89]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
