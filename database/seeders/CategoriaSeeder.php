<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nome' => 'Aluguel', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Energia', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Internet', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Salário', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Investimento', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Rendimentos', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Telefone', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Alimentação', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Transporte', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Lazer', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Agua', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Plano de saúde', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Seguro', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Assinaturas streaming', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Academia', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Farmácia', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Carro', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Pet', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Transporte por app', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Combustível', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Cursos', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Viagem', 'padrao' => 'S', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
