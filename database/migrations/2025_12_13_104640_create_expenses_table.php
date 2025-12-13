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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // categoria da despesa (água, luz, manutenção, etc.)
            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            // usuário que lançou a despesa
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->date('expense_date');

            $table->string('description');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

// category_id reutiliza a tabela categories
// restrictOnDelete() evita apagar categoria com despesa vinculada
// user_id mantém rastreabilidade
// description ajuda na leitura rápida no dashboard

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
