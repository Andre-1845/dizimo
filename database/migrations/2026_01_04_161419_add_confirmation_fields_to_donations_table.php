<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->boolean('is_confirmed')
                ->default(false)
                ->after('receipt_path');

            $table->timestamp('confirmed_at')
                ->nullable()
                ->after('is_confirmed');

            $table->foreignId('confirmed_by')
                ->nullable()
                ->after('confirmed_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn([
                'is_confirmed',
                'confirmed_at',
                'confirmed_by',
            ]);
        });
    }
};
