<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_activities', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Ex: Santa Missa, Grupo Jovem
            $table->string('day');  // Ex: Domingo, Quarta-feira
            $table->string('time'); // Ex: 19h, 08h às 10h

            $table->string('email')->nullable(); // contato do grupo
            $table->string('schedule_link')->nullable(); // agendamento (confissão)

            $table->integer('order')->default(0); // ordem de exibição
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_activities');
    }
};
