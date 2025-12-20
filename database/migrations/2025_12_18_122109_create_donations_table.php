<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            /**
             * Relacionamentos (histórico / auditoria)
             */

            // Quem contribuiu (membro)
            $table->foreignId('member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Quem registrou (admin / tesoureiro)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Categoria financeira (dízimo, oferta etc.)
            $table->foreignId('category_id')
                ->constrained();

            // Forma de pagamento
            $table->foreignId('payment_method_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /**
             * Snapshot histórico (imutável)
             */
            $table->string('donor_name');

            /**
             * Dados financeiros
             */
            $table->decimal('amount', 10, 2);
            $table->date('donation_date');

            /**
             * Auditoria / anexos
             */
            $table->text('notes')->nullable();
            $table->string('receipt_path')->nullable();

            /**
             * Controle
             */
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
