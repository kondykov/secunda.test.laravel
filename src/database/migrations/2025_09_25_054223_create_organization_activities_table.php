<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('organization_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations');
            $table->foreignId('activity_id')->constrained('activities');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_activities');
    }
};
