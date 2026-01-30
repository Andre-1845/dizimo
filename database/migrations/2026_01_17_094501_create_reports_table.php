<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Informações básicas
            $table->string('title');
            $table->text('description')->nullable();

            // Arquivo
            $table->string('file_path');
            $table->string('original_filename')->nullable();
            $table->integer('file_size')->nullable(); // Em bytes

            // Controle de acesso
            $table->date('available_until')->nullable();
            $table->boolean('is_active')->default(true);

            // Ordem de exibição
            $table->integer('sort_order')->default(0);

            // Tipo/categoria do relatório (opcional)
            $table->string('type')->default('general')->nullable();

            // Relacionamentos
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // Metadados
            $table->timestamp('published_at')->nullable();
            $table->integer('download_count')->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['is_active', 'available_until']);
            $table->index(['type', 'is_active']);
            $table->index('sort_order');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
