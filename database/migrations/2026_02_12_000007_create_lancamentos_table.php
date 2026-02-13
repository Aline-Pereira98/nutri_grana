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
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id('id_lancamento');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_mes')->constrained('meses', 'id_mes')->onDelete('cascade');
            $table->foreignId('id_categoria')->nullable()->constrained('categorias', 'id_categoria')->onDelete('set null');
            $table->foreignId('id_forma_pagamento')->constrained('forma_pagamentos', 'id_forma_pagamento')->onDelete('restrict');
            $table->enum('tipo_lancamento', ['R', 'D']);
            $table->string('descricao');
            $table->integer('valor');
            $table->date('data_pagamento')->nullable();
            $table->date('data_vencimento');
            $table->enum('essencial', ['S', 'N'])->default('N');
            $table->enum('parcelado', ['S', 'N'])->default('N');
            $table->integer('parcela_atual')->nullable();
            $table->integer('parcela_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lancamentos');
    }
};
