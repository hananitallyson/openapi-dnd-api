<?php

namespace Database\Seeders;

use App\Models\Arma;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Arma::factory()->create([
            'index' => 'espada-longa',
            'nome' => 'Espada Longa',
            'alcance' => 5,
            'dano' => '1d8',
            'tipo_de_dano' => 'Cortante',
            'propriedade' => 'Versátil',
        ]);

        Arma::factory()->create([
            'index' => 'espada-curta',
            'nome' => 'Espada Curta',
            'alcance' => 5,
            'dano' => '1d6',
            'tipo_de_dano' => 'Perfurante',
            'propriedade' => 'Leve',
        ]);
    }
}
