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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')
                ->nullable()
                ->after('guard_name');
            $table->string('group')
                ->nullable()
                ->index()
                ->after('display_name');
            $table->string('description')
                ->nullable()
                ->after('group');
            $table->integer('order')
                ->default(0)
                ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
};
