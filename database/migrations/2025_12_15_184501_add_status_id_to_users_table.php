<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1️⃣ cria a coluna com default
            $table->unsignedBigInteger('status_id')
                ->default(1)
                ->after('id');
        });

        Schema::table('users', function (Blueprint $table) {
            // 2️⃣ cria a foreign key
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->restrictOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
