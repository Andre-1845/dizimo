<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_people', function (Blueprint $table) {
            $table->id();

            $table->string('name');              // Nome da pessoa
            $table->string('role');              // Função (Padre, Diácono, Secretária, etc.)
            $table->text('description')->nullable(); // Descrição opcional
            $table->string('photo_path')->nullable(); // Foto (storage)

            $table->integer('order')->default(0); // Ordem de exibição
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_people');
    }
};
