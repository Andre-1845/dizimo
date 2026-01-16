<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar se as colunas já existem antes de adicionar
        if (!Schema::hasColumn('expenses', 'is_approved')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->boolean('is_approved')->default(false)->after('amount');
            });
        }

        if (!Schema::hasColumn('expenses', 'approved_by')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->after('is_approved');
            });
        }

        if (!Schema::hasColumn('expenses', 'approved_at')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verificar se as colunas existem antes de remover
        if (Schema::hasColumn('expenses', 'approved_by')) {
            Schema::table('expenses', function (Blueprint $table) {
                // Remover a foreign key
                $table->dropForeign(['approved_by']);
            });
        }

        // Remover colunas se existirem
        Schema::table('expenses', function (Blueprint $table) {
            $columns = ['is_approved', 'approved_by', 'approved_at'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('expenses', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
