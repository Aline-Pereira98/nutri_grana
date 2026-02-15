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
        Schema::create('objetivos_financeiros', function (Blueprint $table) {
            $table->id('id_objetivo_financeiro');
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario')->onDelete('cascade');
            $table->enum('tipo_objetivo', ['P', 'R'])->comment('P = Pessoal, R = Reserva');
            $table->string('nome', 100);
            $table->text('descricao')->nullable();
            $table->integer('valor_objetivo_financeiro');
            $table->integer('valor_objetivo_financeiro_atual')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objetivos_financeiros');
    }
};