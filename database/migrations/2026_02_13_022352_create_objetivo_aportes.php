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
        Schema::create('objetivos_aportes', function (Blueprint $table) {
            $table->id('id_objetivo_aportes');
            $table->foreignId('id_objetivo_financeiro')->constrained('objetivos_financeiros', 'id_objetivo_financeiro')->onDelete('cascade');
            $table->integer('valor_aporte');
            $table->foreignId('id_mes')->constrained('meses', 'id_mes')->onDelete('cascade');
            $table->date('data_aporte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos_aportes');
    }
};
