<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Добавляем недостающие колонки
            if (!Schema::hasColumn('events', 'location')) {
                $table->string('location')->nullable();
            }
            if (!Schema::hasColumn('events', 'color')) {
                $table->string('color')->nullable();
            }
            if (!Schema::hasColumn('events', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['location', 'color', 'sort_order']);
        });
    }
};
