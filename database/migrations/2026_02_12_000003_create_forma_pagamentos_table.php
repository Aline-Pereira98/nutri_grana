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
        Schema::create('forma_pagamentos', function (Blueprint $table) {
            $table->id('id_forma_pagamento');
            $table->foreignId('id_usuario')->nullable()->constrained('usuario', 'id_usuario')->cascadeOnDelete();
            $table->string('nome', 100);
            $table->enum('tipo_forma_pagamento', ['P', 'C', 'B'])->comment('P = Pix / Dinheiro, C = Cartão de Crédito, B = Boleto'); 
            $table->enum('ativo', ['S', 'N'])->default('S');
            $table->timestamps();

            $table->unique(['id_usuario', 'nome']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forma_pagamentos');
    }
};
