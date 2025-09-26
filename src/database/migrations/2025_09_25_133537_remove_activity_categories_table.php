<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['activity_category_id']);
            $table->dropColumn('activity_category_id');

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('activities')
                ->onDelete('cascade');
            $table->boolean('is_category')->default(true);

            $table->index(['parent_id']);
            $table->index('is_category');
        });

        DB::statement("
            INSERT INTO activities (name, is_category, created_at, updated_at)
            SELECT name, true, NOW(), NOW() FROM activity_categories
        ");

        Schema::dropIfExists('activity_categories');
    }

    public function down(): void
    {
        Schema::table('activity_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->foreign('activity_category_id')->references('id')->on('activity_categories');

            $table->dropColumn('is_category');
            $table->dropColumn('parent_id');
        });
    }
};
