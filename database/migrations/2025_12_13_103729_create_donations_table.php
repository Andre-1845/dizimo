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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // quem doou
            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            // quem registrou (admin / tesoureiro)
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // categoria financeira (dízimo, oferta etc.)
            $table->foreignId('category_id')
                ->constrained();

            $table->decimal('amount', 10, 2);
            $table->date('donation_date');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

// member_id → transparência de quem contribuiu
// user_id → auditoria (quem lançou)
// category_id → relatórios financeiros
// amount + date → base do dashboard

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
