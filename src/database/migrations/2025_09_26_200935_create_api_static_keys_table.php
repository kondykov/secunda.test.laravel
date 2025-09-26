<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('api_static_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('key');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_static_keys');
    }
};
