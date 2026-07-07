<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // tanpa FK, lihat catatan sebelumnya
            $table->string('route_name')->nullable(); // nama route, misal "categories.index"
            $table->string('url');                    // path lengkap, misal "/categories"
            $table->string('method', 10);              // GET, POST, PUT, DELETE
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_logs');
    }
};