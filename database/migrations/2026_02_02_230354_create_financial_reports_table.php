<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();

            // Conteúdo do relatório
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');

            // Tipo do relatório (financeiro, balancete, auditoria, etc.)
            $table->string('type')->default('financial');

            // Datas de referência e controle
            $table->date('reference_month')->nullable(); // Ex: 2026-01-01
            $table->date('published_at')->nullable();
            $table->date('valid_until')->nullable();

            // Controle de publicação
            $table->boolean('is_published')->default(false);
            $table->foreignId('published_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Índices úteis
            $table->index(['type', 'is_published']);
            $table->index('reference_month');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
